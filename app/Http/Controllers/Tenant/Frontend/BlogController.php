<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    protected $base_route = 'tenant.frontend.pages.';
    public function blogs()
    {
        $blogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->paginate(6);
        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $recentBlogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->skip(0)->limit(3)->get();
        return view($this->base_route . 'blogs', compact('blogs', 'blogCategories', 'recentBlogs'));
    }

    public function blogDetails($slug)
    {
        $blog = DB::table('blogs')
            ->leftJoin('blog_categories', 'blogs.category_id', 'blog_categories.id')
            ->select('blogs.*', 'blog_categories.name as category_name')
            ->where('blogs.slug', $slug)
            ->first();

        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $recentBlogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->skip(0)->limit(3)->get();
        $randomBlogs = DB::table('blogs')->where('status', 1)->where('id', '!=', $blog->id)->inRandomOrder()->skip(0)->limit(3)->get();
        return view($this->base_route . 'blog_details', compact('blog', 'blogCategories', 'recentBlogs', 'randomBlogs'));
    }

    public function categoryWiseBlogs($id)
    {
        $blogCategoryInfo = DB::table('blog_categories')->where('id', $id)->first();
        $sectionTitle = $blogCategoryInfo->name;
        $blogs = DB::table('blogs')->where('status', 1)->where('category_id', $id)->orderBy('id', 'desc')->paginate(6);
        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $recentBlogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->skip(0)->limit(3)->get();
        return view($this->base_route . 'blogs', compact('blogs', 'sectionTitle', 'blogCategories', 'recentBlogs'));
    }

    public function searchBlogs(Request $request)
    {
        $sectionTitle = "Search Results for : " . $request->search_keyword;
        $searchKeyword = $request->search_keyword;
        $blogs = DB::table('blogs')->where('status', 1)->where('title', 'LIKE', '%' . $request->search_keyword . '%')->orderBy('id', 'desc')->paginate(6);
        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $recentBlogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->skip(0)->limit(3)->get();
        return view($this->base_route . 'blogs', compact('blogs', 'sectionTitle', 'blogCategories', 'recentBlogs', 'searchKeyword'));
    }

    public function tagWiseBlogs($tag)
    {
        $sectionTitle = "Blog Tag : " . $tag;
        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $blogs = DB::table('blogs')->where('status', 1)->where('tags', 'LIKE', '%' . $tag . '%')->orderBy('id', 'desc')->paginate(6);
        $recentBlogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->skip(0)->limit(3)->get();
        return view($this->base_route . 'blogs', compact('blogs', 'sectionTitle', 'blogCategories', 'recentBlogs'));
    }
}
