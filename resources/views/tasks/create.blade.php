@extends('layouts.app')

@section('content')
<div class="relative">
  <!-- Decorative blobs -->
  <div class="pointer-events-none absolute inset-x-0 -top-24 h-48 opacity-40 blur-3xl"
       style="background: radial-gradient(40% 60% at 20% 40%, #a78bfa55 0%, transparent 60%),
                radial-gradient(40% 60% at 80% 60%, #60a5fa55 0%, transparent 60%);">
  </div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="grid place-items-center w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 via-fuchsia-500 to-amber-500 shadow-lg shadow-fuchsia-500/20 text-white">
          <!-- icon -->
          <span class="text-xl">📝</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-amber-600 bg-clip-text text-transparent">
          New Task
        </h1>
      </div>

      <a href="{{ route('tasks.index') }}"
         class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-indigo-600">
        <span>←</span> Back to Tasks
      </a>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
      <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    @if (session('status'))
      <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
        {{ session('status') }}
      </div>
    @endif

    <!-- Card with gradient border -->
    <div class="rounded-2xl bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-amber-500 p-[2px] shadow-xl shadow-indigo-500/10">
      <div class="rounded-2xl border border-white/60 bg-white/80 backdrop-blur-xl">
        <form method="POST" action="{{ route('tasks.store') }}" class="p-6 sm:p-8">
          @csrf

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
                value="{{ old('title') }}"
                required
                class="mt-2 block w-full rounded-xl border-slate-200 bg-white/90
                       focus:border-transparent focus:ring-2 focus:ring-offset-2
                       focus:ring-indigo-400 focus:ring-offset-indigo-100"
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
                class="mt-2 block w-full rounded-xl border-slate-200 bg-white/90
                       focus:border-transparent focus:ring-2 focus:ring-offset-2
                       focus:ring-fuchsia-400 focus:ring-offset-fuchsia-100"
                placeholder="Add any useful details…"
              >{{ old('description') }}</textarea>
              @error('description')
                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Status -->
            <div>
              <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
              </label>
              @php $st = old('status', 'pending'); @endphp
              <div class="relative">
                <select
                  id="status"
                  name="status"
                  class="mt-2 block w-full appearance-none rounded-xl border-slate-200 bg-white/90 pr-10
                         focus:border-transparent focus:ring-2 focus:ring-offset-2
                         focus:ring-amber-400 focus:ring-offset-amber-100"
                >
                  <option value="pending" @selected($st === 'pending')>Pending</option>
                  <option value="done" @selected($st === 'done')>Done</option>
                </select>
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">▾</span>
              </div>
              @error('status')
                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Actions -->
          <div class="mt-8 flex flex-wrap items-center gap-3">
            <button type="submit"
              class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-black font-semibold
                     bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-amber-500
                     hover:from-indigo-500 hover:via-fuchsia-500 hover:to-amber-400
                     shadow-md shadow-fuchsia-500/30 transition-transform hover:-translate-y-0.5">
              Save Task
            </button>

            <a href="{{ route('tasks.index') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl font-semibold
                      text-slate-700 border border-slate-200 bg-white/80 hover:bg-white
                      shadow-sm hover:shadow transition">
              Cancel
            </a>

            <!-- Friendly tip chip -->
            <span class="ml-auto inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-sm font-medium text-indigo-700">
              <span class="inline-block h-2 w-2 rounded-full bg-indigo-500"></span>
              Auto-saved on submit
            </span>
          </div>
        </form>
      </div>
    </div>

    <!-- Helpful hint -->
    <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900 shadow-sm">
      <p class="text-sm">
        <span class="font-semibold">Tip:</span> Use clear, action-first titles. Update status to
        <span class="font-semibold text-emerald-700">Done</span> when finished.
      </p>
    </div>
  </div>
</div>
@endsection
