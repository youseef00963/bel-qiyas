@extends('layouts.app')
@section('content')
<h1>الصفحة الرئيسية</h1>

<div class="card" style="background: linear-gradient(135deg, #8b6f5e, #a08070); color: white; padding: 32px;">
    <div style="font-size: 14px; opacity: 0.85; margin-bottom: 8px;">إجمالي الديون على الزبائن</div>
    <div style="font-size: 42px; font-weight: 700;">{{ number_format($totalDebt, 0) }}</div>
    <div style="font-size: 14px; opacity: 0.75;">ليرة سورية</div>
</div>

<div class="card">
    <h2>⚡ الأولويات — زبائن بانتظار التسليم</h2>
    @if($priorityClients->isEmpty())
        <p style="color: #aaa; text-align: center; padding: 24px;">لا يوجد طلبات قيد التنفيذ حالياً</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>اسم الزبونة</th>
                    <th>تاريخ التسليم</th>
                    <th>عدد الطلبات</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($priorityClients as $client)
                <tr>
                    <td><strong>{{ $client->full_name }}</strong></td>
                    <td>{{ optional($client->orders->first())->delivery_date ?? 'غير محدد' }}</td>
                    <td>{{ $client->orders->count() }} طلب</td>
                    <td><a href="{{ route('clients.show', $client) }}" class="btn btn-outline" style="padding: 6px 16px; font-size: 13px;">عرض</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection