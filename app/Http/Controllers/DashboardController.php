<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProblem;

class DashboardController extends Controller
{
    public function index()
    {
        $customerProblems = CustomerProblem::latest()->take(1)->get();
        return view('dashboard', compact('customerProblems'));
    }
}
