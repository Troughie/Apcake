<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\User;
use App\Services\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::with('deliveryAddress', 'orders', 'ranking')->get();
        $order = Order::with('user')->get();
        $delivery =  DeliveryAddress::with('user')->get();
        foreach ($user as $item) {
            if ($item->orders == null) {
                continue;
            } elseif ($item->orders->sum('totalAmount') > 2000) {

                $item->update([$item->rank_id = 2]);
            }
        };

        return view('backend.users.users', compact('user', 'delivery', 'order'))->with('title', 'user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('backend.users.detail', compact('user'))->with('title', 'detail user');
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
}
