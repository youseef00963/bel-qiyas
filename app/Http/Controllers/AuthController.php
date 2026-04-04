<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Order;
class AuthController extends Controller {
/*  
public function showLogin() {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }
        */
    public function showLogin()
{
    return redirect()->route('dashboard');
}
    public function login(Request $request) {
        $credentials = $request->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($credentials, $request->remember)) return redirect()->route('dashboard');
        return back()->withErrors(['email'=>'البريد الإلكتروني أو كلمة المرور غلط']);
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
    public function dashboard() {
        $totalDebt = Order::selectRaw('SUM(total_amount - paid_amount) as debt')->value('debt') ?? 0;
        $priorityClients = Client::whereHas('orders', function($q) {
            $q->whereNull('delivery_date')->orWhere('delivery_date','>=',now());
        })->with(['orders'=>function($q){ $q->orderBy('delivery_date'); }])
        ->get()->sortBy(fn($c)=>optional($c->orders->first())->delivery_date);
        return view('dashboard', compact('totalDebt','priorityClients'));
    }
}