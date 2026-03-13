@extends('layouts.app')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1 style="margin: 0;">{{ $client->full_name }}</h1>
    <a href="{{ route('clients.index') }}" class="btn btn-outline">← العودة</a>
</div>

<div class="card">
    <h2>المقاسات والمعلومات</h2>
    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>الاسم الكامل</label>
            <input type="text" name="full_name" value="{{ $client->full_name }}" required>
        </div>
        <div class="form-row">
            <div class="form-group"><label>الطول (سم)</label><input type="number" step="0.1" name="height" value="{{ $client->height }}"></div>
            <div class="form-group"><label>العرض (سم)</label><input type="number" step="0.1" name="width" value="{{ $client->width }}"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>طول الكم</label><input type="number" step="0.1" name="sleeve_length" value="{{ $client->sleeve_length }}"></div>
            <div class="form-group"><label>عرض الكم</label><input type="number" step="0.1" name="sleeve_width" value="{{ $client->sleeve_width }}"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>دوران الصدر</label><input type="number" step="0.1" name="chest_circumference" value="{{ $client->chest_circumference }}"></div>
            <div class="form-group"><label>دوران الخصر</label><input type="number" step="0.1" name="waist_circumference" value="{{ $client->waist_circumference }}"></div>
        </div>
        <div class="form-group">
            <label>ملاحظات</label>
            <textarea name="notes" rows="3">{{ $client->notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">تحديث المعلومات</button>
    </form>
</div>

<div class="card">
    <h2>إضافة طلب جديد</h2>
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <div class="form-group">
            <label>وصف القطعة</label>
            <textarea name="description" rows="2" placeholder="مثال: فستان سهرة أزرق..."></textarea>
        </div>
        <div class="form-row">
            <div class="form-group"><label>المبلغ الكلي</label><input type="number" step="0.01" name="total_amount" placeholder="0"></div>
            <div class="form-group"><label>تاريخ الاستلام</label><input type="date" name="received_date"></div>
        </div>
        <div class="form-group">
            <label>تاريخ التسليم</label>
            <input type="date" name="delivery_date">
        </div>
        <button type="submit" class="btn btn-primary">إضافة الطلب</button>
    </form>
</div>

@foreach($client->orders as $order)
<div class="card" style="border-right: 4px solid #8b6f5e;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h2 style="margin: 0;">طلب #{{ $order->id }}</h2>
        <span style="background: #f5ede9; color: #8b6f5e; padding: 4px 12px; border-radius: 20px; font-size: 13px;">
            الباقي: {{ number_format($order->total_amount - $order->paid_amount, 0) }}
        </span>
    </div>

    <form method="POST" action="{{ route('orders.update', $order) }}" style="margin-bottom: 20px;">
        @csrf @method('PUT')
        <div class="form-group">
            <label>وصف القطعة</label>
            <textarea name="description" rows="2">{{ $order->description }}</textarea>
        </div>
        <div class="form-row">
            <div class="form-group"><label>المبلغ الكلي</label><input type="number" step="0.01" name="total_amount" value="{{ $order->total_amount }}"></div>
            <div class="form-group"><label>المبلغ المدفوع</label><input type="number" value="{{ $order->paid_amount }}" disabled></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>تاريخ الاستلام</label><input type="date" name="received_date" value="{{ $order->received_date }}"></div>
            <div class="form-group"><label>تاريخ التسليم</label><input type="date" name="delivery_date" value="{{ $order->delivery_date }}"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 8px 20px; font-size: 13px;">تحديث الطلب</button>
    </form>

    <form method="POST" action="{{ route('orders.images', $order) }}" enctype="multipart/form-data" style="padding-top: 16px; border-top: 1px solid #eee; margin-bottom: 16px;">
        @csrf
        <label style="margin-bottom: 8px;">رفع صورة للقطعة</label>
        <div style="display: flex; gap: 12px;">
            <input type="file" name="image" accept="image/*" style="flex: 1;">
            <input type="text" name="description" placeholder="وصف الصورة" style="flex: 1;">
            <button type="submit" class="btn btn-outline" style="white-space: nowrap;">رفع</button>
        </div>
    </form>

    @if($order->images->count() > 0)
    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 16px;">
        @foreach($order->images as $img)
        <div style="text-align: center;">
            <img src="{{ asset('storage/' . $img->image_path) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
            @if($img->description)<p style="font-size: 12px; color: #888; margin-top: 4px;">{{ $img->description }}</p>@endif
        </div>
        @endforeach
    </div>
    @endif

    <div style="padding-top: 16px; border-top: 1px solid #eee;">
        <strong style="font-size: 14px; display: block; margin-bottom: 8px;">سجل الدفعات:</strong>
        @if($order->payments->count() > 0)
            @foreach($order->payments as $payment)
            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5f5f5; font-size: 14px;">
                <span style="color: #888;">{{ \Carbon\Carbon::parse($payment->paid_at)->format('Y/m/d') }}</span>
                <span style="color: #3a7a3a; font-weight: 600;">{{ number_format($payment->amount, 0) }}</span>
            </div>
            @endforeach
        @else
            <p style="color: #aaa; font-size: 13px;">لا يوجد دفعات بعد</p>
        @endif
    </div>
</div>
@endforeach

@endsection