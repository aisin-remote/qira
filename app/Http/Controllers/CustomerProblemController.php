<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProblem;

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust the file validation as needed
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
            $originalFileName = $photoPath->getClientOriginalName();
            $photo = $photoPath->storeAs('public/photos/', $customerProblem->problem . '_' . $originalFileName);
            $customerProblem->photo = $photo;
        }

        $customerProblem->save();

        return redirect()->back()->with('success', 'Customer problem has been saved.');
    }
}
