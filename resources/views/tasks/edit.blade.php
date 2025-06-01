@extends('layouts.app')

@section('title', 'แก้ไขงาน')

@section('content')
<div class="card shadow">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">กำลังแก้ไขรายการ {{ $task->name }}</h4>
    </div>
    <div class="card-body">
        @include('tasks.partials.form', [
            'route' => route('tasks.update', $task->id),
            'method' => 'PUT',
            'task' => $task
        ])
    </div>
</div>
@endsection
