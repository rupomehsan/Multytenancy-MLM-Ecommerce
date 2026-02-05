<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\UserActivity;

class ViewAllSystemUsers
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $query = User::whereIn('user_type', [1, 2, 4])
                ->where('id', '!=', 1)
                ->orderBy('id', 'desc');

            if ($request->has('user_type') && $request->user_type != '') {
                if ($request->user_type == 'system_user') {
                    $query->where('user_type', 2);
                } elseif ($request->user_type == 'delivery_man') {
                    $query->where('user_type', 4);
                }
            }

            $data = $query->get();

            return Datatables::of($data)
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
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('user_type', function ($data) {
                    if ($data->user_type == 2) {
                        return '<a href="javascript:void(0)" style="background: #090; font-weight: 600;" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Make SuperAdmin" class="btn-sm btn-success rounded makeSuperAdmin">Make SuperAdmin</a>';
                    } else {
                        return '<a href="javascript:void(0)" style="background: #ca0000; font-weight: 600;" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Revoke SuperAdmin" class="btn-sm btn-success rounded revokeSuperAdmin">Revoke SuperAdmin</a>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if ($data->status == 1)
                        $btn = '<input type="checkbox" onchange="changeUserStatus(' . $data->id . ')" checked data-size="small" data-toggle="switchery" data-color="#53c024" data-secondary-color="#df3554"/>';
                    else
                        $btn = '<input type="checkbox" onchange="changeUserStatus(' . $data->id . ')" data-size="small"  data-toggle="switchery" data-color="#53c024" data-secondary-color="#df3554"/>';
                    $btn .= ' <a href="' . route('EditSystemUser', $data->id) . '" class="btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'user_type', 'active_status'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
