# TaskFlow Pro — Laravel Task Manager

A clean, **colorful**, and responsive Task Manager built with **Laravel**, **Blade**, **Tailwind CSS**, and **Vite**.  
Create, view, edit, and delete tasks with a polished UI and a friendly UX.

> After users register, they are redirected to **Login** .  
> After login, they land on **Tasks**.

---

## ✨ Features

- 🔐 **Authentication flow**
  - `GET /register` → Register page
  - `POST /register` → Creates user → **redirects to Login**
  - `GET /login` → Login page
  - `POST /login` → Authenticates → **redirects to Tasks**
  - `POST /logout` → Logs out → **redirects to Login**
- 📝 **Tasks CRUD** (title, description, status: `pending`/`done`)
- 📊 **Dashboard stats** (total, completed, pending)
- 🎨 **Modern colorful UI**
  - Tailwind-based gradients, glassmorphism, vivid focus rings
  - Accessible and fully responsive
- ⚡ **Vite** for fast asset pipeline
- 🧪 Server-side validation + flash messages

---

## 🧰 Tech Stack

- **Laravel** 12.x (PHP 8.2+)
- **Blade** templates
- **Tailwind CSS** + **Vite**
- **SQLite** (local dev) or **MySQL** (production)
- **Alpine.js** (optional for interactivity)

---

## 📂 Project Structure (high level)

```
app/
  Http/Controllers/Auth/
    AuthenticatedSessionController.php
    RegisteredUserController.php
  Http/Controllers/
    TaskController.php
resources/views/
  layouts/app.blade.php
  tasks/
    index.blade.php
    create.blade.php
    edit.blade.php
    show.blade.php
  auth/
    login.blade.php
    register.blade.php
public/images/
  tasks-hero.png   # optional decorative image used by the UI
```

---

## 🚀 Getting Started

### 1) Requirements
- PHP **8.2+**
- Composer **2.x**
- Node.js **18/20+** and npm **10+**
- SQLite (quick start) or MySQL

### 2) Install
```bash
git clone <your-repo-url>.git
cd taskflow-pro

# PHP deps
composer install

# Node deps
npm install
```

### 3) Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

**SQLite (quick start)**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Create the SQLite file:
```bash
# Windows (PowerShell)
mkdir -p database
type NUL > database/database.sqlite

# macOS/Linux
mkdir -p database
touch database/database.sqlite
```

**MySQL (alternative)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=secret
```

### 4) Migrate (and seed if needed)
```bash
php artisan migrate
# php artisan db:seed
```

### 5) Run Dev Servers
```bash
# Vite (assets)
npm run dev

# Laravel
php artisan serve
# visit http://127.0.0.1:8000
```

> Building once without watch: `npm run build`

---

## 🔑 Authentication Flow (controllers overview)

- **RegisteredUserController**
  - `create()` → `view('auth.register')`
  - `store()` → validates & creates user → `redirect()->route('login')` with flash (no auto-login)

- **AuthenticatedSessionController**
  - `create()` → `view('auth.login')`
  - `store()` → `Auth::attempt(...)` + session regenerate → `redirect()->route('tasks.index')`
  - `destroy()` → logout + session invalidate → `redirect()->route('login')`

---

## ✅ Tasks Module

- **Index**: paginated list + status badges + stats  
  `resources/views/tasks/index.blade.php` (not included here; keep yours)
- **Create**: colorful glass card + gradient border  
  `resources/views/tasks/create.blade.php`
- **Edit / Show**: same theme, status chips, meta info  
  `resources/views/tasks/edit.blade.php`, `resources/views/tasks/show.blade.php`

**Status values:** `pending`, `done`.

---

## 🛣️ Routes (typical)

```php
// routes/web.php (sketch)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::resource('tasks', TaskController::class);
    Route::get('/', fn() => redirect()->route('tasks.index'))->name('home');
});
```

---

## 🎨 UI Screenshots (add later)

Create a folder and add screenshots:

```
public/screenshots/tasks-index.png
public/screenshots/task-create.png
```

Reference them here:

```md
![Tasks Index](public/screenshots/tasks-index.png)
![Create Task](public/screenshots/task-create.png)
```

---

## 🔧 Handy Artisan Commands

```bash
# clear caches
php artisan optimize:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# db reset
php artisan migrate:fresh --seed

# scaffolding example
php artisan make:model Task -mcr
```

---

## 🩹 Troubleshooting

**Blade parse error: _“unexpected end of file, expecting elseif/else/endif”_**
- Ensure every `@if/@foreach/@section` has matching `@endif/@endforeach/@endsection`.
- Don’t paste stack traces or stray quotes into Blade files.

**SQLite on Windows: _Cannot find path ... \NUL_**
- Run `type NUL > database/database.sqlite` **inside the project folder** and ensure the `database` directory exists.

**Vite / Dev Server: _Invalid options allowedHosts_ or HOST binding**
- Clear `HOST` / `WDS_ALLOWED_HOSTS` env vars in your shell and re-run `npm run dev`.

**419 / CSRF mismatch**
- Make sure `@csrf` is present in all forms and you’re using the same domain/port.

---

## 🔐 Security

- Password hashing via `Hash::make` (Laravel defaults).
- CSRF protection enabled.
- Session regenerate on login; invalidate on logout.

---

## 📦 Deployment

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
- Point web server root to `/public`
- Set proper `.env` for production (DB credentials, `APP_KEY`, etc.)

---

## 🤝 Contributing

PRs are welcome! Please open an issue first to discuss substantial changes.

---

## 📄 License

MIT © 2025 Your Name / Your Company
