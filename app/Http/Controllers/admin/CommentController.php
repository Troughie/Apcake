<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Review::with('user_review', 'product_comment')->get();
        $title = 'comment';
        return view('backend.comments.comment', compact('comment', 'title'));
    }

    public function showHide(Request $req)
    {
        if ($req->show == 'show') {
            Review::where('_token', $req->token)->update(array('status' => 'Hide'));
        } else {
            Review::where('_token', $req->token)->update(array('status' => 'Show'));
        }

        return redirect()->back();
    }

    public function feedback(String $id)
    {
        $review = Review::where('_token', $id)->first();
        $feedback = Feedback::where('review_id', $review->review_id)->first();
        $title = 'feed back to customer';
        return view('backend.comments.feedback', compact('title', 'review', 'feedback'));
    }

    public function postFeedBack(Request $req)
    {
        $feedback = Feedback::where('review_id', $req->review_id)->first();
        if (isset($feedback)) {
            Feedback::where('review_id', $req->review_id)->update(array('content' => $req->comment, 'feedback_admin' => Auth::user()->email));
        } else {
            Feedback::create([
                'content' => $req->comment,
                'review_id' => $req->review_id,
                'feedback_admin' => Auth::user()->email,
            ]);
        }

        return redirect()->route('admin.showComment')->with('success', 'Trả lời thành công');
    }
}
