<?php

namespace App\Http\Controllers;

use App\Models\Pica;
use App\Models\DocumentPica;
use App\Models\PenangananStock;
use App\Models\QualityReport;
use App\Models\DocumentQualityInternal;
use App\Models\PenangananInternals;
use App\Models\QualityInternal;
use App\Models\CustomerProblem;
use App\Models\DocumentQualityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;


class PicaController extends Controller
{
    public function showPica()
    {
        $user = Auth::user();

        if ($user->department == 'quality unit') {
            return view('pica.picaForm');
        } elseif ($user->department == 'quality body') {
            $customerProblemData = [];
            $internalProblemData = [];
            return view('pica.customer', compact('customerProblemData'))
                ->with('internalProblemData', $internalProblemData);
        } else {
            abort(403, 'Access denied');
        }
    }

    public function showCustomerData()
    {
    $customerProblemData = QualityReport::all();
    return view('pica.customer', compact('customerProblemData'));
    }

    public function documentQualityReports()
    {
    return $this->hasMany(DocumentQualityReport::class, 'id_quality_report', 'id');
    }

    public function documentQualityInternals()
    {
    return $this->hasMany(DocumentQualityInternal::class, 'id_quality_internal', 'id');
    }




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

    public function customer(Request $request)
    {
        $customerIssues = QualityReport::orderBy('tanggal', 'desc')->get();

        if ($request->has('export')) {
            $data = $customerIssues;
            $photoPath = storage_path('app/images/customer_photo.jpg');

            return $this->exportToExcelTemplate($data, 'pica_data.xlsx', $photoPath);
        }

        return view("pica.picaCustomer", compact('customerIssues'));
    }

