@extends('layouts.app')

@section('content')
  <h1>{{ $task->title }}</h1>
  <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
  <p><strong>Created:</strong> {{ $task->created_at->format('Y-m-d H:i') }}</p>
  @if($task->description)
    <p>{{ $task->description }}</p>
  @endif
  <a href="{{ route('tasks.edit', $task) }}">Edit</a>
@endsection
