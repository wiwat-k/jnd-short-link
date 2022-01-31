<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="text-bold text-primary">{{ Auth::user()->name }}</span>
        <a href="{{ url('/auth/logout') }}" class="btn btn-secondary ml-auto">ออกจากระบบ</a>
    </div>
</div>
