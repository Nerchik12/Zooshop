<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('articles')
            ->where('is_published', true);

        if ($request->has('category') && $request->category != '') {
            $query = $query->where('category', $request->category);
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(6);

        $categories = DB::table('articles')
            ->where('is_published', true)
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('articles', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = DB::table('articles')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$article) {
            abort(404);
        }

        $recentArticles = DB::table('articles')
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('article', compact('article', 'recentArticles'));
    }
}
