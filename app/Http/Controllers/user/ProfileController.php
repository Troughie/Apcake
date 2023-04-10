<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderDetails;
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
        $request->validate(
            [
                'oldpassword' => ['required'],
                'newpassword' => ['required', 'unique:users,password', 'min:8'],
                'confirmpassword' =>  ['same:newpassword'],
            ],
            [
                'newpassword.min' => 'Mật khẩu phải có 8 ký tự',
                'newpassword.unique' => 'Mật khẩu trùng với mật khẩu cũ',
                'confirmpassword.same' => 'Mật khẩu xác nhận không đúng',
            ]
        );

        if (Hash::check($request->oldpassword, $user->password)) {
            DB::table('users')->where('user_id', '=', Auth::id())->update([
                'password' => bcrypt($request->newpassword),
            ]);
            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } else {
            return redirect()->back()->with('fail', 'Mật khẩu cũ không đúng');
        }

        // return redirect()->route('user.profile')->with('flash_message', 'student Updated!');
    }

    public function orders()
    {
        $title_head = 'orders';
        $order = Order::with('orderDe', 'order_sta', 'orderDe.order_pro')->where('user_id', Auth::id())->get();
        return view('frontend.pages.profile.orders', compact('title_head', 'order'));
    }

    public function orderDetail(string $id)
    {
        $orDetail = OrderDetails::with('order_pro', 'order', 'order.order_sta')->where('order_id', $id)->get();
        return view('frontend.pages.profile.orderdetail', compact('orDetail'));
    }

    public function orderAgain(string $id)
    {
        $order = Order::with('orderDe')->where('order_id', $id)->first();
        foreach ($order->orderDe as $key => $value) {
            $cart = new Cart();
            $cartItem = new Cart();
            $cartItem->product_id = $value->product_id;
            $cartItem->user_id = Auth::id();
            $cartItem->quantity = $value->quantity;
            $cartItem->size = $value->size;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Đã thêm lại thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $user = User::find($id);
        $title_head = 'profile';
        $useraddress = DeliveryAddress::where('user_id', Auth::id())->get();
        $address = Province::with('district', 'ward')->get();

        return view('frontend.pages.profile.profile', compact('user', 'address', 'title_head', 'useraddress'));
    }


    public function ajaxRequest(Request $request)
    {
        // Xử lý dữ liệu được gửi đến trong $request
        $inputValue = $request->input('city');
        $district = $request->input('district');
        $districtvalue = [];
        if (isset($inputValue)) {
            $cityyid = DB::table('province')->where('_name', $inputValue)->first()->id;

            $districtvalue = DB::table('district')->where('_province_id', $cityyid)->get();
        } else if (isset($district)) {

            $districtid = DB::table('district')->where('_name', $district)->first()->id;
            $districtvalue = DB::table('ward')->where('_district_id', $districtid)->get();
        }
        // $data = [];
        // $city = DB::table('district')->where('_province_id', $request->city)->first();
        // $districts = $city->districts;
        // $data = $city;
        return response()->json(['data' => $districtvalue]);
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

    public function uniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (DeliveryAddress::where('_token', $code)->first());
        return ['code' => $code];
    }
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $token = $this->uniqueCode();
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required|min:11|max:12',
            'province' => 'required',
            'email' => 'required|email',
            'district' => 'required',
            'wards' => 'required',
        ]);
        $deli = DeliveryAddress::where('user_id', Auth::id())->get();
        if ($request->status == 'update') {
            DeliveryAddress::where('_token', $request->_tokenadd)
                ->update(array(
                    'fullname' => $request->fullname, 'phone' => $request->phone,
                    'emailladd' => $request->email,
                    'address' => implode(',', [$request->wards, $request->district, $request->province]),
                    'province' => $request->province, 'district' => $request->district, 'ward' => $request->wards
                ));
        } else {
            DeliveryAddress::create([
                'user_id' => Auth::id(),
                'fullname' => $request->fullname, 'phone' => $request->phone,
                'address' => implode(',', [$request->wards, $request->district, $request->province]),
                '_token' => $token['code'],
                'emailladd' => $request->email,
                'province' => $request->province, 'district' => $request->district, 'ward' => $request->wards,
            ]);
        }
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
        $comment = Review::where('user_id', Auth::id())->get();
        $title_head = 'comments';

        return view('frontend.pages.profile.comments', compact('comment', 'title_head'));
    }
}
