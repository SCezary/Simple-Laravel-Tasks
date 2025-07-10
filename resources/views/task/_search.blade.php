@php
    use App\Enums\TaskPriorityEnum;
    use App\Enums\TaskStatusEnum;
@endphp

<form action="{{ route('tasks.index') }}" method="get">
    <div class="row">
        <div class="col-md-2">
            <label>Name</label>
            <input class="form-control" type="text" name="name" placeholder="Name" value="{{ request('name') }}"/>
        </div>
        <div class="col-md-2">
            <label>Status</label>
            <select class="form-control" name="status">
                <option value="">All</option>
                @foreach(TaskStatusEnum::cases() as $status)
                    <option
                        value="{{ $status }}" @selected(request('status') === $status->value)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>Priority</label>
            <select class="form-control" name="priority">
                <option value="">All</option>
                @foreach(TaskPriorityEnum::cases() as $priority)
                    <option
                        value="{{ $priority }}" @selected(request('priority') === $priority->value)>{{ $priority }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Date From</label>
            <input type="datetime-local" name="due_date-from" class="form-control" value="{{ request('due_date-from') }}" placeholder="From">
        </div>
        <div class="col-md-3">
            <label>Date To</label>
            <input type="datetime-local" name="due_date-to" class="form-control" value="{{ request('due_date-to') }}" placeholder="To">
        </div>
        <div class="col-md-1 mt-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
