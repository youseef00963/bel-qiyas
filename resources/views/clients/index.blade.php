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