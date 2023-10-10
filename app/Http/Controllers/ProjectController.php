<?php

namespace App\Http\Controllers;

use App\Models\ItemCheckProject;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SebastianBergmann\Type\NullType;

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
                            // Ambil nama asli file dokumen
                            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

                            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
                            $documentPath = $document->storeAs('public/documents/', $itemData['nama'] . '_' . $originalFileName);

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

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('proj.editProject', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // dd($request->all());

        // Update project details if needed
        $project->line = $request->input('line');
        $project->pcr = $request->input('nama');
        $project->planning_masspro = $request->input('deadline');
        $project->save();

        // Check if 'items' are present in the request
        if ($request->has('items')) {
            foreach ($request->input('items') as $index => $itemData) {
                if ($index < count($project->itemCheckProjects)) {
                    // Update existing item
                    $item = $project->itemCheckProjects[$index];
                    // Update item check details
                    $item->item_check = $itemData['nama'];
                    $item->start = $itemData['start'];
                    $item->finished = $itemData['deadline'];
                    $item->status = $itemData['status'];

                    // Handle document update if needed
                    if ($itemData['status'] === 'finished') {
                        if ($request->hasFile("items.{$index}.dokumen")) {
                            $document = $request->file("items.{$index}.dokumen");

                            // Check if the uploaded document is valid
                            if ($document->isValid()) {
                                // Ambil nama asli file dokumen
                                $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

                                // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
                                $documentPath = $document->storeAs('public/documents/', $itemData['nama'] . '_' . $originalFileName);

                                $item->document = $documentPath;
                            } else {
                                return back()->withErrors(["items.{$index}.dokumen" => 'Invalid document'])->withInput();
                            }
                        }
                    }

                    if (isset($itemData['approval']) && !empty($itemData['approval'])) {
                        $item->approval = $itemData['approval'];
                    } elseif (!empty($item->approval)) {
                        // Jika data approval sudah ada dalam database, gunakan nilai yang sudah ada
                        $item->approval = $item->approval;
                    } else {
                        $item->approval = 'Waiting ...';
                    }

                    $item->save();
                } else {
                    // Create a new item
                    $newItem = new ItemCheckProject();
                    $newItem->project_id = $project->id;
                    $newItem->item_check = $itemData['nama'];
                    $newItem->start = $itemData['start'];
                    $newItem->finished = $itemData['deadline'];
                    $newItem->status = $itemData['status'];

                    // Handle document update if needed
                    if ($itemData['status'] === 'finished' && $request->hasFile("items.{$index}.dokumen")) {
                        $document = $request->file("items.{$index}.dokumen");

                        // Check if the uploaded document is valid
                        if ($document->isValid()) {
                            // Ambil nama asli file dokumen
                            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();
                            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
                            $documentPath = $document->storeAs('public/documents/', $itemData['nama'] . '_' . $originalFileName);

                            $newItem->document = $documentPath;
                        } else {
                            return back()->withErrors(["items.{$index}.dokumen" => 'Invalid document'])->withInput();
                        }
                    }

                    if (isset($itemData['approval']) && !empty($itemData['approval'])) {
                        $newItem->approval = $itemData['approval'];
                    } elseif (!empty($newItem->approval)) {
                        // Jika data approval sudah ada dalam database, gunakan nilai yang sudah ada
                        $newItem->approval = $newItem->approval;
                    } else {
                        $newItem->approval = 'Waiting ...';
                    }

                    $newItem->save();
                }
            }
        }

        // Redirect the user back to the project report page with a success message
        return redirect()->route('project.report')->with('success', 'Project updated successfully.');
    }

    public function deleteItemDetail(Request $item_id)
    {
        try {
            $project = ItemCheckProject::findOrFail($item_id->id);

            if ($project->document) {
                Storage::delete($project->document);
            }

            $project->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }

    public function deleteItem(Request $id)
    {
        try {
            $project = Project::findOrFail($id->id);

            foreach ($project->itemCheckProjects as $itemCheckProject) {
                if ($itemCheckProject->document) {
                    Storage::delete($itemCheckProject->document);
                }
            }

            $project->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }
}
