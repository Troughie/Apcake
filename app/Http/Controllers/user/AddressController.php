<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function deladdress(string $id)
    {
        DeliveryAddress::where('delivery_id', $id)->delete();
        return redirect()->back()->with('deladd', 'Xoá thành công');
    }

    public function changeadd(Request $req)
    {
        $add_id = $req->input('add_id');
        $address = DeliveryAddress::where('user_id', Auth::id())->where('delivery_id', $add_id)->first();
        $data = [
            'fullname' => $address->fullname,
            'phone' => $address->phone,
            'province' => $address->province,
            'district' => $address->district,
            'ward' => $address->ward,
            '_token' => $address->_token,
            'emailladd' => $address->emailladd
        ];
        return response()->json($data);
    }
    public function createadd(Request $req)
    {
        $address = DeliveryAddress::where('user_id', Auth::id())->get();
        $addcount = $address->count('user_id');
        return response()->json(['data' => $addcount]);
    }
}
