<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function account()
    {
        $user = auth()->user();
        return view('frontend.account', compact('user'));
    }

    public function update_account(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'password' => 'nullable'
        ]);
        if ($validation->fails()) {
            return back()->withErrors($validation->errors())->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if ($request->password != '') {
            $data['password'] = bcrypt($request->password);
        }

        auth()->user()->update($data);

        return redirect()->route('account')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);

    }
}
