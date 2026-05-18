<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WhyController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->where('in_stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('home-page', compact('products'));
    }

    public function why()
    {
        $products = DB::table('products')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        $reviews = DB::table('feedback')
            ->select('feedback.*', 'users.name as user_name')
            ->leftJoin('users', 'feedback.user_id', '=', 'users.id')
            ->orderBy('feedback.created_at', 'desc')
            ->limit(3)
            ->get();

        return view('why', [
            'products' => $products,
            'reviews' => $reviews
        ]);
    }

    public function add_review()
    {
        $user = Auth::user();
        
        $reviews = DB::table('feedback')
            ->select('feedback.*', 'users.name as user_name')
            ->leftJoin('users', 'feedback.user_id', '=', 'users.id')
            ->orderBy('feedback.id', 'desc')
            ->get();
        
        $userReview = null;
        if ($user) {
            $userReview = DB::table('feedback')
                ->where('user_id', $user->id)
                ->first();
        }
        
        return view('review', compact('reviews', 'userReview'));
    }
}
