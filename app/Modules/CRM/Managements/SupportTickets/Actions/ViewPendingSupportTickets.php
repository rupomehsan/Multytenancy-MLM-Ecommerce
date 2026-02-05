<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewPendingSupportTickets
{
    public static function execute(Request $request)
    {
        $data = DB::table('support_tickets')
            ->join('users', 'support_tickets.support_taken_by', '=', 'users.id')
            ->select('support_tickets.*', 'users.name')
            ->where('support_tickets.status', 0)
            ->orWhere('support_tickets.status', 1)
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
                $btn = ' <a href="' . route('ViewSupportMessage', $data->slug) . '" title="Edit" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                if ($data->status == 0) {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="On Hold" data-id="' . $data->slug . '" data-original-title="On Hold" class="btn-sm btn-secondary rounded onHoldBtn"><i class="fa fa-pause"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Reject" data-id="' . $data->slug . '" data-original-title="Reject" class="btn-sm btn-danger rounded rejectBtn"><i class="fa fa-thumbs-down"></i></a>';
                }
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Approve For Next Level" data-id="' . $data->slug . '" data-original-title="Status" class="btn-sm btn-info rounded statusBtn"><i class="fas fa-check"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'attachment', 'status'])
            ->make(true);
    }
}
