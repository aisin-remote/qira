<?php

namespace App\Exports;

use App\Models\ProblemData;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 


class ProblemDataExport
{
    public function export()
    {
        // Ambil semua data dari model ProblemData
        $data = ProblemData::all();


        // Simpan file Excel ke disk
        $writer = new Xlsx($spreadsheet);
        $filePath = public_path('exports/pica_data.xlsx');
        $writer->save($filePath);

        return $filePath; // Return path ke file yang sudah diekspor
    }
}
