<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pica;
use Illuminate\Support\Facades\Storage;

class PicaController extends Controller
{
    public function index()
    {
        $customerProblemData = Pica::where('tipe', 'CUSTOMER/SUPPLIER PROBLEM')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        $internalProblemData = Pica::where('tipe', 'INTERNAL PROBLEM')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view("pica.picaForm", compact('customerProblemData', 'internalProblemData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'shift' => 'required|string',
            'jam' => 'required',
            'tempat' => 'required|string',
            'part_number' => 'required|string',
            'nama_produk' => 'required|string',
            'konten_problem' => 'required|string',
            'sumber_informasi' => 'required|string',
            'status' => 'required|string',
            'sudah_sortir' => 'required|string',
            'quantity_sortir' => 'required|string',
            'kondisi_sortir_area' => 'required|string',
            'PIC' => 'required|string',
            'penyebab' => 'required|string',
            'countermeasure' => 'required|string',
            'data_verifikasi' => 'required',
            'tipe' => 'required|string'
        ]);

        $pica = new Pica();

        // Isi kolom-kolom dalam model Pica sesuai dengan data yang ingin disimpan
        $pica->tanggal = $request->input('tanggal');
        $pica->shift = $request->input('shift');
        $pica->jam = $request->input('jam');
        $pica->tempat = $request->input('tempat');
        $pica->part_number = $request->input('part_number');
        $pica->nama_produk = $request->input('nama_produk');
        $pica->konten_problem = $request->input('konten_problem');
        $pica->sumber_informasi = $request->input('sumber_informasi');
        $pica->status = $request->input('status');
        $pica->sudah_sortir = $request->input('sudah_sortir');
        $pica->quantity_sortir = $request->input('quantity_sortir');
        $pica->kondisi_sortir_area = $request->input('kondisi_sortir_area');
        $pica->PIC = $request->input('PIC');
        $pica->penyebab = $request->input('penyebab');
        $pica->countermeasure = $request->input('countermeasure');
        $pica->tipe = $request->input('tipe');

        if ($request->hasFile('data_verifikasi')) {
            $document = $request->file('data_verifikasi');
            // Ambil nama asli file dokumen
            $originalFileName = $document->getClientOriginalName();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $pica->nama_produk . '_' . $originalFileName);

            $pica->data_verifikasi = $documentPath;
        }

        // Simpan data ke dalam database
        $pica->save();

        return redirect()->route('pica.index')->with('success', 'Data Pica berhasil disimpan.');
    }

    public function edit($id)
    {
        // Mengambil data PICA berdasarkan ID
        $pica = Pica::findOrFail($id);

        return view('pica.editPica', compact('pica'));
    }

    public function update(Request $request, $id)
    {
        $pica = Pica::findOrFail($id);
        // Isi kolom-kolom dalam model Pica sesuai dengan data yang ingin disimpan
        $pica->tanggal = $request->input('tanggal');
        $pica->shift = $request->input('shift');
        $pica->jam = $request->input('jam');
        $pica->tempat = $request->input('tempat');
        $pica->part_number = $request->input('part_number');
        $pica->nama_produk = $request->input('nama_produk');
        $pica->konten_problem = $request->input('konten_problem');
        $pica->sumber_informasi = $request->input('sumber_informasi');
        $pica->status = $request->input('status');
        $pica->sudah_sortir = $request->input('sudah_sortir');
        $pica->quantity_sortir = $request->input('quantity_sortir');
        $pica->kondisi_sortir_area = $request->input('kondisi_sortir_area');
        $pica->PIC = $request->input('PIC');
        $pica->penyebab = $request->input('penyebab');
        $pica->countermeasure = $request->input('countermeasure');

        if ($request->hasFile('data_verifikasi')) {
            $document = $request->file('data_verifikasi');
            // Ambil nama asli file dokumen
            $originalFileName = $document->getClientOriginalName();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $pica->nama_produk . '_' . $originalFileName);

            $pica->data_verifikasi = $documentPath;
        }

        // Simpan data ke dalam database
        $pica->save();

        return redirect()->route('pica.index')->with('success', 'Data Pica berhasil diubah.');
    }

    public function delete($id)
    {
        try {
            $pica = Pica::findOrFail($id);

            if ($pica->data_verifikasi) {
                // Delete associated data_verifikasi file from storage
                Storage::delete($pica->data_verifikasi);
            }

            $pica->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }
}
