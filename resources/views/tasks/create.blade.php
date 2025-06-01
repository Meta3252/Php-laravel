@extends('layouts.app')

@section('title', 'เพิ่มงาน')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">เพิ่มงานใหม่</h4>
    </div>
    <div class="card-body">
        @include('tasks.partials.form', [
            'route' => route('tasks.store'),
            'method' => 'POST',
            'task' => null
        ])
    </div>
</div>
@endsection
