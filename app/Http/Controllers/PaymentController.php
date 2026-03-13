<?php
namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
class PaymentController extends Controller {
    public function index(Request $request) {
        $clients = Client::all();
        $selectedClient = null;
        $orders = collect();
        if ($request->client_id) {
            $selectedClient = Client::findOrFail($request->client_id);
            $orders = $selectedClient->orders()->with('payments')->get();
        }
        return view('payments.index', compact('clients','selectedClient','orders'));
    }
    public function store(Request $request) {
        $data = $request->validate(['order_id'=>'required|exists:orders,id','amount'=>'required|numeric|min:1','notes'=>'nullable|string']);
        Payment::create($data);
        $order = Order::findOrFail($data['order_id']);
        $order->paid_amount += $data['amount'];
        $order->save();
        return back()->with('success','تم تسجيل الدفعة');
    }
}