<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task Manager</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      min-height: 100vh; color:#111;
    }

    /* Navbar */
    .navbar {
      position: sticky; top: 0; z-index: 50;
      background: rgba(255,255,255,.95);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(226,232,240,.8);
      box-shadow: 0 4px 24px rgba(0,0,0,.08);
    }
    .nav-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
    .nav-content { display:flex; align-items:center; justify-content:space-between; height: 72px; }
    .nav-left { display:flex; align-items:center; gap:40px; }

    .logo { display:flex; align-items:center; gap:14px; text-decoration:none; }
    .logo-badge {
      width: 40px; height: 40px; border-radius: 12px; color:#fff;
      display:flex; align-items:center; justify-content:center;
      background: linear-gradient(135deg,#667eea,#764ba2);
      box-shadow: 0 8px 24px rgba(102,126,234,.3);
      position: relative; overflow:hidden;
    }
    .logo-badge::before{
      content:''; position:absolute; inset:-100% auto auto -100%;
      width:200%; height:200%;
      background: linear-gradient(45deg,transparent,rgba(255,255,255,.35),transparent);
      transform: rotate(45deg); animation: shine 3s ease-in-out infinite;
    }
    @keyframes shine{ 0%{transform:translate(-100%,-100%) rotate(45deg);} 50%{transform:translate(30%,30%) rotate(45deg);} 100%{transform:translate(100%,100%) rotate(45deg);} }

    .logo-text { line-height:1.1; }
    .logo-title{
      font-weight:800; letter-spacing:-.3px; font-size:20px;
      background: linear-gradient(135deg,#667eea,#764ba2);
      -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
    }
    .logo-sub { font-size:11px; color:#64748b; text-transform:uppercase; letter-spacing:.6px; }

    .nav-links{ display:flex; gap:22px; align-items:center; }
    .nav-link{
      text-decoration:none; color:#64748b; font-weight:600; font-size:14px;
      padding:10px 14px; border-radius:10px; transition:.2s ease;
      display:flex; gap:8px; align-items:center;
    }
    .nav-link:hover{ color:#667eea; background:rgba(102,126,234,.10); transform: translateY(-1px); }
    .nav-link.active{ color:#667eea; background:linear-gradient(135deg,rgba(102,126,234,.10),rgba(118,75,162,.10)); border:1px solid rgba(102,126,234,.2); }

    .user-area{ display:flex; align-items:center; gap:14px; }
    .notif{ position:relative; padding:10px; border-radius:10px; cursor:pointer;
      background:rgba(102,126,234,.10); border:1px solid rgba(102,126,234,.2); }
    .notif:hover{ background:rgba(102,126,234,.15); transform: translateY(-1px); }
    .badge{ position:absolute; top:4px; right:4px; width:18px; height:18px; border-radius:50%; font-size:11px; font-weight:700;
      background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; display:flex; align-items:center; justify-content:center; }

    .dropdown{ position:relative; }
    .drop-trigger{
      display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:12px;
      background: rgba(255,255,255,.8); border:1px solid rgba(226,232,240,.8); cursor:pointer; transition:.2s ease;
    }
    .drop-trigger:hover{ background:#fff; border-color:#667eea; box-shadow:0 4px 16px rgba(0,0,0,.08); transform: translateY(-1px); }
    .avatar{
      width:36px; height:36px; border-radius:10px; color:#fff; font-weight:700; font-size:14px;
      display:flex; align-items:center; justify-content:center;
      background: linear-gradient(135deg,#667eea,#764ba2);
      box-shadow: 0 4px 16px rgba(102,126,234,.3);
    }
    .user-meta{ display:flex; flex-direction:column; line-height:1.1; }
    .user-name{ font-weight:600; color:#1a202c; font-size:14px; }
    .user-role{ font-size:11px; color:#64748b; }
    .drop-menu{
      position:absolute; top:calc(100% + 8px); right:0; min-width:260px; z-index:40;
      background: rgba(255,255,255,.96); backdrop-filter: blur(20px);
      border:1px solid rgba(226,232,240,.8); border-radius:16px; padding:12px;
      box-shadow: 0 20px 40px rgba(0,0,0,.15);
      animation: dm .2s ease-out;
    }
    @keyframes dm{ from{opacity:0; transform: translateY(-6px) scale(.98);} to{opacity:1; transform:none;} }
    .dm-item{
      display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px;
      color:#64748b; text-decoration:none; font-weight:500; transition:.15s ease; margin-bottom:4px;
    }
    .dm-item:hover{ background:rgba(102,126,234,.10); color:#667eea; }
    .dm-item.danger{ color:#ef4444; }
    .dm-item.danger:hover{ background: rgba(239,68,68,.10); color:#dc2626; }

    .mobile-btn{ display:none; padding:8px; border-radius:8px; border:0; background:transparent; color:#64748b; }
    .mobile-btn:hover{ background: rgba(102,126,234,.10); color:#667eea; }

    @media (max-width: 900px){
      .nav-links{ display:none; }
      .mobile-btn{ display:block; }
    }

    /* Page container + flash blocks */
    .page { max-width: 1280px; margin: 24px auto; padding: 0 24px 48px; }
    .flash{ background:#e7f7ed; padding:10px 12px; border-radius:10px; margin-bottom:12px; }
    .errors{ background:#fde8e8; padding:10px 12px; border-radius:10px; margin-bottom:12px; }
  </style>
</head>
<body
  x-data="{
    mobileOpen:false,
    ddOpen:false,
    notifications: 0
  }"
>
  {{-- NAVBAR --}}
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-content">
        <div class="nav-left">
          <a href="{{ route('tasks.index') }}" class="logo" title="TaskFlow Pro">
            <div class="logo-badge">🚀</div>
            <div class="logo-text">
              <div class="logo-title">TaskFlow</div>
              <div class="logo-sub">Professional</div>
            </div>
          </a>

          <div class="nav-links">
            <a href="{{ route('tasks.index') }}" class="nav-link active">📊 Dashboard</a>
            <a href="#" class="nav-link" onclick="return false;">📋 Projects</a>
            <a href="#" class="nav-link" onclick="return false;">👥 Team</a>
            <a href="#" class="nav-link" onclick="return false;">📈 Analytics</a>
          </div>
        </div>

        <div class="user-area">
          <div class="notif" title="Notifications" x-show="notifications > 0">
            <span style="font-size:18px;">🔔</span>
            <div class="badge" x-text="notifications"></div>
          </div>

          @php
            $u = auth()->user();
            $initial = $u ? strtoupper(substr($u->name, 0, 1)) : 'G';
          @endphp

          @auth
            <div class="dropdown" x-data="{open:false}">
              <button class="drop-trigger" @click="open=!open">
                <div class="avatar">{{ $initial }}</div>
                <div class="user-meta">
                  <div class="user-name">{{ $u->name }}</div>
                  <div class="user-role">Member</div>
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" style="color:#64748b; margin-left:2px;">
                  <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </button>

              <div class="drop-menu" x-show="open" @click.outside="open=false" x-transition>
                <div class="dm-item" onclick="return false;">👤 Profile</div>
                <div class="dm-item" onclick="return false;">⚙️ Settings</div>
                <hr style="border:none; height:1px; background:rgba(226,232,240,.8); margin:8px 0;">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dm-item danger" type="submit">🚪 Sign out</button>
                </form>
              </div>
            </div>
          @endauth

          @guest
            <a class="nav-link" href="{{ route('login') }}">Login</a>
            @if (Route::has('register'))
              <a class="nav-link" href="{{ route('register') }}">Register</a>
            @endif
          @endguest

          <button class="mobile-btn" @click="mobileOpen=!mobileOpen" aria-label="Open menu">
            <svg width="24" height="24" viewBox="0 0 24 24">
              <path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
              <path x-show="mobileOpen" d="M6 6l12 12M6 18L18 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
            </svg>
          </button>
        </div>
      </div>

      {{-- Mobile menu --}}
      <div x-show="mobileOpen" x-transition
           style="padding:16px 0 20px; display:grid; gap:8px;">
        <div style="display:grid; gap:6px; padding:0 4px;">
          <a href="{{ route('tasks.index') }}" class="nav-link active">📊 Dashboard</a>
          <a href="#" class="nav-link" onclick="return false;">📋 Projects</a>
          <a href="#" class="nav-link" onclick="return false;">👥 Team</a>
          <a href="#" class="nav-link" onclick="return false;">📈 Analytics</a>
        </div>

        <div style="border-top:1px solid rgba(226,232,240,.8); margin-top:8px; padding:12px 4px 0;">
          @auth
            <div style="display:flex; align-items:center; gap:10px; padding:10px; background:rgba(102,126,234,.06); border-radius:12px; margin-bottom:8px;">
              <div class="avatar">{{ $initial }}</div>
              <div>
                <div class="user-name">{{ $u->name }}</div>
                <div class="user-role" style="margin-top:2px;">Member</div>
              </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dm-item danger" type="submit" style="width:100%; justify-content:center;">🚪 Sign out</button>
            </form>
          @endauth

          @guest
            <a class="dm-item" href="{{ route('login') }}" style="justify-content:center;">Login</a>
            @if (Route::has('register'))
              <a class="dm-item" href="{{ route('register') }}" style="justify-content:center;">Register</a>
            @endif
          @endguest
        </div>
      </div>
    </div>
  </nav>

  {{-- Flash + Errors --}}
  <div class="page">
    @if (session('status'))
      <div class="flash">{{ session('status') }}</div>
    @endif

    @if (session('success'))
      <div class="flash">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="errors">
        <ul style="padding-left:18px;">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Page content --}}
    <main>
      @yield('content')
    </main>
  </div>
</body>
</html>
