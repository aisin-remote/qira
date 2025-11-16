<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input dari form
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Buat kueri untuk mengambil produk berdasarkan range bulan
        $productsQuery = Product::query();

        if ($startDate && $endDate) {
            $productsQuery->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('planning_finished', [$startDate, $endDate])
                    ->orWhereBetween('start_date', [$startDate, $endDate]);
            });
        }

        $products = $productsQuery->get();

        // Lakukan filter untuk masing-masing line
        $asProducts = $products->filter(function ($product) {
            return strpos($product->line, 'AS') !== false;
        })->values();
        $maProducts = $products->filter(function ($product) {
            return strpos($product->line, 'MA') !== false;
        })->values();
        $dcProducts = $products->filter(function ($product) {
            return strpos($product->line, 'DC') !== false;
        })->values();

        // Kirim data ke tampilan
        return view('prod.productReport', compact('products', 'asProducts', 'maProducts', 'dcProducts', 'startDate', 'endDate'));
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
            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $originalFileName);

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

        // update field utama
        $product->model             = $request->input('model');
        $product->line              = $request->input('line');
        $product->start_date        = $request->input('start_date');
        $product->planning_finished = $request->input('planning_finished');
        $product->target_check      = $request->input('target_check');
        $product->finish_check      = $request->input('finish_check');

        // upload dokumen baru (kalau ada)
        // NOTE: ini versi kamu yang terakhir (documents, disk public)
        if ($request->hasFile('document')) {
            $document         = $request->file('document');
            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

            // hasil di DB: "documents/xxxx.xlsx"
            $documentPath = $document->storeAs('documents', $originalFileName, 'public');
            $product->document = $documentPath;
        }

        // status
        if ($product->finish_check < $product->target_check) {
            $product->status = 'On Progress';
        } elseif ($product->finish_check == $product->target_check) {
            $product->status = 'Finished';
        } else {
            $product->status = 'Input Salah';
        }

        // approval
        $posisi = auth()->user()->posisi;

        if ($posisi === 'SPV') {
            $product->approval = 'Approved by SPV';
        } elseif ($posisi === 'Manajer') {
            $product->approval = 'Approved by Manager';
        } else {
            // untuk LDR / JP / Sub JP atau lainnya, bebas
            $product->approval = $request->input('approval');
        }

        $product->save();

        // Tambah tanda tangan ke Excel (kalau ada dokumen)
        if (!empty($product->document)) {
            $this->addSignatureToExcel($product, $posisi);
        }

        return redirect()->to(url()->previous())
            ->with('success', 'Product updated successfully!');
    }

    protected function addSignatureToExcel(Product $product, string $posisi): void
    {
        // mapping posisi -> label header + file tanda tangan
        $mapping = [
            'Manajer' => [
                'label' => 'Approved by MGR',
                'file'  => storage_path('app/public/signatures/mgr.png'),
                'target_cell' => 'Y17' // Exact cell for Manager signature
            ],
            'SPV' => [
                'label' => 'Approved by SPV', 
                'file'  => storage_path('app/public/signatures/spv.png'),
                'target_cell' => 'AC17' // Exact cell for SPV signature
            ],
            'LDR' => [
                'label' => 'Checked by LDR',
                'file'  => storage_path('app/public/signatures/ldr.png'),
                'target_cell' => 'AE17' // Exact cell for LDR signature
            ],
            'JP' => [
                'label' => 'Prepared by',
                'file'  => storage_path('app/public/signatures/prepared.png'),
                'target_cell' => 'AI17' // Exact cell for JP/Sub JP signature
            ],
            'Sub JP' => [
                'label' => 'Prepared by',
                'file'  => storage_path('app/public/signatures/prepared.png'),
                'target_cell' => 'AI17' // Same cell for Sub JP
            ],
        ];

        if (!isset($mapping[$posisi])) {
            return;
        }

        // ===== Normalisasi path Excel dari DB =====
        $storedPath = $product->document ?? '';
        if ($storedPath === '') {
            return;
        }

        $storedPath = ltrim($storedPath, '/');
        $storedPath = str_replace('public/', '', $storedPath);
        $storedPath = str_replace('//', '/', $storedPath);

        // path fisik: storage/app/public/documents/xxxx.xlsx
        $excelPath = Storage::disk('public')->path($storedPath);
        if (!file_exists($excelPath)) {
            return;
        }

        $signPath = $mapping[$posisi]['file'];
        if (!file_exists($signPath)) {
            return;
        }

        // Load workbook
        $spreadsheet = IOFactory::load($excelPath);
        $sheet = $spreadsheet->getActiveSheet();

        // ========== USE PREDEFINED CELL POSITIONS ==========
        $targetCell = $mapping[$posisi]['target_cell'];

        // Verify the label exists in the expected position (for validation)
        $labelRow = 16; // Row where the labels are located
        $labelColumn = substr($targetCell, 0, -2); // Get column from target cell (Y, AC, AE, AI)
        
        $expectedLabel = $mapping[$posisi]['label'];
        $actualLabel = trim((string) $sheet->getCell($labelColumn . $labelRow)->getValue());
        
        // Optional: Validate that we're placing in the right spot
        if ($actualLabel !== $expectedLabel) {
            \Log::warning("Signature placement validation failed for {$posisi}. Expected: '{$expectedLabel}', Found: '{$actualLabel}'");
            // You can choose to continue or return here based on your needs
        }

        // ========== TAMBAHKAN GAMBAR DI CELL YANG DITENTUKAN ==========

        $drawing = new Drawing();
        $drawing->setPath($signPath);
        $drawing->setCoordinates($targetCell);
        $drawing->setOffsetX(2);
        $drawing->setOffsetY(2);
        $drawing->setHeight(35);   // Appropriate height for signature box
        $drawing->setWorksheet($sheet);

        // Adjust row height to accommodate signature better
        $row = 17; // Signature row
        $sheet->getRowDimension($row)->setRowHeight(30);

        // Simpan kembali file
        $ext = strtolower(pathinfo($excelPath, PATHINFO_EXTENSION));
        $writerType = $ext === 'xls' ? 'Xls' : 'Xlsx';

        $writer = IOFactory::createWriter($spreadsheet, $writerType);
        $writer->save($excelPath);

        \Log::info("Signature successfully placed for {$posisi} at cell: {$targetCell}");
    }

    /**
    * Find the exact cell for signature placement
    */
    private function findSignatureCell($sheet, $labelTarget, $range): ?string
    {
        for ($row = $range['startRow']; $row <= $range['endRow']; $row++) {
            for ($col = $range['startCol']; $col <= $range['endCol']; $col++) {
                $columnLetter = Coordinate::stringFromColumnIndex($col);
                $coordinate = $columnLetter . $row;
                $cellValue = trim((string) $sheet->getCell($coordinate)->getValue());

                // Exact match (case sensitive)
                if ($cellValue === $labelTarget) {
                    // Based on your template structure, signature goes in the cell below the label
                    return $columnLetter . ($row + 1);
                }
            }
        }
        
        return null;
    }

    /**
    * Fallback positions based on your Excel template structure
    */
    private function getFallbackPosition(string $posisi): ?string
    {
        $fallbackPositions = [
            'Manajer' => 'Y30', // Adjust based on your actual template
            'SPV' => 'AC30',    // Adjust based on your actual template  
            'LDR' => 'AE30',    // Adjust based on your actual template
            'JP' => 'AI30',     // Adjust based on your actual template
            'Sub JP' => 'AI30', // Adjust based on your actual template
        ];

        return $fallbackPositions[$posisi] ?? null;
    }

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->document) {
                Storage::delete($product->document);
            }

            $product->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }
}
