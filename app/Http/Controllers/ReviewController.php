<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(Request $req)
    {
        $rating = $req->input('rating');
        $comment = $req->input('comment');
        $pro_id = $req->input('pro_id');
        $token = $this->uniqueCode();
        Review::create([
            'product_id' => $pro_id,
            'user_id' => Auth::id(),
            'rating' => $rating,
            'comment' => $comment,
            'status' => 'Hide',
            '_token' => $token,
        ]);

        $review = Review::where('product_id', $pro_id);
        $user = Auth::user();

        return response()->json(['success' => 'Cảm ơn bạn đã đánh giá', 'comment' => $comment, 'pro_id' => $pro_id, 'success2' => 'Cảm ơn bạn đã đánh giá nếu có chỗ nào chưa tốt hãy ý kiến về cho chúng tôi']);
    }

    public function uniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (Review::where('_token', $code)->first());
        return $code;
    }
}
