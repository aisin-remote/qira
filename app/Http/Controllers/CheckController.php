<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index($id,Request $request)
    {
        $tanggal = $request->get('bulan') ? $request->get('bulan') : date('Y-m-d');
        $checkList = Data::where('id_product', $id)->whereMonth('start', date('m',strtotime($tanggal)))->whereYear('start', date('Y',strtotime($tanggal)))->get();
        $checkId = $id;
        return view('check', compact('checkList','checkId'));
    }
    public function tambah($id, Request $request)
    {
        $checkId = $id;
        return view('check.tambah', compact('checkId'));
    }
    public function store($id, Request $request)
    {

    }
}
