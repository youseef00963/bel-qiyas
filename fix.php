<?php

if (!is_dir('resources/views/layouts')) mkdir('resources/views/layouts', 0755, true);
if (!is_dir('resources/views/clients')) mkdir('resources/views/clients', 0755, true);
if (!is_dir('resources/views/payments')) mkdir('resources/views/payments', 0755, true);

// =============================================
// 1. layouts/app.blade.php
// =============================================
file_put_contents('resources/views/layouts/app.blade.php', <<<'EOT'
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'بالقياس' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f5f0eb; color: #3a3a3a; direction: rtl; }
        nav { background: #fff; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e8e0d8; box-shadow: 0 1px 4px rgba(0,0,0,0.05); }
        nav .logo { font-size: 20px; font-weight: 600; color: #8b6f5e; }
        nav .nav-links a { text-decoration: none; color: #6b6b6b; margin-left: 24px; font-size: 14px; }
        nav .nav-links a:hover { color: #8b6f5e; }
        nav .logout button { background: none; border: 1px solid #d4b5a8; color: #8b6f5e; padding: 6px 16px; border-radius: 6px; cursor: pointer; font-size: 13px; font-family: inherit; }
        nav .logout button:hover { background: #8b6f5e; color: white; }
        .container { max-width: 1100px; margin: 32px auto; padding: 0 24px; }
        .card { background: white; border-radius: 12px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px; }
        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px; text-decoration: none; transition: all 0.2s; font-family: inherit; }
        .btn-primary { background: #8b6f5e; color: white; }
        .btn-primary:hover { background: #7a5f4f; }
        .btn-outline { background: white; border: 1px solid #8b6f5e; color: #8b6f5e; }
        .btn-outline:hover { background: #f5ede9; }
        input, textarea, select { width: 100%; padding: 10px 14px; border: 1px solid #e0d5ce; border-radius: 8px; font-size: 14px; font-family: inherit; background: #fdfaf8; direction: rtl; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #8b6f5e; }
        input[disabled] { background: #f0f0f0; color: #999; }
        label { display: block; font-size: 13px; color: #7a7a7a; margin-bottom: 6px; }
        .form-group { margin-bottom: 18px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .alert-success { background: #edf7ed; border: 1px solid #b8ddb8; color: #3a7a3a; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        h1 { font-size: 22px; color: #3a3a3a; margin-bottom: 24px; }
        h2 { font-size: 18px; color: #5a5a5a; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f9f5f2; padding: 12px; text-align: right; font-size: 13px; color: #7a7a7a; border-bottom: 1px solid #eee; }
        td { padding: 12px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
        tr:hover td { background: #fdfaf8; }
    </style>
</head>
<body>
<nav>
    <div class="logo">🧵 بالقياس</div>
    <div class="nav-links">
        <a href="{{ route('dashboard') }}">الرئيسية</a>
        <a href="{{ route('clients.create') }}">زبونة جديدة</a>
        <a href="{{ route('clients.index') }}">الزبائن</a>
        <a href="{{ route('payments.index') }}">الديون</a>
    </div>
    <div class="logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">خروج</button>
        </form>
    </div>
</nav>
<div class="container">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
</body>
</html>
EOT);
echo "✓ layouts/app.blade.php\n";

// =============================================
// 2. auth/login.blade.php
// =============================================
file_put_contents('resources/views/auth/login.blade.php', <<<'EOT'
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - بالقياس</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f5f0eb; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: white; padding: 48px 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); width: 100%; max-width: 400px; text-align: center; }
        .logo { font-size: 32px; margin-bottom: 8px; }
        .logo-text { font-size: 22px; color: #8b6f5e; font-weight: 600; margin-bottom: 4px; }
        .subtitle { color: #aaa; font-size: 13px; margin-bottom: 36px; }
        .form-group { margin-bottom: 18px; text-align: right; }
        label { display: block; font-size: 13px; color: #7a7a7a; margin-bottom: 6px; }
        input { width: 100%; padding: 11px 14px; border: 1px solid #e0d5ce; border-radius: 8px; font-size: 14px; background: #fdfaf8; direction: rtl; font-family: inherit; }
        input:focus { outline: none; border-color: #8b6f5e; }
        .btn { width: 100%; padding: 12px; background: #8b6f5e; color: white; border: none; border-radius: 8px; font-size: 15px; cursor: pointer; margin-top: 8px; font-family: inherit; }
        .btn:hover { background: #7a5f4f; }
        .error { background: #fdf0f0; border: 1px solid #f0c0c0; color: #c0392b; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">🧵</div>
        <div class="logo-text">بالقياس</div>
        <div class="subtitle">نظام إدارة الخياطة</div>
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">دخول</button>
        </form>
    </div>
</body>
</html>
EOT);
echo "✓ auth/login.blade.php\n";

// =============================================
// 3. dashboard.blade.php
// =============================================
file_put_contents('resources/views/dashboard.blade.php', <<<'EOT'
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
EOT);
echo "✓ dashboard.blade.php\n";

// =============================================
// 4. clients/index.blade.php
// =============================================
file_put_contents('resources/views/clients/index.blade.php', <<<'EOT'
@extends('layouts.app')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1 style="margin: 0;">الزبائن</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">+ زبونة جديدة</a>
</div>
<div class="card">
    @if($clients->isEmpty())
        <p style="color: #aaa; text-align: center; padding: 24px;">لا يوجد زبائن بعد</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الطول</th>
                    <th>العرض</th>
                    <th>تاريخ الإضافة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td><strong>{{ $client->full_name }}</strong></td>
                    <td>{{ $client->height ?? '-' }}</td>
                    <td>{{ $client->width ?? '-' }}</td>
                    <td>{{ $client->created_at->format('Y/m/d') }}</td>
                    <td><a href="{{ route('clients.show', $client) }}" class="btn btn-outline" style="padding: 6px 16px; font-size: 13px;">عرض</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
EOT);
echo "✓ clients/index.blade.php\n";

// =============================================
// 5. clients/create.blade.php
// =============================================
file_put_contents('resources/views/clients/create.blade.php', <<<'EOT'
@extends('layouts.app')
@section('content')
<h1>إضافة زبونة جديدة</h1>
<div class="card">
    <form method="POST" action="{{ route('clients.store') }}">
        @csrf
        <div class="form-group">
            <label>الاسم الكامل *</label>
            <input type="text" name="full_name" required placeholder="أدخلي الاسم الكامل">
        </div>
        <div class="form-row">
            <div class="form-group"><label>الطول (سم)</label><input type="number" step="0.1" name="height" placeholder="165"></div>
            <div class="form-group"><label>العرض (سم)</label><input type="number" step="0.1" name="width" placeholder="60"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>طول الكم (سم)</label><input type="number" step="0.1" name="sleeve_length" placeholder="58"></div>
            <div class="form-group"><label>عرض الكم (سم)</label><input type="number" step="0.1" name="sleeve_width" placeholder="28"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>دوران الصدر (سم)</label><input type="number" step="0.1" name="chest_circumference" placeholder="90"></div>
            <div class="form-group"><label>دوران الخصر (سم)</label><input type="number" step="0.1" name="waist_circumference" placeholder="70"></div>
        </div>
        <div class="form-group">
            <label>ملاحظات</label>
            <textarea name="notes" rows="3" placeholder="أي ملاحظات خاصة..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">إضافة الزبونة</button>
        <a href="{{ route('clients.index') }}" class="btn btn-outline" style="margin-right: 12px;">إلغاء</a>
    </form>
</div>
@endsection
EOT);
echo "✓ clients/create.blade.php\n";

// =============================================
// 6. clients/show.blade.php
// =============================================
file_put_contents('resources/views/clients/show.blade.php', <<<'EOT'
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
EOT);
echo "✓ clients/show.blade.php\n";

// =============================================
// 7. payments/index.blade.php
// =============================================
file_put_contents('resources/views/payments/index.blade.php', <<<'EOT'
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
EOT);
echo "✓ payments/index.blade.php\n";

echo "\n=====================================\n";
echo "✅ تم إنشاء كل الملفات!\n";
echo "=====================================\n";
$files = [
    'resources/views/layouts/app.blade.php',
    'resources/views/auth/login.blade.php',
    'resources/views/dashboard.blade.php',
    'resources/views/clients/index.blade.php',
    'resources/views/clients/create.blade.php',
    'resources/views/clients/show.blade.php',
    'resources/views/payments/index.blade.php',
];
foreach ($files as $f) {
    echo "  " . filesize($f) . " bytes → " . $f . "\n";
}