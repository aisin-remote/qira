<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerProblem;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startMonth = $request->input('start_month');
        $endMonth = $request->input('end_month');

        // Set default values if not provided
        $startMonth = $startMonth ?: Carbon::now()->startOfMonth()->format('Y-m');
        $endMonth = $endMonth ?: Carbon::now()->endOfMonth()->format('Y-m');

        $customerProblems = CustomerProblem::latest('date_of_problem')->take(1)->get();
        $customerChartData = $this->getCustomerQuantityChartData();
        $customerChartDataYear = $this->getCustomerQuantityChartDataYear();
        $lineDiecastingProjectData = $this->getLineDiecastingProjectData($startMonth, $endMonth);
        $lineMachiningProjectData = $this->getLineMachiningProjectData($startMonth, $endMonth);
        $lineAssemblingProjectData = $this->getLineAssemblingProjectData($startMonth, $endMonth);
        $linedctcc = $this->getLineDCTCC($startMonth, $endMonth);
        $lineDCOilpanData = $this->getLineDCOilpan($startMonth, $endMonth);
        $linedccsh = $this->getLineDCCSH($startMonth, $endMonth);
        $lineMATCCData = $this->getLineMATCC($startMonth, $endMonth);
        $lineMAOilpanData = $this->getLineMAOilpan($startMonth, $endMonth);
        $lineASTCCData = $this->getLineASTCC($startMonth, $endMonth);
        $lineASOilpanData = $this->getLineASOilpan($startMonth, $endMonth);
        $lineASWPOPData = $this->getLineASWPOP($startMonth, $endMonth);

        return view('dashboard', compact('customerProblems', 'customerChartData', 'customerChartDataYear', 'lineDiecastingProjectData', 'lineMachiningProjectData', 'lineAssemblingProjectData', 'linedctcc', 'lineDCOilpanData', 'linedccsh', 'lineMATCCData', 'lineMAOilpanData', 'lineASTCCData', 'lineASOilpanData', 'lineASWPOPData'));
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

    public function getLineDiecastingProjectData($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

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
            DATE_FORMAT(`tt_projects`.`planning_masspro`, '%Y%m') BETWEEN $startMonth AND $endMonth
            AND `line` LIKE 'DC%'
        GROUP BY
            `line_group`
        ORDER BY
            `line_group`;    
        ");

        return $lineDiecastingProjectData;
    }

    public function getLineMachiningProjectData($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

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
                DATE_FORMAT(`tt_projects`.`planning_masspro`, '%Y%m') BETWEEN $startMonth AND $endMonth
                AND `line` LIKE 'MA%'
            GROUP BY
                `line_group`
            ORDER BY
                `line_group`
        ");

        return $lineMachiningProjectData;
    }

    public function getLineAssemblingProjectData($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

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
            DATE_FORMAT(`tt_projects`.`planning_masspro`, '%Y%m') BETWEEN $startMonth AND $endMonth
            AND `line` LIKE 'AS%'
        GROUP BY
            `line_group`
        ORDER BY
            `line_group`
        ");

        return $lineAssemblingProjectData;
    }

    public function getLineDCTCC($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $linedctcc = DB::select("
        SELECT
            model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM (
            SELECT
                SUBSTRING(line, 1, 2) AS line_prefix,
                SUBSTRING_INDEX(model, ' ', 1) AS model_group,
                status
            FROM
                tt_products
            WHERE
                line LIKE 'DC%' AND model LIKE 'TCC%'
                AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
                OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        ) AS subquery
        GROUP BY
            model_group;
    ");

        return $linedctcc;
    }

    public function getLineDCOilpan($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $lineDCOilpanData = DB::select("
        SELECT
            model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM (
            SELECT
                SUBSTRING(line, 1, 2) AS line_prefix,
                SUBSTRING_INDEX(model, ' ', 1) AS model_group,
                status
            FROM
                tt_products
            WHERE
                line LIKE 'DC%' AND (model LIKE 'Oilpan%' OR  model LIKE 'OPN%' OR  model LIKE 'OP%')
                AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
                OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        ) AS subquery
        GROUP BY
            model_group;
    ");

        return $lineDCOilpanData;
    }

    public function getLineDCCSH($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $linedccsh = DB::select("
    SELECT
        model_group,
        SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
        SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
    FROM (
        SELECT
            SUBSTRING(line, 1, 2) AS line_prefix,
            SUBSTRING_INDEX(model, ' ', 1) AS model_group,
            status
        FROM
            tt_products
        WHERE
            line LIKE 'DC%' AND model LIKE 'CSH%'
            AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
            OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
    ) AS subquery
    GROUP BY
        model_group;
    ");

        return $linedccsh;
    }

    public function getLineMATCC($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $lineMATCCData = DB::select("
        SELECT
            model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM (
            SELECT
                SUBSTRING(line, 1, 2) AS line_prefix,
                SUBSTRING_INDEX(model, ' ', 1) AS model_group,
                status
            FROM
                tt_products
            WHERE
                line LIKE 'MA%' AND model LIKE 'TCC%'
                AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
                OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        ) AS subquery
        GROUP BY
            model_group;
    ");

        return $lineMATCCData;
    }

    public function getLineMAOilpan($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $lineMAOilpanData = DB::select("
        SELECT
            model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM (
            SELECT
                SUBSTRING(line, 1, 2) AS line_prefix,
                SUBSTRING_INDEX(model, ' ', 1) AS model_group,
                status
            FROM
                tt_products
            WHERE
                line LIKE 'MA%' AND (model LIKE 'Oilpan%' OR  model LIKE 'OIL PAN%')
                AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
                OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        ) AS subquery
        GROUP BY
            model_group;
    ");

        return $lineMAOilpanData;
    }

    public function getLineASTCC($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $lineASTCCData = DB::select("
        SELECT
            model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM (
            SELECT
                SUBSTRING(line, 1, 2) AS line_prefix,
                SUBSTRING_INDEX(model, ' ', 1) AS model_group,
                status
            FROM
                tt_products
            WHERE
                line LIKE 'AS%' AND model LIKE 'TCC%'
                AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
                OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        ) AS subquery
        GROUP BY
            model_group;
    ");

        return $lineASTCCData;
    }

    public function getLineASOilpan($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $lineASOilpanData = DB::select("
        SELECT
            model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM (
            SELECT
                SUBSTRING(line, 1, 2) AS line_prefix,
                SUBSTRING_INDEX(model, ' ', 1) AS model_group,
                status
            FROM
                tt_products
            WHERE
                line LIKE 'AS%' AND (model LIKE 'Oilpan%' OR  model LIKE 'OIL PAN%')
                AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
                OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        ) AS subquery
        GROUP BY
            model_group;
    ");

        return $lineASOilpanData;
    }

    public function getLineASWPOP($startMonth, $endMonth)
    {
        $startMonth = str_replace('-', '', $startMonth);
        $endMonth = str_replace('-', '', $endMonth);

        $lineASWPOPData = DB::select("
        SELECT
            CASE
                WHEN model LIKE 'WP%' OR model LIKE 'OP%' THEN 'WP/OP'
                ELSE SUBSTRING_INDEX(model, ' ', 1)
            END AS model_group,
            SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END) AS on_progress_count,
            SUM(CASE WHEN status = 'Finished' THEN 1 ELSE 0 END) AS finished_count
        FROM tt_products
        WHERE line LIKE 'AS%' AND (model LIKE 'WP%' OR model LIKE 'OP%')
        AND (DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth
        OR DATE_FORMAT(`tt_products`.`planning_finished`, '%Y%m') BETWEEN $startMonth AND $endMonth)
        GROUP BY model_group;
    ");

        return $lineASWPOPData;
    }
}
