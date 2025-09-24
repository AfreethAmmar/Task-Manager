@extends('layouts.app')

@section('content')
<style>
    * { box-sizing: border-box; }
    body { color:#1a202c; }
    .container { max-width: 1200px; margin: 0 auto; padding: 24px; }
    .header { display:flex; align-items:center; justify-content:space-between; gap:24px; margin-bottom:28px; }
    .hero { display:flex; align-items:center; gap:20px; }
    .hero-img { width:80px; height:80px; border-radius:18px; overflow:hidden; box-shadow:0 12px 32px rgba(102,126,234,.25); }
    .hero-img img { width:100%; height:100%; object-fit:cover; }
    .title { font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem); font-weight: 800; letter-spacing:-.02em; background:linear-gradient(135deg,#111,#5b6b8a); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
    .subtitle { color:#64748b; font-weight:600; }
    .btn-primary { display:inline-flex; align-items:center; gap:10px; padding:12px 18px; border-radius:14px; background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; text-decoration:none; font-weight:600; border:0; box-shadow:0 10px 24px rgba(102,126,234,.28); transition:.2s; }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 14px 34px rgba(102,126,234,.36); }
    .stats { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:18px; margin-bottom:22px; }
    .card { background:#fff; border:1px solid #e6e9ef; border-radius:18px; padding:18px; box-shadow:0 6px 24px rgba(0,0,0,.06); }
    .stat-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
    .stat-ico { width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px; color:#fff; }
    .i-total{ background:linear-gradient(135deg,#3b82f6,#1d4ed8); }
    .i-done { background:linear-gradient(135deg,#10b981,#047857); }
    .i-pend { background:linear-gradient(135deg,#f59e0b,#d97706); }
    .i-over { background:linear-gradient(135deg,#ef4444,#dc2626); }
    .stat-num { font-size:28px; font-weight:800; }
    .stat-lbl { font-size:12px; text-transform:uppercase; color:#6b7280; font-weight:700; letter-spacing:.04em; }
    .panel { background:#fff; border:1px solid #e6e9ef; border-radius:20px; overflow:hidden; box-shadow:0 10px 28px rgba(0,0,0,.08); }
    .panel-hd { display:flex; align-items:center; justify-content:space-between; padding:16px 22px; background:linear-gradient(135deg,rgba(102,126,234,.06),rgba(118,75,162,.04)); border-bottom:1px solid #e6e9ef; }
    .legend { display:flex; gap:10px; }
    .legend span { display:inline-flex; align-items:center; gap:8px; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; border:1px solid transparent; }
    .lg-pend { color:#b45309; background:rgba(245,158,11,.1); border-color:rgba(245,158,11,.22); }
    .lg-done { color:#065f46; background:rgba(16,185,129,.1); border-color:rgba(16,185,129,.22); }
    .filters { display:flex; gap:12px; align-items:center; padding:14px 22px; background:#f8fafc; border-bottom:1px solid #e6e9ef; flex-wrap:wrap; }
    .f-btn { padding:8px 14px; border:1px solid #e6e9ef; background:#fff; border-radius:10px; font-size:14px; color:#64748b; font-weight:600; cursor:pointer; }
    .f-btn.active,.f-btn:hover { background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; border-color:transparent; }
    .search { margin-left:auto; position:relative; }
    .search input { width:260px; padding:10px 14px 10px 36px; border:1px solid #e6e9ef; border-radius:12px; }
    .search .ico { position:absolute; left:10px; top:50%; transform:translateY(-50%); opacity:.6; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    thead th { text-align:left; font-size:12px; text-transform:uppercase; color:#6b7280; font-weight:800; letter-spacing:.04em; padding:14px 22px; background:#f8fafc; border-bottom:1px solid #e6e9ef; }
    tbody td { padding:18px 22px; border-bottom:1px solid #eef2f7; vertical-align:top; }
    tbody tr:hover { background:#fafbff; }
    .t-title { font-weight:700; color:#111827; text-decoration:none; }
    .t-desc { font-size:13px; color:#6b7280; margin-top:4px; }
    .badge { display:inline-flex; gap:8px; align-items:center; padding:6px 10px; border-radius:999px; font-weight:700; font-size:12px; border:1px solid transparent; }
    .b-pend { color:#b45309; background:rgba(245,158,11,.1); border-color:rgba(245,158,11,.22); }
    .b-done { color:#065f46; background:rgba(16,185,129,.1); border-color:rgba(16,185,129,.22); }
    .dot { width:8px; height:8px; border-radius:50%; }
    .d-pend { background:#f59e0b; } .d-done { background:#10b981; }
    .date .p { font-weight:600; font-size:14px; color:#374151; }
    .date .s { font-size:12px; color:#9ca3af; }
    .actions { display:flex; justify-content:flex-end; gap:10px; }
    .btn { padding:8px 12px; border-radius:10px; border:1px solid; background:#fff; font-weight:600; font-size:14px; cursor:pointer; text-decoration:none; }
    .btn-edit { color:#667eea; border-color:rgba(102,126,234,.35); }
    .btn-edit:hover { background:rgba(102,126,234,.1); }
    .btn-del { color:#ef4444; border-color:rgba(239,68,68,.35); }
    .btn-del:hover { background:rgba(239,68,68,.1); }
    .empty { text-align:center; padding:72px 24px; }
    .empty img { width:120px; opacity:.9; margin-bottom:16px; }
    .pagination { padding:16px 22px; background:#f8fafc; border-top:1px solid #e6e9ef; }
    @media (max-width:900px){ .stats{grid-template-columns:repeat(2,1fr);} .search input{width:100%;} .search{margin-left:0;} .header{flex-direction:column; align-items:flex-start;} }
</style>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="hero">
            
            <div>
                <div class="title">My Tasks</div>
                <div class="subtitle">Create, track, and manage your tasks efficiently</div>
            </div>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn-primary">
            <span>＋</span> New Task
        </a>
    </div>

    <!-- Stats -->
    <div class="stats">
        <div class="card">
            <div class="stat-top">
                <div class="stat-ico i-total">📊</div>
                <div class="stat-lbl">Total</div>
            </div>
            <div class="stat-num">{{ $tasks->total() ?? $tasks->count() }}</div>
        </div>
        <div class="card">
            <div class="stat-top">
                <div class="stat-ico i-done">✅</div>
                <div class="stat-lbl">Completed</div>
            </div>
            <div class="stat-num">{{ $tasks->where('status','done')->count() }}</div>
        </div>
        <div class="card">
            <div class="stat-top">
                <div class="stat-ico i-pend">⏳</div>
                <div class="stat-lbl">In Progress</div>
            </div>
            <div class="stat-num">{{ $tasks->where('status','pending')->count() }}</div>
        </div>
        <div class="card">
            <div class="stat-top">
                <div class="stat-ico i-over">🚨</div>
                <div class="stat-lbl">Overdue</div>
            </div>
            <div class="stat-num">0</div>
        </div>
    </div>

    <!-- Panel -->
    <div class="panel">
        <div class="panel-hd">
            <strong>All Tasks</strong>
            <div class="legend">
                <span class="lg-pend"><span class="dot d-pend"></span>Pending</span>
                <span class="lg-done"><span class="dot d-done"></span>Completed</span>
            </div>
        </div>

        <div class="filters">
            <button class="f-btn active">All ({{ $tasks->count() }})</button>
            <button class="f-btn">Pending ({{ $tasks->where('status','pending')->count() }})</button>
            <button class="f-btn">Completed ({{ $tasks->where('status','done')->count() }})</button>

            <div class="search">
                <span class="ico">🔍</span>
                <input type="text" placeholder="Search tasks…" aria-label="Search tasks">
            </div>
        </div>

        @if ($tasks->count())
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            @php $isDone = $task->status === 'done'; @endphp
                            <tr>
                                <td>
                                    <a class="t-title" href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                                    @if ($task->description)
                                        <div class="t-desc">{{ $task->description }}</div>
                                    @endif
                                </td>
                                
                                <td class="date">
                                    <div class="p">{{ $task->created_at->format('Y-m-d H:i') }}</div>
                                    <div class="s">{{ $task->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-edit" href="{{ route('tasks.edit', $task) }}">Edit</a>
                                        <form action="{{ route('tasks.destroy', $task) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-del">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $tasks->links() }}
            </div>
        @else
            <div class="empty">
                <img src="{{ asset('images/tasks-hero.png') }}" alt="No tasks">
                <h3 style="font-size:22px; font-weight:800; margin-bottom:6px;">No tasks yet</h3>
                <p style="color:#64748b; margin-bottom:16px;">Create your first task to kickstart your productivity.</p>
                <a href="{{ route('tasks.create') }}" class="btn-primary"><span>＋</span>Create your first task</a>
            </div>
        @endif
    </div>
</div>
@endsection
