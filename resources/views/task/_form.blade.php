@php
    use App\Enums\TaskPriorityEnum;use App\Enums\TaskStatusEnum;use App\Models\Task;

    $isUpdate = isset($task) && $task instanceof Task;
@endphp

<form action="@if($isUpdate) {{ route('tasks.update', ['task' => $task]) }} @else {{ route('tasks.store') }} @endif"
      method="POST">
    @csrf
    @if($isUpdate)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="required">Name</label>
        <input class="form-control @if($errors->has('name')) is-invalid @endif" type="text" name="name" id="name"
               value="{{ old('name', $task->name ?? '') }}" required/>
        @error('name')
        <div id="name-feedback" class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description">Description</label>
        <textarea class="form-control @if($errors->has('description')) is-invalid @endif" type="text" name="description"
                  id="description">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
        <div id="name-feedback" class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="priority">Priority</label>
        <select class="form-control @if($errors->has('priority')) is-invalid @endif" id="priority" name="priority"
                required>
            @foreach(TaskPriorityEnum::cases() as $priority)
                <option
                    value="{{ $priority }}" @selected(old('priority', $task->priority ?? '') === $priority)>{{ $priority }}</option>
            @endforeach
        </select>
        @error('priority')
        <div id="name-feedback" class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="status">Status</label>
        <select class="form-control @if($errors->has('status')) is-invalid @endif" id="status" name="status"
                required>
            @foreach(TaskStatusEnum::cases() as $status)
                <option
                    value="{{ $status }}" @selected(old('status', $task->status ?? '') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('priority')
        <div id="name-feedback" class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="due_date" class="required">Due Date</label>
        <input class="form-control @if($errors->has('due_date')) is-invalid @endif" type="datetime-local"
               name="due_date" id="due-date" value="{{ old('due_date', $task->due_date ?? '') }}" min="{{ now()->format('Y-m-d H:i') }}"/>
        @error('due_date')
        <span class="d-block form-error-message">{{ $message }}</span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">@if($isUpdate)
            Update
        @else
            Create
        @endif
    </button>
</form>
