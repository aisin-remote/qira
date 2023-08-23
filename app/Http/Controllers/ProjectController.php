<?php

namespace App\Http\Controllers;

use App\Models\ItemCheckProject;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        // Your logic to fetch and display the list of resources
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
                            $documentPath = $document->store('documents');
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
