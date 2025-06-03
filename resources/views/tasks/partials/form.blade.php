<!-- resources/views/tasks/partials/form.blade.php -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $route }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label">ประเภทงาน</label>
        <select name="type" class="form-select" required>
            <option value="">-- เลือกประเภทงาน --</option>
            <option value="Computer" {{ old('type', $task->type ?? '') == 'Computer' ? 'selected' : '' }}>Computer
            </option>
            <option value="Computer Repair" {{ old('type', $task->type ?? '') == 'Computer Repair' ? 'selected' : '' }}>
                Computer Repair</option>
            <option value="Network" {{ old('type', $task->type ?? '') == 'Network' ? 'selected' : '' }}>Network</option>
        </select>
        @error('type')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label class="form-label">ชื่องาน</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $task->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">เวลาเริ่มต้น</label>
        <input type="text" id="startTime" name="startTime" class="form-control"
            value="{{ old('startTime', isset($task) ? \Carbon\Carbon::parse($task->startTime)->format('Y-m-d H:i') : '') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">เวลาสิ้นสุด</label>
        <input type="text" id="endTime" name="endTime" class="form-control"
            value="{{ old('endTime', isset($task) ? \Carbon\Carbon::parse($task->endTime)->format('Y-m-d H:i') : '') }}">
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">สถานะ</label>
        <select name="status" id="status" class="form-select" required>
            <option value="">-- เลือกสถานะ --</option>
            <option value="ดำเนินการ" {{ old('status', $task->status ?? '') == 'ดำเนินการ' ? 'selected' : '' }}>
                ดำเนินการ</option>
            <option value="เสร็จสิ้น" {{ old('status', $task->status ?? '') == 'เสร็จสิ้น' ? 'selected' : '' }}>
                เสร็จสิ้น</option>
            <option value="ยกเลิก" {{ old('status', $task->status ?? '') == 'ยกเลิก' ? 'selected' : '' }}>ยกเลิก
            </option>
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">บันทึก</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">ยกเลิก</a>
</form>

@push('scripts')
    <script>
        flatpickr.localize(flatpickr.l10ns.th); // ใช้ locale ภาษาไทย ถ้ามี

        flatpickr("#startTime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });

        flatpickr("#endTime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    </script>
@endpush
