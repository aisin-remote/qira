<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('planning_finished', '>=', Carbon::now()->subMonths(2))
            ->where('planning_finished', '<=', Carbon::now()->addMonths(2))
            ->get();

        return view('prod.productReport', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'line' => 'required',
            'start_date' => 'required',
            'planning_finished' => 'required',
            'target_check' => 'required',
            'finish_check' => 'required',
            'document' => 'nullable',
        ]);

        $product = new Product();
        $product->model  = $request->input('model');
        $product->line  = $request->input('line');
        $product->start_date  = $request->input('start_date');
        $product->planning_finished  = $request->input('planning_finished');
        $product->target_check  = $request->input('target_check');
        $product->finish_check  = $request->input('finish_check');
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            // Ambil nama asli file dokumen
            $originalFileName = $document->getClientOriginalName();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $product->model . '_' . $originalFileName);

            $product->document = $documentPath;
        }

        if ($product->finish_check < $product->target_check) {
            $product->status = 'On Progress';
        } elseif ($product->finish_check == $product->target_check) {
            $product->status = 'Finished';
        } else {
            $product->status = 'Input Salah';
        }

        $product->save();

        return redirect()->route('product.check')->with('success', 'Product berhasil disimpan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('prod.editProduct', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->model = $request->input('model');
        $product->line = $request->input('line');
        $product->start_date = $request->input('start_date');
        $product->planning_finished = $request->input('planning_finished');
        $product->target_check = $request->input('target_check');
        $product->finish_check = $request->input('finish_check');

        // Check if a new document is uploaded
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $originalFileName = $document->getClientOriginalName();
            $documentPath = $document->storeAs('public/documents/', $product->model . '_' . $originalFileName);
            $product->document = $documentPath;
        }

        // Determine status based on finish_check and target_check
        if ($product->finish_check < $product->target_check) {
            $product->status = 'On Progress';
        } elseif ($product->finish_check == $product->target_check) {
            $product->status = 'Finished';
        } else {
            $product->status = 'Input Salah';
        }

        $product->save();

        return redirect()->route('product.report')->with('success', 'Product updated successfully.');
    }
}
