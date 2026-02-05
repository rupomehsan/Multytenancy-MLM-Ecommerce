<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ViewAllQuestionAnswer
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('product_question_answers')
                ->leftJoin('products', 'product_question_answers.product_id', '=', 'products.id')
                ->select('product_question_answers.*', 'products.image as product_image', 'products.name as product_name')
                ->orderBy('product_question_answers.id', 'desc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Reply" class="btn-sm btn-info rounded replyBtn"><i class="fas fa-reply"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
