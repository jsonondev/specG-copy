<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Project;
use App\Models\Client;
use Hash;
use Session;

class UserController extends Controller
{
    public function landing() {
        return redirect()->route('login');
    }

    public function login() {
        return view('login');
    }

    public function authenticate(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        
        $user = User::where('email','=',$request->email)->first();
        
        if($user) {
            if (Hash::check($request->password,$user->password)) {   
                if ($user->status == 'for approval') {
                    return back()->with('fail','Your account is awaiting approval.');    
                }
                else {
                    $request->session()->put('loginId', $user->id);
                    $request->session()->put('role', $user->status);         
                    return redirect('/home');
                }
            }
            else {
                return back()->with('fail','Invalid credentials.');
            };
        }
        else {
            return back()->with('fail','Invalid credentials.');
        }
    }

    public function register() {
        if (Session()->has('loginId')) {
            return redirect('/home')->with('fail','Cannot access "www.specg.com/register" since you are currently logged in.');
        }
        return view("register");
    }
    public function signup(Request $request) {
        $request->validate([
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255', 
            'email'=>'required|email|unique:users|max:255',
            'password'=> 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/|confirmed',
            'phone'=>'required|regex:/^[0-9()\-]+$/|max:255'
        ]);
        $user = new User();
        $user->firstname = ucwords(strtolower(trim($request->firstName)));
        $user->lastname = ucwords(strtolower(trim($request->lastName)));
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->status = 'for approval'; 
        $new = $user->save();
        if ($new) {
            return redirect('/login')->with('success', 'Registered successfully. Your account is for approval.');
            
        }
        else {
            return back()->with('fail','Error encountered. Try again later.');
        }
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully');
    }

    public function showAccounts() {
        if (session('role') == 'admin') {
            $users = User::orderBy('lastname','asc')
                ->where('status','!=','admin')
                ->get();
            return view('admin')->with('users',$users);
        }
        else {
            return view('errors.404');
        }
    }

    public function removeUser($id) {
        if (session('role') == 'admin') {
            $delete = User::where('id','=',$id)->delete();
            if ($delete > 0) {
                return back()->with('success', 'User account removed successfully.');        
            }
            else {
                return back()->with('fail','Error encountered. Try again later.');    
            }
        }
        else {
            return view('errors.404');
        }
    }

    public function approveUser($id) {
        if (session('role') == 'admin') {
            $update = User::where('id','=',$id)->update([
                'status' => 'approved'
            ]);
            if ($update) {
                return back()->with('success', 'User account approved successfully .');        
            }
            else {
                return back()->with('fail','Error encountered. Try again later.');    
            }
        }
        else {
            return view('errors.404');
        }
    }
}
