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
        $customerChartDataYear = $this->getCustomerQuantityChartDataYear();
        $lineDiecastingProjectData = $this->getLineDiecastingProjectData();
        $lineMachiningProjectData = $this->getLineMachiningProjectData();
        $lineAssemblingProjectData = $this->getLineAssemblingProjectData();


        return view('dashboard', compact('customerProblems', 'customerChartData', 'customerChartDataYear', 'lineDiecastingProjectData', 'lineMachiningProjectData', 'lineAssemblingProjectData'));
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

    public function getCustomerQuantityChartDataYear()
    {
        $customerDataYear = DB::select("
        SELECT
          `customer`,
          SUM(`quantity_product`) as `total_quantity_product`,
          DATE_FORMAT(`date_of_problem`, '%Y') as `year`
        FROM
          `tm_customer_problems`
        WHERE
          `date_of_problem` >= DATE_SUB(NOW(), INTERVAL 3 YEAR)
        GROUP BY
          `customer`,
          `year`
        ORDER BY
          `year`, `customer`
    ");

        $labelsYear = [];
        $uniqueCustomersYear = [];

        foreach ($customerDataYear as $item) {
            if (!in_array($item->year, $labelsYear)) {
                $labelsYear[] = $item->year;
            }
            if (!in_array($item->customer, $uniqueCustomersYear)) {
                $uniqueCustomersYear[] = $item->customer;
            }
        }

        $datasetsYear = [];

        foreach ($uniqueCustomersYear as $customer) {
            $customerQuantitiesYear = [];

            foreach ($labelsYear as $labelYear) {
                $customerQuantityYear = 0;

                foreach ($customerDataYear as $item) {
                    if ($item->customer === $customer && $item->year === $labelYear) {
                        $customerQuantityYear = $item->total_quantity_product;
                        break;
                    }
                }

                $customerQuantitiesYear[] = $customerQuantityYear;
            }

            $datasetYear = [
                'label' => $customer,
                'backgroundColor' => '#' . substr(md5(rand()), 0, 6),
                'data' => $customerQuantitiesYear
            ];
            $datasetsYear[] = $datasetYear;
        }

        $chartDataYear = [
            'labels' => $labelsYear,
            'datasets' => $datasetsYear
        ];

        return $chartDataYear;
    }

    public function getLineDiecastingProjectData()
    {
        $lineDiecastingProjectData = DB::select("
            SELECT
                SUBSTRING(`line`, 1, 2) AS `line_group`,
                SUM(CASE WHEN `status` = 'finished' THEN 1 ELSE 0 END) AS `finished_count`,
                SUM(CASE WHEN `status` = 'onprogress' THEN 1 ELSE 0 END) AS `onprogress_count`
            FROM
                `tt_item_check_projects`
            JOIN
                `tt_projects` ON `tt_item_check_projects`.`project_id` = `tt_projects`.`id`
            WHERE
                `tt_projects`.`planning_masspro` >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
                AND `line` LIKE 'DC%'
            GROUP BY
                `line_group`
            ORDER BY
                `line_group`
        ");

        return $lineDiecastingProjectData;
    }

    public function getLineMachiningProjectData()
    {
        $lineMachiningProjectData = DB::select("
            SELECT
                SUBSTRING(`line`, 1, 2) AS `line_group`,
                SUM(CASE WHEN `status` = 'finished' THEN 1 ELSE 0 END) AS `finished_count`,
                SUM(CASE WHEN `status` = 'onprogress' THEN 1 ELSE 0 END) AS `onprogress_count`
            FROM
                `tt_item_check_projects`
            JOIN
                `tt_projects` ON `tt_item_check_projects`.`project_id` = `tt_projects`.`id`
            WHERE
                `tt_projects`.`planning_masspro` >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
                AND `line` LIKE 'MA%'
            GROUP BY
                `line_group`
            ORDER BY
                `line_group`
        ");

        return $lineMachiningProjectData;
    }

    public function getLineAssemblingProjectData()
    {
        $lineAssemblingProjectData = DB::select("
        SELECT
            SUBSTRING(`line`, 1, 2) AS `line_group`,
            SUM(CASE WHEN `status` = 'finished' THEN 1 ELSE 0 END) AS `finished_count`,
            SUM(CASE WHEN `status` = 'onprogress' THEN 1 ELSE 0 END) AS `onprogress_count`
        FROM
            `tt_item_check_projects`
        JOIN
            `tt_projects` ON `tt_item_check_projects`.`project_id` = `tt_projects`.`id`
        WHERE
            `tt_projects`.`planning_masspro` >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
            AND `line` LIKE 'AS%'
        GROUP BY
            `line_group`
        ORDER BY
            `line_group`
    ");

        return $lineAssemblingProjectData;
    }
}