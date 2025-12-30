<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\UserCard;
use App\Modules\ECOMMERCE\Managements\CutomerWistList\Database\Models\WishList;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\UserAddress;
use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportTicket;

class DeleteCustomer
{
    public static function execute(Request $request, $id)
    {
        $userInfo = User::where('user_type', 3)->where('id', $id)->first();
        if ($userInfo) {
            $orderInfo = Order::where('user_id', $userInfo->id)->get();
            $supports = SupportTicket::where('support_taken_by', $userInfo->id)->get();
            $wishLists = WishList::where('user_id', $userInfo->id)->get();

            if (count($orderInfo) > 0) {
                return [
                    'status' => 'error',
                    'message' => 'Customer cannot be deleted',
                    'data' => 0
                ];
            } else if (count($supports) > 0) {
                return [
                    'status' => 'error',
                    'message' => 'Customer cannot be deleted',
                    'data' => 0
                ];
            } else if (count($wishLists) > 0) {
                return [
                    'status' => 'error',
                    'message' => 'Customer cannot be deleted',
                    'data' => 0
                ];
            } else {
                UserCard::where('user_id', $userInfo->id)->delete();
                UserAddress::where('user_id', $userInfo->id)->delete();
                $userInfo->delete();

                return [
                    'status' => 'success',
                    'message' => 'Customer deleted successfully.',
                    'data' => 1
                ];
            }
        } else {
            return [
                'status' => 'success',
                'message' => 'Customer deleted successfully.',
                'data' => 1
            ];
        }
    }
}
