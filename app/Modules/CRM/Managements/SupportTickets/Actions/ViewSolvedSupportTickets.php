<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewSolvedSupportTickets
{
    public static function execute(Request $request)
    {
        $data = DB::table('support_tickets')
            ->join('users', 'support_tickets.support_taken_by', '=', 'users.id')
            ->select('support_tickets.*', 'users.name')
            ->where('support_tickets.status', 2)
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
                $btn = ' <a href="' . route('ViewSupportMessage', $data->slug) . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'attachment'])
            ->make(true);
    }
}
