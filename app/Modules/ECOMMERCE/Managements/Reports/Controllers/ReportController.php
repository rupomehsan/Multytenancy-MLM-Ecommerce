<?php

namespace App\Modules\ECOMMERCE\Managements\Reports\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\Reports\Actions\GenerateSalesReport;
use App\Modules\ECOMMERCE\Managements\Reports\Actions\GenerateProductPurchaseReport;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Reports');
    }
    public function salesReport()
    {
        return view('sales_report');
    }

    public function generateSalesReport(Request $request)
    {
        $result = GenerateSalesReport::execute($request);

        $returnHTML = view('sales_report_view', [
            'startDate' => $result['data']['startDate'],
            'endDate' => $result['data']['endDate'],
            'data' => $result['data']['orders']
        ])->render();

        return response()->json(['variant' => $returnHTML]);
    }

    public function productPurchaseReport(Request $request)
    {
        return view('product_purchase_report');
    }
    public function generateProductPurchaseReport(Request $request)
    {
        $result = GenerateProductPurchaseReport::execute($request);

        $returnHTML = view('product_purchase_report_view', [
            'startDate' => $result['data']['startDate'],
            'endDate' => $result['data']['endDate'],
            'data' => $result['data']['purchases']
        ])->render();

        return response()->json(['variant' => $returnHTML]);
    }
}
