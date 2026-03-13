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