@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
      Edit Task
    </h1>
    <a href="{{ route('tasks.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-indigo-600">
      <span>←</span> Back to Tasks
    </a>
  </div>

  <!-- Card -->
  <div class="rounded-2xl border border-slate-200/80 bg-white/80 backdrop-blur-xl shadow-xl shadow-slate-900/5">
    <form method="POST" action="{{ route('tasks.update', $task) }}" class="p-6 sm:p-8">
      @csrf @method('PUT')

      <div class="grid grid-cols-1 gap-6">
        <!-- Title -->
        <div>
          <label for="title" class="block text-sm font-semibold text-slate-700">
            Title <span class="text-rose-500">*</span>
          </label>
          <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $task->title) }}"
            required
            class="mt-2 block w-full rounded-xl border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-offset-0"
            placeholder="e.g. Prepare weekly report"
          />
          @error('title')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="block text-sm font-semibold text-slate-700">
            Description
          </label>
          <textarea
            id="description"
            name="description"
            rows="5"
            class="mt-2 block w-full rounded-xl border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-offset-0"
            placeholder="Add any useful details…"
          >{{ old('description', $task->description) }}</textarea>
          @error('description')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Status -->
        <div>
          <label for="status" class="block text-sm font-semibold text-slate-700">
            Status
          </label>
          @php $st = old('status', $task->status); @endphp
          <select
            id="status"
            name="status"
            class="mt-2 block w-full rounded-xl border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-offset-0"
          >
            <option value="pending" @selected($st === 'pending')>Pending</option>
            <option value="done" @selected($st === 'done')>Done</option>
          </select>
          @error('status')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Actions -->
      <div class="mt-8 flex items-center gap-3">
        <button type="submit"
          class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white font-semibold
                 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500
                 shadow-md shadow-indigo-500/20 transition">
          Update Task
        </button>

        <a href="{{ route('tasks.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl font-semibold text-slate-700
                  border border-slate-200 hover:bg-slate-50 transition">
          Cancel
        </a>
      </div>
    </form>
  </div>

  <!-- Meta -->
  <p class="mt-4 text-sm text-slate-500">
    Last updated: <span class="font-medium text-slate-700">{{ $task->updated_at->format('Y-m-d H:i') }}</span>
  </p>
</div>
@endsection
