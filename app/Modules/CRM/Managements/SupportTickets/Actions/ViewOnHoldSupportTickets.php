<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewOnHoldSupportTickets
{
    public static function execute(Request $request)
    {
        $data = DB::table('support_tickets')
            ->join('users', 'support_tickets.support_taken_by', '=', 'users.id')
            ->select('support_tickets.*', 'users.name')
            ->where('support_tickets.status', 4)
            ->orderBy('id', 'desc')
            ->get();

        return Datatables::of($data)
            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return 'Pending';
                } elseif ($data->status == 1) {
                    return 'In Progress';
                } elseif ($data->status == 2) {
                    return 'Solved';
                } elseif ($data->status == 3) {
                    return 'Rejected';
                } elseif ($data->status == 4) {
                    return 'On Hold';
                } else {
                    return '';
                }
            })
            ->editColumn('attachment', function ($data) {
                if ($data->attachment) {
                    return "<a href=" . url('/') . "/" . $data->attachment . " stream target='_blank'>Download Attachment</a>";
                } else {
                    return "No Attachment Found";
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('view/support/messages') . '/' . $data->slug . '" title="Edit" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="In Progress" data-id="' . $data->slug . '" data-original-title="In Progress" class="btn-sm btn-info rounded inProgressBtn"><i class="fas fa-check"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'attachment'])
            ->make(true);
    }
}
