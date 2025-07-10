@php
    use App\Enums\TaskLogActionEnum;use Carbon\Carbon;use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ $task->name }}</h3>
        <p class="mb-1"><b>Priority:</b> {{ $task->priority }}</p>
        <p class="mb-1"><b>Status:</b> {{ $task->status }}</p>
        <p class="mb-1"><b>Due Date:</b> {{ $task->due_date }}</p>
        <div class="col">
            <p class="mb-1"><b>Description:</b></p>
            <div class="col-md-12">
                {{ $task->description }}
            </div>
        </div>
        @auth
            <hr>
            <a class="btn btn-primary" href="{{ route('tasks.edit', ['task' => $task]) }}">Update</a>
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#share-task-modal">Share
            </button>
            <button class="btn btn-danger"
                    id="js-destroy-action"
                    data-js-action="{{ route('tasks.destroy', ['task' => $task]) }}"
                    data-js-action-content="Are you sure you want to delete {{ $task->name }}"
                    data-js-action-confirm="Delete"
                    data-js-action-feedback="{{ route('tasks.index') }}"
                    type="button">
                Delete
            </button>

            <hr/>
            <h3>Logs:</h3>
            <div class="accordion task-logs-list" id="logs-accordion">
                @forelse($task->mappedLogs() as $log)
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#log-{{ $log['id'] }}" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                <div class="flex-1 d-flex w-100">
                                    <div>{{ Str::upper($log['action']) }}</div>
                                    <div class="ms-auto pe-2">{{ Carbon::create($log['created_at'])->format('F j H:i, Y') }}</div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="accordion-collapse task-log-container collapse" id="log-{{ $log['id'] }}">
                        @foreach($log['merged_data'] as $key => $value)
                            <div class="task-log-property @if(isset($log['data_changes'][$key])) --changed @endif">
                                {{ $key }}: <span class="value">{{ $value }}</span>
                            </div>
                        @endforeach
                        <p class="mt-3 m-0 task-log-info">Elements in color indicate changes from the previous version.</p>
                    </div>
                @empty
                    <p>No changes recorder.</p>
                @endforelse
            </div>
        @endauth
    </div>
@endsection

<div class="modal" tabindex="-1" id="share-task-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                Share Task
            </div>
            <div class="modal-body">
                <div class="shared-task-list mb-2" id="js-shared-task-list">
                    @forelse($task->sharedNotExpiredTasks()->get() as $sharedTask)
                        <div class="shared-task">
                            <a href="{{ route('tasks.shared-view', ['token' => $sharedTask->token]) }}" target="_blank"
                               class="btn btn-secondary">Open</a>
                            <div class="ms-auto">
                                {{ Carbon::parse($sharedTask->expires_at)->format('F j H:i, Y') }}
                            </div>
                        </div>
                    @empty
                        {{--                        <p>No Shares.</p>--}}
                    @endforelse
                </div>
                <form action="{{ route('tasks.share', ['task' => $task ]) }}" class="mt-2">
                    @csrf
                    <div class="mb-2">
                        <label for="expires_at" class="required">Expires At:</label>
                        <input class="form-control" type="datetime-local" name="expires_at" id="expires_at"
                               min="{{ now()->format('Y-m-d H:i') }}" required/>
                    </div>
                    <span class="form-error-message" id="js-share-form-error"></span>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary" id="js-share-form">Share</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
