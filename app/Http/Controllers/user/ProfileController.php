<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Models\Province;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title_head = 'profile';
        $user = User::with('orders', 'deliveryAddress', 'favorites')->get();
        return view('frontend.pages.index', compact('title_head'))->with('user', $user);
    }

    public function changePass(string $id)
    {
        $user = User::find($id);
        $title_head = 'changePass';
        return view('frontend.pages.profile.cpass', compact('title_head'))->with('user', $user);
    }

    public function updatePass(Request $request, string $id)
    {
        $user = Auth::user();
        $request->validate([
            'oldpassword' => ['required'],
            'newpassword' => ['required', 'unique:users,password', 'min:8'],
            'confirmpassword' => ['min:8', 'same:newpassword'],
        ]);

        if (Hash::check($request->oldpassword, $user->password)) {
            DB::table('users')->where('user_id', '=', Auth::id())->update([
                'password' => bcrypt($request->newpassword),
            ]);
            return redirect()->back()->with('success', 'Infomation  Updated!');
        } else {
            return redirect()->back()->with('fail', 'old password not same');
        }

        // return redirect()->route('user.profile')->with('flash_message', 'student Updated!');
    }

    public function orders(string $id)
    {
        $title_head = 'orders';
        $user = User::find($id);
        return view('frontend.pages.profile.orders', compact('title_head'))->with('user', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $user = User::find($id);
        $title_head = 'profile';

        $address = Province::with('district', 'ward')->get();

        return view('frontend.pages.profile.profile', compact('user', 'address', 'title_head'));
    }

    public function ajaxRequest(Request $request)
    {
        // Xử lý dữ liệu được gửi đến trong $request
        $inputValue = $request->input('city');
        $district = $request->input('district');



        // Trả về một HTTP response
        return response()->json(['success' => true, 'data' => $inputValue, 'name' => $district]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'wards' => 'required',
        ]);
        $user->deliveryAddress->fullname = $request->fullname;
        $user->deliveryAddress->phone = $request->phone;
        $user->deliveryAddress->province = $request->province;
        $user->deliveryAddress->district = $request->district;
        $user->deliveryAddress->ward = $request->wards;
        $user->deliveryAddress->update();
        return redirect()->route('user.profile', ['id' => $id])->with('update_mes', 'Infomation  Updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function favorites(string $id)
    {
        $title_head = 'favorites';

        $user = User::find($id);
        return view('frontend.pages.profile.favorites', compact('user', 'title_head'));
    }

    public function comments(Request $req)
    {
        $comment = Review::all();
        $title_head = 'comments';

        return view('frontend.pages.profile.comments', compact('comment', 'title_head'));
    }
}
