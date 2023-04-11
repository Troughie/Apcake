<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Services\Search;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserBanned;
use Str;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::with('deliveryAddress', 'orders', 'ranking')->whereNot('role', 'ADM')->get();
        $order = Order::with('user')->get();
        $delivery = DeliveryAddress::with('user')->get();

        return view('backend.users.users', compact('user', 'delivery', 'order'))->with('title', 'user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('ranking', 'orders', 'deliveryAddress')->find($id);
        $review = Review::where('user_id', $id)->get();
        if ($user->orders == null) {
            $user->update([$user->rank_id = 1]);
        } elseif ($user->orders->sum('totalAmount') > 1000000) {
            $user->update([$user->rank_id = 2]);
        } elseif ($user->orders->sum('totalAmount') > 5000000) {
            $user->update([$user->rank_id = 3]);
        }
        return view('backend.users.detail', compact('user', 'review'))->with('title', 'Chi tiết người dùng');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('backend.users.edit', compact('user'))->with('title', 'Edit user');
    }
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $user->update($input);
        return redirect()->route('admin.users')->with('flash_message', 'User Updated!');
    }

    // public function store(Request $request)
    // {
    //     $input = $request->all();
    //     User::create($input);
    //     return redirect()->route('admin.users.index')->with('flash_message', 'Student Addedd!');
    // }

    public function search()
    {
        return redirect()->route('admin.admin')->with(['flash_message', 'title'], ['User Updated!', 'update success']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'delete successfull');
    }


    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ban(Request $request,$id)
    {
        $user = User::findOrFail($id);

        if ($request->has('permanent')) {
            // Permanent ban
            $days = $request->input('permanent');
            $user->is_banned = true;
            // $user->banned_until = null;
            $user->banned_until = now()->addDays($days);
           
        } elseif ($request->has('temporary')) {
            // Temporary ban
            $days = $request->input('days');
            $user->is_banned = true;
            $user->banned_until = now()->addDays($days);
        
        }
        $user->update();
        $bannedDays = $request->input('days');
        $unbanDate = Carbon::parse($user->banned_until)->format('d/m/Y');
        Mail::to($user->email)->send(new UserBanned($user, $bannedDays, $unbanDate));
       
     return redirect()->route('admin.users',compact('user'))->with('success', 'Khóa người dùng thành công');

    }
    public function Unban($id)
    {
    $user = User::findOrFail($id);
    $user->is_banned = false;
    $user->banned_until = null;
    $user->update();
    return redirect()->route('admin.users')->with('success', 'Mở khóa người dùng thành công');

    }
}