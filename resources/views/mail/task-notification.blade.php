@php
    use Carbon\Carbon;
@endphp

<p>Hello {{ $data['user'] ?? '' }},</p>
<p>This is a reminder that your task <strong>{{ $data['name'] ?? '' }}</strong> is due on {{ Carbon::parse($data['due_date'])->format('F j, Y') }}.</p>
<p>Best regards, <br>TaskApp</p>
