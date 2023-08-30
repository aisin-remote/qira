<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerProblem;

class DashboardController extends Controller
{
    public function index()
    {
        $customerProblems = CustomerProblem::latest()->take(1)->get();
        $customerChartData = $this->getCustomerQuantityChartData();

        return view('dashboard', compact('customerProblems', 'customerChartData'));
    }

    public function getCustomerQuantityChartData()
    {
        $customerData = DB::table('tm_customer_problems')
            ->select('customer', 'quantity_product', 'date_of_problem')
            ->where('date_of_problem', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 12 MONTH)'))
            ->get();

        $labels = [];
        $uniqueCustomers = $customerData->pluck('customer')->unique();

        foreach ($customerData as $item) {
            $formattedDate = date('Y-m-d', strtotime($item->date_of_problem));
            if (!in_array($formattedDate, $labels)) {
                $labels[] = $formattedDate;
            }
        }

        $datasets = [];

        foreach ($uniqueCustomers as $customer) {
            $customerQuantities = [];

            foreach ($labels as $label) {
                $customerQuantity = $customerData->where('customer', $customer)
                    ->where('date_of_problem', $label)
                    ->sum('quantity_product');
                $customerQuantities[] = $customerQuantity;
            }

            $dataset = [
                'label' => $customer,
                'backgroundColor' => '#' . substr(md5(rand()), 0, 6),
                'data' => $customerQuantities
            ];
            $datasets[] = $dataset;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => $datasets
        ];

        return $chartData;
    }
}
