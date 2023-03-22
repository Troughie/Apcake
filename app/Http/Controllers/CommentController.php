<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Events\Comment as EventsComment;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required',
        ]);

        $comments = Review::where('product_id', $data['product_id'])
            ->orderBy('id', 'desc')
            ->get();

        return response($comments, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'comment' => 'required|min:3',
            'product_id' => 'required'
        ]);

        $comment = Review::create([
            'comment' => $data['comment'],
            'user_id' => Auth::user()->id,
            'product_id' => $data['videoId']
        ]);

        $comment = Review::find($comment->id);

        event(new EventsComment($comment));

        return response($comment, 201);
    }
}
