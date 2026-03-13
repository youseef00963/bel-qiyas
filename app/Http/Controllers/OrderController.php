<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderImage;
use Illuminate\Http\Request;
class OrderController extends Controller {
    public function store(Request $request) {
        $data = $request->validate([
            'client_id'=>'required|exists:clients,id','description'=>'nullable|string',
            'total_amount'=>'nullable|numeric','received_date'=>'nullable|date',
            'delivery_date'=>'nullable|date',
        ]);
        Order::create($data);
        return back()->with('success','تم إضافة الطلب');
    }
    public function update(Request $request, Order $order) {
        $data = $request->validate([
            'description'=>'nullable|string','total_amount'=>'nullable|numeric',
            'received_date'=>'nullable|date','delivery_date'=>'nullable|date',
        ]);
        $order->update($data);
        return back()->with('success','تم التحديث');
    }
    public function uploadImage(Request $request, Order $order) {
        $request->validate(['image'=>'required|image|max:5120','description'=>'nullable|string']);
        $path = $request->file('image')->store('orders','public');
        OrderImage::create(['order_id'=>$order->id,'image_path'=>$path,'description'=>$request->description]);
        return back()->with('success','تم رفع الصورة');
    }
}