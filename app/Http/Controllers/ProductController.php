<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'line' => 'required',
            'start_date' => 'required',
            'planning_finished' => 'required',
            'target_check' => 'required',
            'finish_check' => 'required',
            'document' => 'required',
        ]);

        $product = new Product();
        $product->model  = $request->input('model');
        $product->line  = $request->input('line');
        $product->start_date  = $request->input('start_date');
        $product->planning_finished  = $request->input('planning_finished');
        $product->target_check  = $request->input('target_check');
        $product->finish_check  = $request->input('finish_check');
        $document = $request->file('document');
        if ($document->isValid()) {
            // Ambil nama asli file dokumen
            $originalFileName = $document->getClientOriginalName();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $product->model . '_' . $originalFileName);

            $product->document = $documentPath;
        } else {
            return back()->withErrors(["document" => 'Dokumen tidak valid'])->withInput();
        }
        if ($product->finish_check < $product->target_check){
            $product->status = 'On Progress';
        } elseif ($product->finish_check == $product->target_check) {
            $product->status = 'Finished';
        }  else {
            $product->status = 'Input Salah';
        }

        $product->save();

        return redirect()->route('product.check')->with('success', 'Product berhasil disimpan');
    }
}
