@php
    use App\Helpers\TaskHelper;
    use Illuminate\Support\Str;
@endphp

<a href="{{ route('tasks.show', ['task' => $task]) }}" class="task-link">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 d-flex">
                    <div>{{ $task->name }}</div>
                    <div class="ms-auto d-flex gap-2 align-items-center">
                        <div class="ms-auto">
                            <x-layout.badge
                                :type="TaskHelper::getStatusBadgeType($task->status)"
                                :value="Str::upper($task->status->value)"
                            />
                        </div>
                        <div class="ms-auto">
                            <x-layout.badge
                                :type="TaskHelper::getPriorityBadgeType($task->priority)"
                                :value="Str::upper($task->priority->value)"
                            />
                        </div>
                        {{ $task->due_date }}
                    </div>
                </div>
            </div>
        </div>
        @if(Str::length($task->description) > 0)
            <div class="card-body">
                {{ Str::limit($task->description, 150) }}
            </div>
        @endif
    </div>
</a>
