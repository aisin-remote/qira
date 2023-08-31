<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerProblem;

class DashboardController extends Controller
{
    public function index()
    {
        $customerProblems = CustomerProblem::latest('date_of_problem')->take(1)->get();
        $customerChartData = $this->getCustomerQuantityChartData();

        return view('dashboard', compact('customerProblems', 'customerChartData'));
    }

    public function getCustomerQuantityChartData()
    {
        $customerData = DB::select("
            SELECT
              `customer`,
              SUM(`quantity_product`) as `total_quantity_product`,
              DATE_FORMAT(`date_of_problem`, '%Y-%m') as `month_year`
            FROM
              `tm_customer_problems`
            WHERE
              `date_of_problem` >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY
              `customer`,
              `month_year`
            ORDER BY
              `month_year`, `customer`
        ");

        $labels = [];
        $uniqueCustomers = [];

        foreach ($customerData as $item) {
            if (!in_array($item->month_year, $labels)) {
                $labels[] = $item->month_year;
            }
            if (!in_array($item->customer, $uniqueCustomers)) {
                $uniqueCustomers[] = $item->customer;
            }
        }

        $datasets = [];

        foreach ($uniqueCustomers as $customer) {
            $customerQuantities = [];

            foreach ($labels as $label) {
                $customerQuantity = 0;

                foreach ($customerData as $item) {
                    if ($item->customer === $customer && $item->month_year === $label) {
                        $customerQuantity = $item->total_quantity_product;
                        break;
                    }
                }

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
