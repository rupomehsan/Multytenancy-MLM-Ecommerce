<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ViewAllProductReviews
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('product_reviews')
                ->join('products', 'product_reviews.product_id', '=', 'products.id')
                ->join('users', 'product_reviews.user_id', '=', 'users.id')
                ->select('product_reviews.*', 'products.image as product_image', 'products.name as product_name', 'users.name as user_name',  'users.image as user_image')
                ->orderBy('product_reviews.id', 'desc')
                ->get();

            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    return $data->status;
                })
                ->editColumn('rating', function ($data) {
                    $rating = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $rating .= $i <= $data->rating ? '<i class="fa fa-star text-warning"></i>' : '<i class="fa fa-star text-muted"></i>';
                    }
                    return $rating;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Reply" class="btn-sm btn-info rounded replyBtn"><i class="fas fa-reply"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Approve" class="btn-sm btn-success rounded approveBtn"><i class="fas fa-check"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'rating'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
