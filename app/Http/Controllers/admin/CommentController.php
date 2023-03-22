<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Review::with('user_review', 'product_comment')->get();
        $title = 'comment';
        return view('backend.comment', compact('comment', 'title'));
    }
}
