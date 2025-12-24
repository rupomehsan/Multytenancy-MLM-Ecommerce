<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewAllOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewPendingOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewTrashedOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewDispatchOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewApprovedOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewIntransitOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewDeliveredOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewCancelledOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewReturnOrders;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ShowOrderDetails;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ShowOrderEdit;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\CancelOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ApproveOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\IntransitOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\DeliverOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\UpdateOrderInfo;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\UpdateOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\AddMoreProduct;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\GetProductVariants;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\DeleteOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\RestoreOrder;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewOrderLogs;
use App\Modules\ECOMMERCE\Managements\Orders\Actions\ViewOrderLogDetails;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Orders');
    }

    public function viewAllOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllOrders::execute($request);
        }
        return view('all');
    }

    public function viewPendigOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewPendingOrders::execute($request);
        }
        return view('pending');
    }

    public function viewAllTrashedOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewTrashedOrders::execute($request);
        }
        return view('trashed');
    }

    public function viewAllDispatchOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewDispatchOrders::execute($request);
        }
        return view('dispatch');
    }

    public function viewApprovedOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewApprovedOrders::execute($request);
        }
        return view('approved');
    }

    public function viewIntransitOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewIntransitOrders::execute($request);
        }
        return view('intransit');
    }

    public function viewDeliveredOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewDeliveredOrders::execute($request);
        }
        return view('delivered');
    }

    public function viewCancelledOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewCancelledOrders::execute($request);
        }
        return view('cancelled');
    }

    public function viewReturnOrders(Request $request)
    {
        if ($request->ajax()) {
            return ViewReturnOrders::execute($request);
        }
        return view('return');
    }

    public function orderDetails($slug)
    {
        $data = ShowOrderDetails::execute($slug);
        return view('details', $data);
    }

    public function cancelOrder($slug)
    {
        return CancelOrder::execute($slug);
    }

    public function approveOrder($slug)
    {
        return ApproveOrder::execute($slug);
    }

    public function intransitOrder($slug)
    {
        return IntransitOrder::execute($slug);
    }

    public function deliverOrder($slug)
    {
        return DeliverOrder::execute($slug);
    }

    public function orderInfoUpdate(Request $request)
    {
        return UpdateOrderInfo::execute($request);
    }

    public function orderEdit($slug)
    {
        $data = ShowOrderEdit::execute($slug);
        return view('edit', $data);
    }

    public function orderUpdate(Request $request)
    {
        return UpdateOrder::execute($request);
    }

    public function addMoreProduct(Request $request)
    {
        return AddMoreProduct::execute($request);
    }

    public function getProductVariants(Request $request)
    {
        return GetProductVariants::execute($request);
    }

    public function deleteOrder($slug)
    {
        return DeleteOrder::execute($slug);
    }

    public function RestoreOrder($slug)
    {
        return RestoreOrder::execute($slug);
    }

    public function viewOrderLogs(Request $request)
    {
        if ($request->ajax()) {
            return ViewOrderLogs::execute($request);
        }
        return view('logs');
    }

    public function viewOrderLogDetails($id)
    {
        return ViewOrderLogDetails::execute($id);
    }
}
