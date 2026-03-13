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