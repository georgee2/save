<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\PageBanner;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs with pagination
     */
    public function index()
    {
        // Get paginated blogs with category information
        $blogs = DB::table('news')
            ->join('newscategories', 'newscategories.id', '=', 'news.category_code')
            ->select(
                'news.id',
                'news.title_english',
                'news.title_arabic',
                'news.bio_english',
                'news.bio_arabic',
                'news.image',
                'news.slug',
                'news.created_at',
                'newscategories.name_english as category_name_en',
                'newscategories.name_arabic as category_name_ar',
                'newscategories.id as category_id'
            )
            ->orderBy('news.created_at', 'DESC')
            ->paginate(10);

        // Get last 3 blogs for sidebar
        $recentBlogs = DB::table('news')
            ->join('newscategories', 'newscategories.id', '=', 'news.category_code')
            ->select(
                'news.id',
                'news.title_english',
                'news.title_arabic',
                'news.image',
                'news.slug',
                'news.created_at'
            )
            ->orderBy('news.created_at', 'DESC')
            ->limit(3)
            ->get();

        // Get categories with blog count
        $categories = DB::table('newscategories')
            ->leftJoin('news', 'news.category_code', '=', 'newscategories.id')
            ->select(
                'newscategories.id',
                'newscategories.name_english',
                'newscategories.name_arabic',
                DB::raw('COUNT(news.id) as blog_count')
            )
            ->whereNull('newscategories.deleted_at')
            ->groupBy('newscategories.id', 'newscategories.name_english', 'newscategories.name_arabic')
            ->having('blog_count', '>', 0)
            ->get();

        // Get page banner for blogs page
        $pageBanner = PageBanner::getByTarget('blogs');

        return view('pages.blogs.index', compact('blogs', 'recentBlogs', 'categories', 'pageBanner'));
    }

    /**
     * Display the specified blog
     */
    public function show($slug)
    {
        $blog = DB::table('news')
            ->join('newscategories', 'newscategories.id', '=', 'news.category_code')
            ->select(
                'news.*',
                'newscategories.name_english as category_name_en',
                'newscategories.name_arabic as category_name_ar'
            )
            ->where('news.slug', $slug)
            ->first();

        if (!$blog) {
            abort(404);
        }

        // Get last 3 blogs for sidebar
        $recentBlogs = DB::table('news')
            ->select('id', 'title_english', 'title_arabic', 'image', 'slug', 'created_at')
            ->where('id', '!=', $blog->id)
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();

        // Get categories with blog count
        $categories = DB::table('newscategories')
            ->leftJoin('news', 'news.category_code', '=', 'newscategories.id')
            ->select(
                'newscategories.id',
                'newscategories.name_english',
                'newscategories.name_arabic',
                DB::raw('COUNT(news.id) as blog_count')
            )
            ->whereNull('newscategories.deleted_at')
            ->groupBy('newscategories.id', 'newscategories.name_english', 'newscategories.name_arabic')
            ->having('blog_count', '>', 0)
            ->get();

        return view('pages.blogs.blog', compact('blog', 'recentBlogs', 'categories'));
    }
}

