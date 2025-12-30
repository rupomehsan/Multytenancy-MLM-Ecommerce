<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class ViewAllStorages
{
    public static function execute(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = StorageType::orderBy('serial', 'asc')->get();

                return DataTables::of($data)
                    ->editColumn('status', function ($data) {
                        if ($data->status == 1) {
                            return '<span class="btn btn-sm btn-success rounded" style="padding: 0.1rem .5rem;">Active</span>';
                        } else {
                            return '<span class="btn btn-sm btn-warning rounded" style="padding: 0.1rem .5rem;">Inactive</span>';
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Featured" data-original-title="Featured" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }

            return [
                'status' => 'success',
                'view' => 'backend.config.storage'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
