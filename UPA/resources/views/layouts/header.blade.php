<nav class="navbar bg-white px-4 shadow-sm">
    <div class="container-fluid justify-content-between">

        <div class="d-flex align-items-center gap-3 ms-auto">
            {{-- Tombol Notifikasi --}}
            @auth
            <div class="dropdown">
                <button class="btn btn-outline-secondary position-relative dropdown-toggle" type="button"
                    id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdown" style="min-width: 250px;">
                    @forelse($latestAnnouncements as $announcement)
                        <li>
                            <a class="dropdown-item small" href="{{ route('announcement.show', $announcement->id) }}">
                                📢 <strong>{{ $announcement->title }}</strong><br>
                                <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                        @if (!$loop->last)
                            <li><hr class="dropdown-divider"></li>
                        @endif
                    @empty
                        <li><span class="dropdown-item text-muted">No announcements</span></li>
                    @endforelse
                </ul>
            </div>
            @endauth

            {{-- Profil Pengguna --}}
            <div class="d-flex align-items-center">
                @if (auth()->check())
                    <img src="{{ Storage::url(auth()->user()->photo_path ?? 'public/default-avatar.jpg') }}"
                        class="rounded-circle me-2" alt="foto" width="30" height="30">
                    <span>Hi, {{ auth()->user()->name }}</span>
                @else
                    <img src="https://via.placeholder.com/30" class="rounded-circle me-2" alt="foto" width="30" height="30">
                    <span>Hi, Guest</span>
                @endif
            </div>
        </div>
    </div>
</nav>
