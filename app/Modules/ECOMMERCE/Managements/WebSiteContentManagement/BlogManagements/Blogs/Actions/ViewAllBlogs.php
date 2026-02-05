<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ViewAllBlogs
{
    public static function execute(Request $request)
    {
        $data = DB::table('blogs')
            ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
            ->select('blogs.*', 'blog_categories.name as blog_category_name')
            ->orderBy('blogs.id', 'desc')
            ->get();

        return DataTables::of($data)
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->editColumn('created_at', function ($data) {
                return date("Y-m-d", strtotime($data->created_at));
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('edit/blog') . '/' . $data->slug . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
