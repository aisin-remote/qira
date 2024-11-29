<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProblem;
use App\Models\CustomerProblemBody;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CustomerProblemController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'problem' => 'required',
            'date_of_problem' => 'required|date',
            'customer' => 'required',
            'model_product' => 'required',
            'quantity_product' => 'required|integer',
            'process_problem' => 'required',
            'date_of_process' => 'required|date',
            'status_problem' => 'required',
            'status_kaizen' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'report' => 'nullable',
        ]);

        $customerProblem = new CustomerProblem();
        $customerProblem->problem = $validatedData['problem'];
        $customerProblem->date_of_problem = $validatedData['date_of_problem'];
        $customerProblem->customer = $validatedData['customer'];
        $customerProblem->model_product = $validatedData['model_product'];
        $customerProblem->quantity_product = $validatedData['quantity_product'];
        $customerProblem->process_problem = $validatedData['process_problem'];
        $customerProblem->date_of_process = $validatedData['date_of_process'];
        $customerProblem->status_problem = $validatedData['status_problem'];
        $customerProblem->status_kaizen = $validatedData['status_kaizen'];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $photo = $photoPath->storeAs('public/photos/', $customerProblem->problem . '_' . $originalFileName);
            $customerProblem->photo = $photo;
        }

        if ($request->hasFile('report')) {
            $document = $request->file('report');
            // Ambil nama asli file dokumen
            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $customerProblem->problem . '_' . $originalFileName);

            $customerProblem->report = $documentPath;
        }

        $customerProblem->save();

        return redirect()->back()->with('success', 'Customer problem has been saved.');
    }

    public function storeBody(Request $request)
    {
        $validatedData = $request->validate([
            'problem' => 'required',
            'date_of_problem' => 'required|date',
            'customer' => 'required',
            'model_product' => 'required',
            'quantity_product' => 'required|integer',
            'process_problem' => 'required',
            'date_of_process' => 'required|date',
            'status_problem' => 'required',
            'status_kaizen' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'report' => 'nullable',
        ]);

        $customerProblemBody = new CustomerProblemBody();
        $customerProblemBody->problem = $validatedData['problem'];
        $customerProblemBody->date_of_problem = $validatedData['date_of_problem'];
        $customerProblemBody->customer = $validatedData['customer'];
        $customerProblemBody->model_product = $validatedData['model_product'];
        $customerProblemBody->quantity_product = $validatedData['quantity_product'];
        $customerProblemBody->process_problem = $validatedData['process_problem'];
        $customerProblemBody->date_of_process = $validatedData['date_of_process'];
        $customerProblemBody->status_problem = $validatedData['status_problem'];
        $customerProblemBody->status_kaizen = $validatedData['status_kaizen'];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $photo = $photoPath->storeAs('public/photos/', $customerProblemBody->problem . '_' . $originalFileName);
            $customerProblemBody->photo = $photo;
        }

        if ($request->hasFile('report')) {
            $document = $request->file('report');
            // Ambil nama asli file dokumen
            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $customerProblemBody->problem . '_' . $originalFileName);

            $customerProblemBody->report = $documentPath;
        }

        $customerProblemBody->save();

        return redirect()->back()->with('success', 'Customer problem has been saved.');
    }

    public function body()
    {
        $oneYearAgo = Carbon::now()->subYear();

        $customerProblemsBody = CustomerProblemBody::where('date_of_problem', '>=', $oneYearAgo)
            ->orderBy('date_of_problem', 'desc')
            ->get();

        return view('problem.problemBodyForm', compact('customerProblemsBody'));
    }

    public function index()
    {
        $oneYearAgo = Carbon::now()->subYear();

        $customerProblems = CustomerProblem::where('date_of_problem', '>=', $oneYearAgo)
            ->orderBy('date_of_problem', 'desc')
            ->get();

        return view('problem.problemForm', compact('customerProblems'));
    }

    public function show(CustomerProblem $customerProblem)
    {
        return view('problem.show', compact('customerProblem'));
    }

    public function showBody(CustomerProblemBody $customerProblemBody)
    {
        return view('problem.showBody', compact('customerProblemBody'));
    }

    public function edit($id)
    {
        $customerProblem = CustomerProblem::findOrFail($id);
        return view('problem.editProblem', compact('customerProblem'));
    }

    public function editBody($id)
    {
        $customerProblemBody = CustomerProblemBody::findOrFail($id);
        return view('problem.editProblemBody', compact('customerProblemBody'));
    }

    public function update(Request $request, $id)
    {
        $customerProblem = CustomerProblem::findOrFail($id);
        $customerProblem->problem = $request['problem'];
        $customerProblem->date_of_problem = $request['date_of_problem'];
        $customerProblem->customer = $request['customer'];
        $customerProblem->model_product = $request['model_product'];
        $customerProblem->quantity_product = $request['quantity_product'];
        $customerProblem->process_problem = $request['process_problem'];
        $customerProblem->date_of_process = $request['date_of_process'];
        $customerProblem->status_problem = $request['status_problem'];
        $customerProblem->status_kaizen = $request['status_kaizen'];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $photo = $photoPath->storeAs('public/photos/', $customerProblem->problem . '_' . $originalFileName);
            $customerProblem->photo = $photo;
        }

        if ($request->hasFile('report')) {
            $document = $request->file('report');
            // Ambil nama asli file dokumen
            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $customerProblem->problem . '_' . $originalFileName);

            $customerProblem->report = $documentPath;
        }

        $customerProblem->save();

        return redirect()->route('problem.form')->with('success', 'Customer problem has been updated.');
    }

    public function updateBody(Request $request, $id)
    {
        $customerProblemBody = CustomerProblemBody::findOrFail($id);
        $customerProblemBody->problem = $request['problem'];
        $customerProblemBody->date_of_problem = $request['date_of_problem'];
        $customerProblemBody->customer = $request['customer'];
        $customerProblemBody->model_product = $request['model_product'];
        $customerProblemBody->quantity_product = $request['quantity_product'];
        $customerProblemBody->process_problem = $request['process_problem'];
        $customerProblemBody->date_of_process = $request['date_of_process'];
        $customerProblemBody->status_problem = $request['status_problem'];
        $customerProblemBody->status_kaizen = $request['status_kaizen'];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo');
            $originalFileName = uniqid() . '.' . $photoPath->getClientOriginalExtension();
            $photo = $photoPath->storeAs('public/photos/', $customerProblemBody->problem . '_' . $originalFileName);
            $customerProblemBody->photo = $photo;
        }

        if ($request->hasFile('report')) {
            $document = $request->file('report');
            // Ambil nama asli file dokumen
            $originalFileName = uniqid() . '.' . $document->getClientOriginalExtension();

            // Gabungkan dengan nilai $itemData['nama'] untuk membentuk path lengkap
            $documentPath = $document->storeAs('public/documents/', $customerProblemBody->problem . '_' . $originalFileName);

            $customerProblemBody->report = $documentPath;
        }

        $customerProblemBody->save();

        return redirect()->route('problemBody.form')->with('success', 'Customer problem quality body has been updated.');
    }

    public function delete($id)
    {
        try {
            $customerProblem = CustomerProblem::findOrFail($id);

            if ($customerProblem->photo) {
                Storage::delete($customerProblem->photo);
            }

            $customerProblem->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }



    public function deleteBody($id)
    {
        try {
            $customerProblemBody = CustomerProblemBody::findOrFail($id);

            if ($customerProblemBody->photo) {
                Storage::delete($customerProblemBody->photo);
            }

            $customerProblemBody->delete();

            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus item.');
        }
    }
}


