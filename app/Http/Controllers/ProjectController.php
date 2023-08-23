<?php

namespace App\Http\Controllers;

use App\Models\ItemCheckProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('itemCheckProjects')
            ->where('planning_masspro', '>=', Carbon::now()->subMonths(3))
            ->get();

        $statusCounts = $this->getStatusCounts($projects);
        $projectStatuses = $this->getProjectStatuses($projects);

        return view('proj.projectReport', compact('projects', 'statusCounts', 'projectStatuses'));
    }


    public function getProjectStatuses($projects)
    {
        $projectStatuses = [];

        foreach ($projects as $project) {
            $finishedCount = 0;
            $totalCount = count($project->itemCheckProjects);

            foreach ($project->itemCheckProjects as $item) {
                if ($item->status === 'finished') {
                    $finishedCount++;
                }
            }

            $percentageFinished = ($totalCount > 0) ? round(($finishedCount / $totalCount) * 100) : 0;
            $percentageOnProgress = 100 - $percentageFinished;

            $projectStatuses[$project->id] = [
                'percentage_finished' => $percentageFinished,
                'percentage_onprogress' => $percentageOnProgress,
            ];
        }

        return $projectStatuses;
    }

    public function getStatusCounts($projects)
    {
        $statusCounts = [
            'finished' => 0,
            'onprogress' => 0,
        ];

        foreach ($projects as $project) {
            foreach ($project->itemCheckProjects as $item) {
                if ($item->status === 'finished') {
                    $statusCounts['finished']++;
                } else {
                    $statusCounts['onprogress']++;
                }
            }
        }

        return $statusCounts;
    }

    public function store(Request $request)
    {
        $request->validate([
            // Add validation rules for other fields
            'line' => 'required',
            'nama' => 'required',
            'deadline' => 'required',
            'items.*.nama' => 'required',
            'items.*.start' => 'required',
            'items.*.deadline' => 'required',
            'items.*.status' => 'required',
            'items.*.dokumen' => 'nullable',
        ]);

        $project = new Project();
        $project->line = $request->input('line');
        $project->pcr = $request->input('nama');
        $project->planning_masspro = $request->input('deadline');
        $project->save();

        if ($request->has('items') && is_array($request->input('items'))) {
            foreach ($request->input('items') as $index => $itemData) {
                $itemCheckProject = new ItemCheckProject();
                $itemCheckProject->project_id = $project->id;
                $itemCheckProject->item_check = $itemData['nama'];
                $itemCheckProject->start = $itemData['start'];
                $itemCheckProject->finished = $itemData['deadline'];
                $itemCheckProject->status = $itemData['status'];

                if ($itemData['status'] === 'finished') {
                    if ($request->hasFile("items.{$index}.dokumen")) {
                        $document = $request->file("items.{$index}.dokumen");
                        if ($document->isValid()) {
                            $documentPath = $document->store('public');
                            $itemCheckProject->document = $documentPath;
                        } else {
                            return back()->withErrors(["items.{$index}.dokumen" => 'Dokumen tidak valid'])->withInput();
                        }
                    } else {
                        return back()->withErrors(["items.{$index}.dokumen" => 'Dokumen harus diunggah'])->withInput();
                    }
                }
                $itemCheckProject->save();
            }
        }

        return redirect()->route('project.check')->with('success', 'Project berhasil disimpan');
    }
}
