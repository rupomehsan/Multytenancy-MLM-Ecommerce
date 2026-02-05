<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Actions;

use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\UserActivity;

class ViewAllCustomerEcommerce
{
    public static function execute(Request $request)
    {
        $data = User::where('user_type', 3)
            ->orderBy('id', 'desc')
            ->get();

        return Datatables::of($data)
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->addColumn('active_status', function ($data) {
                $activity = UserActivity::where('user_id', $data->id)->first();

                if ($activity && $activity->last_seen) {
                    $diff = Carbon::now()->diffInMinutes($activity->last_seen);
                    if ($diff < 1) {
                        return '<span class="badge" style="background: linear-gradient(90deg, #00c853 0%, #43e97b 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;"><i class="fas fa-circle" style="color:#fff; margin-right:6px;"></i>Active now</span>';
                    } elseif ($diff < 2) {
                        return '<span class="badge" style="background: linear-gradient(90deg, #ff9800 0%, #ffc107 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;">
                            <i class="fas fa-clock" style="color:#fff; margin-right:6px;"></i>
                            Last seen ' . $diff . ' min ago
                        </span>';
                    } else {
                        UserActivity::where('user_id', $data->id)->delete();
                        return '<span class="badge" style="background: linear-gradient(90deg, #434343 0%, #262626 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;"><i class="fas fa-circle" style="color:#888; margin-right:6px;"></i>Offline</span>';
                    }
                } else {
                    return '<span class="badge" style="background: linear-gradient(90deg, #434343 0%, #262626 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;"><i class="fas fa-circle" style="color:#888; margin-right:6px;"></i>Offline</span>';
                }
            })
            ->addColumn('name', function ($data) {
                return $data->name ? $data->name : 'N/A';
            })
            ->editColumn('image', function ($data) {
                if ($data->image && file_exists(public_path($data->image))) {
                    return $data->image;
                }
            })
            ->addColumn('phone', function ($data) {
                return $data->phone ? $data->phone : 'N/A';
            })
            ->addColumn('email', function ($data) {
                return $data->email ? $data->email : 'N/A';
            })
            ->addColumn('address', function ($data) {
                return $data->address ? $data->address : 'N/A';
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . route('EditCustomerEcommerce', $data->id) . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'active_status'])
            ->make(true);
    }
}
