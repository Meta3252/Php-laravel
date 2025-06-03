@extends('layouts.app')

@section('title', 'รายการงาน')

@section('content')
    <div class="container">
        <h1 class="mb-4">รายการงานทั้งหมด</h1>


        <div class="mb-3">
            <a href="{{ route('tasks.create') }}" class="btn btn-success">
                + เพิ่มข้อมูล
            </a>
        </div>

        <form method="GET" action="{{ route('tasks.index') }}" class="row g-3 mb-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                <input type="text" name="start_date" id="start_date" class="form-control"
                    value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label for="end_date" class="form-label">วันที่สิ้นสุด</label>
                <input type="text" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-primary flex-grow-1">ค้นหา</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary flex-grow-1">ล้างตัวเลือก</a>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ประเภท</th>
                    <th>ชื่อ</th>
                    <th>เวลาเริ่ม</th>
                    <th>เวลาสิ้นสุด</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>{{ $task->type }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->startTime }}</td>
                        <td>{{ $task->endTime }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('ยืนยันการลบ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">ไม่พบรายการ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            สรุปจำนวนสถานะรายเดือน
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="month" class="form-label">เลือกเดือน</label>
                    <input type="month" name="month" id="month" class="form-control"
                        value="{{ request('month') }}">
                </div>
                <div class="col-md-3 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-info flex-grow-1">แสดงสรุป</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary flex-grow-1">ล้าง</a>
                </div>
            </form>

            @if (isset($summary))
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>สถานะ</th>
                            <th>จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summary as $status => $count)
                            <tr>
                                <td>{{ $status }}</td>
                                <td>{{ $count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        flatpickr.localize(flatpickr.l10ns.th);

        flatpickr("#start_date", {
            dateFormat: "Y-m-d"
        });

        flatpickr("#end_date", {
            dateFormat: "Y-m-d"
        });
    </script>
@endpush