    public function internal(Request $request)
    {
        $internalIssues = QualityInternal::orderBy('tanggal', 'desc')->get();

        if ($request->has('export')) {
            $data = $internalIssues;
            $photoPath = storage_path('app/images/internal_photo.jpg');

            return $this->exportToExcelTemplate($data, 'pica_data.xlsx', $photoPath);
        }

        return view("pica.picaInternal", compact('internalIssues'));
    }




public function storeCustomer(Request $request)
{

    $request->validate([
        'tanggal' => 'required',
        'section' => 'required',
        'line' => 'required|string',
        'model' => 'required|string',
        'part_name' => 'required|string',
        'problem' => 'required|string',
        'quantity' => 'required|integer',
        'standard' => 'required|string',
        'actual' => 'required|string',
        'visual_ok' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'visual_ng' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'measurement_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'qty.*' => 'nullable|integer',
        'ok.*' => 'nullable|integer',
        'ng.*' => 'nullable|integer',
        'pic.*' => 'nullable|string',
        'problem_analysis' => 'required|string',
        'occure.*' => 'nullable|string',
        'outflow.*' => 'nullable|string',
        'temporary.*.activity' => 'nullable|string',
        'temporary.*.pic' => 'nullable|string',
        'temporary.*.due_date' => 'nullable|date',
        'temporary.*.status' => 'nullable|string',
        'corrective.*.activity' => 'nullable|string',
        'corrective.*.pic' => 'nullable|string',
        'corrective.*.due_date' => 'nullable|date',
        'corrective.*.status' => 'nullable|string',
    ]);


    $qualityReport = new QualityReport();
    $qualityReport->tanggal = $request->input('tanggal');
    $qualityReport->section = $request->input('section');
    $qualityReport->line = $request->input('line');
    $qualityReport->modell = $request->input('model');
    $qualityReport->part_name = $request->input('part_name');
    $qualityReport->problem = $request->input('problem');
    $qualityReport->quantity = $request->input('quantity');
    $qualityReport->standard = $request->input('standard');
    $qualityReport->actual = $request->input('actual');
    $qualityReport->qty = json_encode($request->input('qty'));
    $qualityReport->ok = json_encode($request->input('ok'));
    $qualityReport->ng = json_encode($request->input('ng'));
    $qualityReport->pic = json_encode($request->input('pic'));
    $qualityReport->problem_analysis = $request->input('problem_analysis');
    $qualityReport->occure = $request->input('occure');
    $qualityReport->outflow = $request->input('outflow');
    $qualityReport->temporary_actions = json_encode($request->input('temporary'));
    $qualityReport->corrective_actions = json_encode($request->input('corrective'));



    if ($request->hasFile('visual_ok')) {
        $photoPath = $request->file('visual_ok');
        $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
        $visual_ok = $photoPath->storeAs('public/photos', $qualityReport->report . '_' . $originalFileName);
        $qualityReport->visual_ok = $visual_ok;
    }

    if ($request->hasFile('visual_ng')) {
        $photoPath = $request->file('visual_ng');
        $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
        $visual_ng = $photoPath->storeAs('public/photos', $qualityReport->report . '_' . $originalFileName);
        $qualityReport->visual_ng = $visual_ng;
    }

    if ($request->hasFile('measurement_photo')) {
        $photoPath = $request->file('measurement_photo');
        $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
        $measurement_photo = $photoPath->storeAs('public/photos', $qualityReport->report . '_' . $originalFileName);
        $qualityReport->measurement_photo = $measurement_photo;
    }

    $qualityReport->save();


     foreach ($request->qty as $index => $qty) {
        PenangananStock::create([
            'quality_report_id' => $qualityReport->id,
            'komponen' => 'Komponen',
            'qty' => $qty,
            'ok' => $request->ok[$index],
            'ng' => $request->ng[$index],
            'pic' => $request->pic[$index],
        ]);

    }


    return redirect()->route('pica.customer')->with('success', 'Data Customer/Supplier berhasil disimpan.');
}

public function downloadExcel($id)
{

    $qualityReport = QualityReport::findOrFail($id);
    $templatePath = public_path('storage/templates/TEMPLATE DAILY REPORT QUALITY SHEET.xlsx');
            if (!file_exists($templatePath)) {
                abort(404, 'Template file not found.');
    }

    $spreadsheet = new Spreadsheet();
    $spreadsheet = IOFactory::load($templatePath);
    $sheet = $spreadsheet->getActiveSheet();


    $sheet->setCellValue("F9", $qualityReport->tanggal);
    $sheet->getStyle("F9")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
    $sheet->setCellValue("F10", $qualityReport->section);
    $sheet->setCellValue("F11", $qualityReport->line);
    $sheet->setCellValue("F12", $qualityReport->modell);
    $sheet->setCellValue("F13", $qualityReport->part_name);
    $sheet->setCellValue("F14", $qualityReport->problem);
    $sheet->setCellValue("F15", $qualityReport->quantity);
    $sheet->getStyle("F15")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
    $sheet->setCellValue("V9", $qualityReport->standard);
    $sheet->setCellValue("AF9", $qualityReport->actual);
    $sheet->setCellValue("C32", $qualityReport->problem_analysis);

    $relativePhotoPath = $qualityReport->visual_ok;
    $photoPath = storage_path('app/' . $relativePhotoPath);


if (file_exists($photoPath)) {
    $drawing = new Drawing();
    $drawing->setName('Visual OK');
    $drawing->setDescription('Visual OK Image');
    $drawing->setPath($photoPath);
    $drawing->setHeight(50);
    $drawing->setWidth(215);
    $drawing->setCoordinates('T10');
    $drawing->setWorksheet($sheet);
} else {
    Log::error('Gambar tidak ditemukan di path: ' . $photoPath);
}

$relativePhotoPath = $qualityReport->visual_ng;
$photoPath = storage_path('app/' . $relativePhotoPath);


if (file_exists($photoPath)) {
    $drawing = new Drawing();
    $drawing->setName('Visual NG');
    $drawing->setDescription('Visual NG Image');
    $drawing->setPath($photoPath);
    $drawing->setHeight(50);
    $drawing->setWidth(215);
    $drawing->setCoordinates('AC10');
    $drawing->setWorksheet($sheet);
} else {
    Log::error('Gambar tidak ditemukan di path: ' . $photoPath);
}

$relativePhotoPath = $qualityReport->measurement_photo;
$photoPath = storage_path('app/' . $relativePhotoPath);


if (file_exists($photoPath)) {
    $drawing = new Drawing();
    $drawing->setName('Measurement Photo');
    $drawing->setDescription('Measurement Image');
    $drawing->setPath($photoPath);
    $drawing->setHeight(100);
    $drawing->setWidth(250);
    $drawing->setCoordinates('D20');
    $drawing->setWorksheet($sheet);
} else {
    Log::error('Gambar tidak ditemukan di path: ' . $photoPath);
}


    $sheet->setCellValue("H32", $qualityReport->occure[0]);
    $sheet->getStyle('H32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("N32", $qualityReport->occure[1]);
    $sheet->getStyle('N32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("T32", $qualityReport->occure[2]);
    $sheet->getStyle('T32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("Z32", $qualityReport->occure[3]);
    $sheet->getStyle('Z32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("AF32", $qualityReport->occure[4]);
    $sheet->getStyle('AF32')->getAlignment()->setTextRotation(0);

    $sheet->setCellValue("H38", $qualityReport->outflow[0]);
    $sheet->getStyle('H38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("N38", $qualityReport->outflow[1]);
    $sheet->getStyle('N38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("T38", $qualityReport->outflow[2]);
    $sheet->getStyle('T38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("Z38", $qualityReport->outflow[3]);
    $sheet->getStyle('Z38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("AF38", $qualityReport->outflow[4]);
    $sheet->getStyle('AF38')->getAlignment()->setTextRotation(0);


    $qtyData = json_decode($qualityReport->qty, true);
    $okData = json_decode($qualityReport->ok, true);
    $ngData = json_decode($qualityReport->ng, true);
    $picData = json_decode($qualityReport->pic, true);


    $startRow = 21;
    foreach ($qtyData as $index => $qty) {
        $row = $startRow + $index;
        $sheet->setCellValue("S$row", 'Komponen ' . ($index + 1));
        $sheet->setCellValue("Z$row", $qty);
        $sheet->setCellValue("AC$row", $okData[$index] ?? '');
        $sheet->setCellValue("AF$row", $ngData[$index] ?? '');
        $sheet->setCellValue("AI$row", $picData[$index] ?? '');
    }


    $sheet->setCellValue('Z28', '=SUM(Z21:Z26)');
    $sheet->setCellValue('AC28', '=SUM(AC21:AC26)');
    $sheet->setCellValue('AF28', '=SUM(AF21:AF26)');

    $temporaryActions = json_decode($qualityReport->temporary_actions, true);

    if ($temporaryActions) {
        $rowIndex = 47;
        foreach ($temporaryActions as $index => $action) {
            $row = $rowIndex + ($index * 2);
            $sheet->setCellValue("G$row", $action['activity'] ?? '');
            $sheet->setCellValue("AC$row", $action['pic'] ?? '');
            $sheet->setCellValue("AF$row", $action['due_date'] ?? '');
            $sheet->setCellValue("AI$row", $action['status'] ?? '');
        }
    }

    $correctiveActions = json_decode($qualityReport->corrective_actions, true);

    if ($correctiveActions) {
        $rowIndex = 55;
        foreach ($correctiveActions as $index => $action) {
            $row = $rowIndex + ($index * 2);
            $sheet->setCellValue("G$row", $action['activity'] ?? '');
            $sheet->setCellValue("AC$row", $action['pic'] ?? '');
            $sheet->setCellValue("AF$row", $action['due_date'] ?? '');
            $sheet->setCellValue("AI$row", $action['status'] ?? '');
        }
    }

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
    $writer->save($tempFile);

    return response()->download($tempFile, 'QualityReport' . $qualityReport->id . '.xlsx')->deleteFileAfterSend(true);

}


public function storeInternal(Request $request)
{

    $request->validate([
        'tanggal' => 'required',
        'section' => 'required',
        'line' => 'required|string',
        'model' => 'required|string',
        'part_name' => 'required|string',
        'problem' => 'required|string',
        'quantity' => 'required',
        'standard' => 'required|string',
        'actual' => 'required|string',
        'visual_ok' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'visual_ng' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'measurement_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'qty.*' => 'nullable|integer',
        'ok.*' => 'nullable|integer',
        'ng.*' => 'nullable|integer',
        'pic.*' => 'nullable|string',
        'problem_analysis' => 'required|string',
        'occure.*' => 'nullable| string',
        'outflow.*' => 'nullable| string',
        'temporary.*.activity' => 'nullable| string',
        'temporary.*.pic' => 'nullable| string',
        'temporary.*.due_date' => 'nullable| date',
        'temporary.*.status' => 'nullable| string',
        'corrective.*.activity' => 'nullable| string',
        'corrective.*.pic' => 'nullable| string',
        'corrective.*.due_date' => 'nullable| date',
        'corrective.*.status' => 'nullable| string',
    ]);


    $qualityInternal = new QualityInternal();
    $qualityInternal->tanggal = $request->input('tanggal');
    $qualityInternal->section = $request->input('section');
    $qualityInternal->line = $request->input('line');
    $qualityInternal->modell = $request->input('model');
    $qualityInternal->part_name = $request->input('part_name');
    $qualityInternal->problem = $request->input('problem');
    $qualityInternal->quantity = $request->input('quantity');
    $qualityInternal->standard = $request->input('standard');
    $qualityInternal->actual = $request->input('actual');
    $qualityInternal->qty = json_encode ($request->input('qty'));
    $qualityInternal->ok = json_encode ($request->input('ok'));
    $qualityInternal->ng = json_encode ($request->input('ng'));
    $qualityInternal->pic = json_encode ($request->input('pic'));
    $qualityInternal->problem_analysis = $request->input('problem_analysis');
    $qualityInternal->occure = $request->input('occure');
    $qualityInternal->outflow = $request->input('outflow');
    $qualityInternal->temporary_actions = json_encode($request->input('temporary'));
    $qualityInternal->corrective_actions = json_encode($request->input('corrective'));

    if ($request->hasFile('visual_ok')) {
        $photoPath = $request->file('visual_ok');
        $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
        $visual_ok = $photoPath->storeAs('public/photos', $qualityInternal->internal . '_' . $originalFileName);
        $qualityInternal->visual_ok = $visual_ok;
    }

    if ($request->hasFile('visual_ng')) {
        $photoPath = $request->file('visual_ng');
        $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
        $visual_ng = $photoPath->storeAs('public/photos', $qualityInternal->internal . '_' . $originalFileName);
        $qualityInternal->visual_ng = $visual_ng;
    }

    if ($request->hasFile('measurement_photo')) {
        $photoPath = $request->file('measurement_photo');
        $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
        $measurement_photo = $photoPath->storeAs('public/photos', $qualityInternal->internal . '_' . $originalFileName);
        $qualityInternal->measurement_photo = $measurement_photo;
    }

    $qualityInternal->save();

    foreach ($request->qty as $index => $qty) {
        PenangananInternals::create([
            'quality_internal_id' => $qualityInternal->id,
            'komponen' => 'Komponen',
            'qty' => $qty,
            'ok' => $request->ok[$index],
            'ng' => $request->ng[$index],
            'pic' => $request->pic[$index],
        ]);
    }

    return redirect()->route('pica.internal')->with('success', 'Data Pica Internal berhasil disimpan.');
}

public function downloadExcelInternal($id)
{

    $qualityInternal = QualityInternal::findOrFail($id);
    $templatePath = public_path('storage/templates/TEMPLATE DAILY REPORT QUALITY SHEET.xlsx');
    if (!file_exists($templatePath)) {
        abort(404, 'Template file not found.');
    }

    $spreadsheet = new Spreadsheet();
    $spreadsheet = IOFactory::load($templatePath);
    $sheet = $spreadsheet->getActiveSheet();


    $sheet->setCellValue("F9", $qualityInternal->tanggal);
    $sheet->getStyle("F9")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
    $sheet->setCellValue("F10", $qualityInternal->section);
    $sheet->setCellValue("F11", $qualityInternal->line);
    $sheet->setCellValue("F12", $qualityInternal->modell);
    $sheet->setCellValue("F13", $qualityInternal->part_name);
    $sheet->setCellValue("F14", $qualityInternal->problem);
    $sheet->setCellValue("F15", $qualityInternal->quantity);
    $sheet->getStyle("F15")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
    $sheet->setCellValue("V9", $qualityInternal->standard);
    $sheet->setCellValue("AF9", $qualityInternal->actual);
    $sheet->setCellValue("C32", $qualityInternal->problem_analysis);

    $relativePhotoPath = $qualityInternal->visual_ok;
    $photoPath = storage_path('app/' . $relativePhotoPath);

    if (file_exists($photoPath)) {
        $drawing = new Drawing();
        $drawing->setName('Visual OK');
        $drawing->setDescription('Visual OK Image');
        $drawing->setPath($photoPath);
        $drawing->setHeight(40);
        $drawing->setWidth(215);
        $drawing->setCoordinates('T10');
        $drawing->setWorksheet($sheet);
    }

    $relativePhotoPath = $qualityInternal->visual_ng;
    $photoPath = storage_path('app/' . $relativePhotoPath);

    if (file_exists($photoPath)) {
        $drawing = new Drawing();
        $drawing->setName('Visual NG');
        $drawing->setDescription('Visual NG Image');
        $drawing->setPath($photoPath);
        $drawing->setHeight(40);
        $drawing->setWidth(215);
        $drawing->setCoordinates('AC10');
        $drawing->setWorksheet($sheet);
    }

    $relativePhotoPath = $qualityInternal->measurement_photo;
    $photoPath = storage_path('app/' . $relativePhotoPath);

    if (file_exists($photoPath)) {
        $drawing = new Drawing();
        $drawing->setName('Measurement Photo');
        $drawing->setDescription('Measurement Image');
        $drawing->setPath($photoPath);
        $drawing->setHeight(100);
        $drawing->setWidth(250);
        $drawing->setCoordinates('D20');
        $drawing->setWorksheet($sheet);
    }

    $sheet->setCellValue("H32", $qualityInternal->occure[0]);
    $sheet->getStyle('H32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("N32", $qualityInternal->occure[1]);
    $sheet->getStyle('N32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("T32", $qualityInternal->occure[2]);
    $sheet->getStyle('T32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("Z32", $qualityInternal->occure[3]);
    $sheet->getStyle('Z32')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("AF32", $qualityInternal->occure[4]);
    $sheet->getStyle('AF32')->getAlignment()->setTextRotation(0);

    $sheet->setCellValue("H38", $qualityInternal->outflow[0]);
    $sheet->getStyle('H38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("N38", $qualityInternal->outflow[1]);
    $sheet->getStyle('N38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("T38", $qualityInternal->outflow[2]);
    $sheet->getStyle('T38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("Z38", $qualityInternal->outflow[3]);
    $sheet->getStyle('Z38')->getAlignment()->setTextRotation(0);
    $sheet->setCellValue("AF38", $qualityInternal->outflow[4]);
    $sheet->getStyle('AF38')->getAlignment()->setTextRotation(0);

    $qtyData = json_decode($qualityInternal->qty, true);
    $okData = json_decode($qualityInternal->ok, true);
    $ngData = json_decode($qualityInternal->ng, true);
    $picData = json_decode($qualityInternal->pic, true);

    $startRow = 21;
    foreach ($qtyData as $index => $qty) {
        $row = $startRow + $index;
        $sheet->setCellValue("S$row", 'Komponen ' . ($index + 1));
        $sheet->setCellValue("Z$row", $qty);
        $sheet->setCellValue("AC$row", $okData[$index] ?? '');
        $sheet->setCellValue("AF$row", $ngData[$index] ?? '');
        $sheet->setCellValue("AI$row", $picData[$index] ?? '');
    }

    $sheet->setCellValue('Z28', '=SUM(Z21:Z26)');
    $sheet->setCellValue('AC28', '=SUM(AC21:AC26)');
    $sheet->setCellValue('AF28', '=SUM(AF21:AF26)');

    $temporaryActions = json_decode($qualityInternal->temporary_actions, true);


if ($temporaryActions) {
    $rowIndex = 47;

    foreach ($temporaryActions as $index => $action) {
        $row = $rowIndex + ($index * 2);


        $sheet->setCellValue("G$row", $action['activity'] ?? '');
        $sheet->setCellValue("AC$row", $action['pic'] ?? '');
        $sheet->setCellValue("AF$row", $action['due_date'] ?? '');
        $sheet->setCellValue("AI$row", $action['status'] ?? '');
    }
}

$correctiveActions = json_decode($qualityInternal->corrective_actions, true);


if ($correctiveActions) {
    $rowIndex = 55;

    foreach ($correctiveActions as $index => $action) {
        $row = $rowIndex + ($index * 2);

        $sheet->setCellValue("G$row", $action['activity'] ?? '');
        $sheet->setCellValue("AC$row", $action['pic'] ?? '');
        $sheet->setCellValue("AF$row", $action['due_date'] ?? '');
        $sheet->setCellValue("AI$row", $action['status'] ?? '');
    }
}


    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
    $writer->save($tempFile);

    return response()->download($tempFile, 'QualityInternal' . $qualityInternal->id . '.xlsx')->deleteFileAfterSend(true);
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
            'data_verifikasi.*' => 'nullable',
            'tipe' => 'required|string'
    ]);
        $pica = new Pica();
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

        $pica->save();

        if ($request->hasFile('data_verifikasi')) {
            $uploadedFiles = $request->file('data_verifikasi');

            foreach ($uploadedFiles as $file) {
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/documents/', $fileName);

                $document = new DocumentPica();
                $document->id_pica = $pica->id;
                $document->data_verifikasi = $fileName;
                $document->save();
            }
        }

        return redirect()->route('pica.form')->with('success', 'Data Pica berhasil disimpan.');
    }


    public function edit($id)
    {
        $pica = Pica::findOrFail($id);

        return view('pica.editPica', compact('pica'));
    }

    public function editCustomer($id)
    {
        $qualityReport = QualityReport::findOrFail($id);

        return view('pica.editCustomerPica', compact('qualityReport'));
    }

    public function editInternal($id)
    {
        $qualityInternal = QualityInternal::findOrFail($id);

        return view('pica.editInternalPica', compact('qualityInternal'));
    }




    public function update(Request $request, $id)
    {
        $pica = Pica::findOrFail($id);
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

        $pica->save();

        if ($request->hasFile('data_verifikasi')) {
            foreach ($pica->documentPica as $document) {
                Storage::delete('public/documents/' . $document->data_verifikasi);
                $document->delete();
            }

            $uploadedFiles = $request->data_verifikasi;

            foreach ($uploadedFiles as $file) {
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/documents/', $fileName);

                $document = new DocumentPica();
                $document->id_pica = $pica->id;
                $document->data_verifikasi = $fileName;
                $document->save();
            }
        }


        return redirect()->route('pica.form')->with('success', 'Data Pica berhasil diubah.');
    }
    public function updateCustomer(Request $request, $id)
    {

        try {

            $qualityReport = QualityReport::findOrFail($id);


            $qualityReport->tanggal = $request->input('tanggal');
            $qualityReport->section = $request->input('section');
            $qualityReport->line = $request->input('line');
            $qualityReport->modell = $request->input('model');
            $qualityReport->part_name = $request->input('part_name');
            $qualityReport->problem = $request->input('problem');
            $qualityReport->quantity = $request->input('quantity');
            $qualityReport->standard = $request->input('standard');
            $qualityReport->actual = $request->input('actual');

            if ($request->hasFile('visual_ok')) {

                if ($qualityReport->visual_ok) {
                    Storage::delete($qualityReport->visual_ok);
                }
                $photoPath = $request->file('visual_ok');
                $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
                $visual_ok = $photoPath->storeAs('public/photos', $qualityReport->report . '_' . $originalFileName);
                $qualityReport->visual_ok = $visual_ok;
            }

            if ($request->hasFile('visual_ng')) {

                if ($qualityReport->visual_ng) {
                    Storage::delete($qualityReport->visual_ng);
                }
                $photoPath = $request->file('visual_ng');
                $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
                $visual_ng = $photoPath->storeAs('public/photos', $qualityReport->report . '_' . $originalFileName);
                $qualityReport->visual_ng = $visual_ng;
            }

            if ($request->hasFile('measurement_photo')) {

                if ($qualityReport->measurement_photo) {
                    Storage::delete($qualityReport->measurement_photo);
                }
                $photoPath = $request->file('measurement_photo');
                $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
                $measurement_photo = $photoPath->storeAs('public/photos', $qualityReport->report . '_' . $originalFileName);
                $qualityReport->measurement_photo = $measurement_photo;


            }


            $qualityReport->qty = json_encode($request->input('qty'));
            $qualityReport->ok = json_encode($request->input('ok'));
            $qualityReport->ng = json_encode($request->input('ng'));
            $qualityReport->pic = json_encode($request->input('pic'));
            $qualityReport->problem_analysis = $request->input('problem_analysis');
            $qualityReport->occure = $request->input('occure');
            $qualityReport->outflow = $request->input('outflow');
            $qualityReport->temporary_actions = json_encode($request->input('temporary'));
            $qualityReport->corrective_actions = json_encode($request->input('corrective'));


            $qualityReport->save();


            PenangananStock::where('quality_report_id', $qualityReport->id)->delete();



            foreach ($request->qty as $index => $qty) {
                PenangananStock::create([
                    'quality_report_id' => $qualityReport->id,
                    'komponen' => 'Komponen',
                    'qty' => $qty,
                    'ok' => $request->ok[$index],
                    'ng' => $request->ng[$index],
                    'pic' => $request->pic[$index],
                ]);
            }


            return redirect()->route('pica.customer')->with('success', 'Data Customer/Supplier berhasil diubah.');
        } catch (\Exception $e) {
            Log::error('Error saat mengupdate data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate data.');
        }
    }


public function updateInternal(Request $request, $id)
    {

        try {

            $qualityInternal = QualityInternal::findOrFail($id);


        $qualityInternal->tanggal = $request->input('tanggal');
        $qualityInternal->section = $request->input('section');
        $qualityInternal->line = $request->input('line');
        $qualityInternal->modell = $request->input('model');
        $qualityInternal->part_name = $request->input('part_name');
        $qualityInternal->problem = $request->input('problem');
        $qualityInternal->quantity = $request->input('quantity');
        $qualityInternal->standard = $request->input('standard');
        $qualityInternal->actual = $request->input('actual');
        $qualityInternal->visual_ok = $request->input('visual_ok');
        $qualityInternal->visual_ng = $request->input('visual_ng');
        $qualityInternal->measurement_photo = $request->input('measurement_photo');
        $qualityInternal->qty = json_encode ($request->input('qty'));
        $qualityInternal->ok = json_encode ($request->input('ok'));
        $qualityInternal->ng = json_encode ($request->input('ng'));
        $qualityInternal->pic = json_encode ($request->input('pic'));
        $qualityInternal->problem_analysis = $request->input('problem_analysis');
        $qualityInternal->occure = $request->input('occure');
        $qualityInternal->outflow = $request->input('outflow');
        $qualityInternal->temporary_actions = json_encode($request->input('temporary'));
        $qualityInternal->corrective_actions = json_encode($request->input('corrective'));

        if ($request->hasFile('visual_ok')) {

            if ($qualityInternal->visual_ok) {
                Storage::delete($qualityInternal->visual_ok);
            }
            $photoPath = $request->file('visual_ok');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $visual_ok = $photoPath->storeAs('public/photos', $qualityInternal->report . '_' . $originalFileName);
            $qualityInternal->visual_ok = $visual_ok;
        }

        if ($request->hasFile('visual_ng')) {

            if ($qualityInternal->visual_ng) {
                Storage::delete($qualityInternal->visual_ng);
            }
            $photoPath = $request->file('visual_ng');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $visual_ng = $photoPath->storeAs('public/photos', $qualityInternal->report . '_' . $originalFileName);
            $qualityInternal->visual_ng = $visual_ng;
        }

        if ($request->hasFile('measurement_photo')) {

            if ($qualityInternal->measurement_photo) {
                Storage::delete($qualityInternal->measurement_photo);
            }
            $photoPath = $request->file('measurement_photo');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $measurement_photo = $photoPath->storeAs('public/photos', $qualityInternal->report . '_' . $originalFileName);
            $qualityInternal->measurement_photo = $measurement_photo;


        }


        $qualityInternal->qty = json_encode($request->input('qty'));
        $qualityInternal->ok = json_encode($request->input('ok'));
        $qualityInternal->ng = json_encode($request->input('ng'));
        $qualityInternal->pic = json_encode($request->input('pic'));
        $qualityInternal->problem_analysis = $request->input('problem_analysis');
        $qualityInternal->occure = $request->input('occure');
        $qualityInternal->outflow = $request->input('outflow');
        $qualityInternal->temporary_actions = json_encode($request->input('temporary'));
        $qualityInternal->corrective_actions = json_encode($request->input('corrective'));


        $qualityInternal->save();


        PenangananInternals::where('quality_internal_id', $qualityInternal->id)->delete();



        foreach ($request->qty as $index => $qty) {
            PenangananInternals::create([
                'quality_internal_id' => $qualityInternal->id,
                'komponen' => 'Komponen', 
                'qty' => $qty,
                'ok' => $request->ok[$index],
                'ng' => $request->ng[$index],
                'pic' => $request->pic[$index],
            ]);
        }

        return redirect()->route('pica.internal')->with('success', 'Data Pica Internal berhasil diubah.');
    } catch (\Exception $e) {
        Log::error('Error saat mengupdate data: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal mengupdate data.');
    }

}



    public function deleteCustomer($id)
    {
        try {
            $qualityReport = QualityReport::findOrFail($id);

        if ($qualityReport->measurement_photo) {
                Storage::delete($qualityReport->measurement_photo);
            }

            $qualityReport->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }

    public function deleteInternal($id)
    {
        try {
            $qualityInternal = QualityInternal::findOrFail($id);

        if ($qualityInternal->measurement_photo) {
                Storage::delete($qualityInternal->measurement_photo);
            }

            $qualityInternal->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }


    public function delete($id)
    {
        try {
            $pica = Pica::findOrFail($id);

            foreach ($pica->documentPica as $document) {
                $filePath = 'public/documents/' . $document->data_verifikasi;

                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }

                $document->delete();
            }


            $pica->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }

    }
}
