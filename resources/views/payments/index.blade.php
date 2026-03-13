@extends('layouts.app')
@section('content')
<h1>إدارة الديون</h1>

<div class="card">
    <h2>بحث عن زبونة</h2>
    <form method="GET" action="{{ route('payments.index') }}">
        <div style="display: flex; gap: 12px;">
            <select name="client_id" style="flex: 1;">
                <option value="">-- اختاري زبونة --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->full_name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">بحث</button>
        </div>
    </form>
</div>

@if($selectedClient)
<div class="card">
    <h2>{{ $selectedClient->full_name }}</h2>
    @foreach($orders as $order)
    <div style="border: 1px solid #eee; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <strong>طلب #{{ $order->id }}</strong>
            <span style="color: #888; font-size: 13px;">{{ $order->description }}</span>
        </div>
        <div style="display: flex; gap: 24px; margin-bottom: 12px; font-size: 14px;">
            <span>الكلي: <strong>{{ number_format($order->total_amount, 0) }}</strong></span>
            <span>المدفوع: <strong style="color: #3a7a3a;">{{ number_format($order->paid_amount, 0) }}</strong></span>
            <span>الباقي: <strong style="color: #c0392b;">{{ number_format($order->total_amount - $order->paid_amount, 0) }}</strong></span>
        </div>

        @if($order->total_amount - $order->paid_amount > 0)
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div style="display: flex; gap: 12px;">
                <input type="number" name="amount" placeholder="المبلغ المدفوع" step="0.01" min="1" style="flex: 1;">
                <input type="text" name="notes" placeholder="ملاحظة (اختياري)" style="flex: 1;">
                <button type="submit" class="btn btn-primary" style="white-space: nowrap;">تسجيل دفعة</button>
            </div>
        </form>
        @else
            <span style="background: #edf7ed; color: #3a7a3a; padding: 6px 14px; border-radius: 20px; font-size: 13px;">✓ تم السداد الكامل</span>
        @endif

        @if($order->payments->count() > 0)
        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #f5f5f5;">
            <p style="font-size: 13px; color: #888; margin-bottom: 8px;">سجل الدفعات:</p>
            @foreach($order->payments->sortByDesc('paid_at') as $payment)
            <div style="display: flex; justify-content: space-between; font-size: 13px; padding: 4px 0; color: #555;">
                <span>{{ \Carbon\Carbon::parse($payment->paid_at)->format('Y/m/d') }}</span>
                <span style="color: #3a7a3a; font-weight: 600;">+ {{ number_format($payment->amount, 0) }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>
@endif

@endsection