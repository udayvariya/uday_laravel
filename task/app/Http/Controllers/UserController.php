<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
            'role'     => 'required',
        ]);

        $user = User::create($data);

        if ($data) {
            return redirect()->route('login');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Send a login notification email
            $code = rand(1111,9999);
            Session::put('verification_code', $code);
            Mail::raw("Hi {$user->name}, Your Verification Code Is" . $code , function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Login Successful');
            });
    
            return redirect()->route('verification');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function verifyMatch(Request $request){
        $request->validate([
            'verification' => 'required|numeric',
        ]);
    
        $inputCode = $request->verification;
        $storedCode = Session::get('verification_code');
    
        if ($inputCode == $storedCode) {
            Session::forget('verification_code'); // optional cleanup
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login')->with('error','verification code is Wrong');

        }

    }
    public function dashboardPage()
    {
        if (Auth::check()) {
            return view('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function innerPage()
    {
        if (Auth::check()) {
            return view('inner');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return view('login');

    }

}
