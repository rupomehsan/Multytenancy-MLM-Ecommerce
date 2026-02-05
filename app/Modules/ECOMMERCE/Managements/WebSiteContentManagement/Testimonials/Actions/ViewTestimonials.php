<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Database\Models\Testimonial;

class ViewTestimonials
{
    public static function execute(Request $request)
    {
        $data = Testimonial::orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->editColumn('rating', function ($data) {
                $rating = "";
                for ($i = 1; $i <= $data->rating; $i++) {
                    $rating .= '<i class="feather-star" style="color: goldenrod;"></i>';
                }
                return $rating;
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('edit/testimonial') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Status" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'rating'])
            ->make(true);
    }
}
