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