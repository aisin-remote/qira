<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDetail;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        //get project and corresponding project detail
        $projects = Project::get();
        foreach ($projects as $key => $value) {
            $projects[$key]->total = $value->details()->count();
            $projects[$key]->done = $value->details()->where('status', '1')->count();
            //if done/total < 50 % then red, if done/total < 75 % then yellow, else green
            $projects[$key]->color = ($projects[$key]->done / $projects[$key]->total < 0.5) ? 'red' : (($projects[$key]->done / $projects[$key]->total < 0.75) ? 'yellow' : 'green');

        }
        return view('project', compact('projects'));
    }
    public function detail($id, Request $request)
    {
        $project = Project::find($id);
        return view('project.detail', compact('project'));
    }
    public function tambah()
    {
        return view('project.tambah');
    }
    public function store(Request $request)
    {
        $request->validate([
            'line' => 'required',
            'nama' => 'required',
            'planningMassPro' => 'required|date',
            'items' => 'required|array',
            'items.*.itemCheck' => 'required',
            'items.*.start' => 'required|date',
            'items.*.deadline' => 'required|date',
        ]);
        try {
            DB::beginTransaction();
            //create project then get id
            $project = Project::create([
                'line' => $request->line,
                'nama' => $request->nama,
                'planningMassPro' => date('Y-m-d 23:59:00', strtotime($request->planningMassPro))
            ]);
            //request to array
            $items = $request->items;

            foreach ($items as $key => $value) {
                $items[$key]['id_project'] = $project->id;
                $items[$key]['status'] = "0";
            }
            //create project detail
            $res = ProjectDetail::insert($items);
            if ($res) {
                DB::commit();
                return redirect()->route('project')->with('message', 'Project berhasil ditambahkan');
            } else {
                DB::rollback();
                return redirect()->route('project')->with('message', 'Project gagal ditambahkan');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project')->with('message', $e->getMessage());
        }
    }
    public function updateStatus($projectid, Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|in:0,1',
                'id' => 'required|exists:tt_project_detail,id'
            ]);
        }
        //catch validation error
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        try {
            DB::beginTransaction();
            //update project detail
            $res = ProjectDetail::where('id_project', $projectid)->update([
                'status' => $request->status,
                'id' => $request->id
            ]);
            if ($res) {
                DB::commit();
                //return 200 ok
                return response()->json(['message' => 'Status berhasil diupdate'], 200);
            } else {
                DB::rollback();
                //return 500 internal server error
                return response()->json(['message' => 'Status gagal diupdate'], 500);
            }
        } catch (\Exception $e) {
            DB::rollback();
            //return 500 internal server error
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function uploadDocument($projectid, Request $request)
    {


        $request->validate([
            'id' => 'required|exists:tt_project_detail,id',
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        //save file to storage and save file to database
        $file = $request->file('file');
        //get file name without extension
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //get extension then add to filename
        $filename = $filename . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public', 'project/'.$request->id.'/'.$filename);
        $res = ProjectDetail::where('id_project', $projectid)->update([
            'document' => $filename,
            'id' => $request->id
        ]);
        if ($res) {
            return redirect()->route('project.detail', $projectid)->with('message', 'File berhasil diupload');
        } else {
            return redirect()->route('project.detail', $projectid)->with('message', 'File gagal diupload');
        }
    }
}
