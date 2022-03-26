<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->session()->has('ADMIN_LOGIN')) {
            return redirect('admin/dashboard');
        } else {
            return view('admin.login');
        }
    }

    public function auth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        // $result = Admin::where(['email'=> $email,'password' => $password])->first();
        $result = Admin::where(['email' => $email])->first();
        if ($result) {
            if (Hash::check($password, $result->password)) {
                $request->session()->put('ADMIN_LOGIN', true);
                $request->session()->put('ADMIN_ID', $result->id);
                return redirect('admin/dashboard');
            } else {
                $request->session()->flash('error', "Please Enter Valid Password");
                return redirect('admin');
            }
        } else {
            $request->session()->flash('error', "Please Insert Valid Login Credentials");
            return redirect('admin');
        }
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
