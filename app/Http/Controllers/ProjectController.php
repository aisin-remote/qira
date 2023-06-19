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
        return view('project');
    }
    public function detail($id)
    {
 
        return view('project.detail');
    }
    public function tambah()
    {
        return view('project.tambah');
    }
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            //create project then get id
            $project = Project::create([
                'line' => $request->line,
                'nama' => $request->nama,
                'deadline' => $request->deadline
            ]);
            //request to array
            $items = $request->items;
           
            foreach($items as $key => $value){
                $items[$key]['id_project'] = $project->id;
                $items[$key]['status'] = "0";
            }
            //create project detail
            $res = ProjectDetail::insert($items);
            if($res){
                DB::commit();
                return redirect()->route('project')->with('message', 'Project berhasil ditambahkan');
            }else{
                DB::rollback();
                return redirect()->route('project')->with('message', 'Project gagal ditambahkan');
            }
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('project')->with('message', $e->getMessage());
        }
    }
}
