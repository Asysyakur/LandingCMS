<style>
    .navbar-custom {
        background-color: white;
        height: 70px;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between; /* Memisahkan sisi kiri dan kanan */
        border-bottom: 1px solid #f0f0f0;
    }

    .user-profile-wrapper {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .user-profile-wrapper img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f8f9fa;
    }

    .status-indicator {
        font-size: 0.75rem;
        color: #28a745;
        font-weight: 500;
    }

    .status-dot {
        font-size: 0.5rem;
        vertical-align: middle;
        margin-right: 2px;
    }

    /* Menghilangkan panah default bootstrap jika diinginkan */
    .dropdown-toggle::after {
        display: none;
    }
</style>

<nav class="navbar-custom shadow-none">
    <div class="d-lg-none">
        <button class="btn toggler-btn p-0 border-0">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <div class="d-none d-lg-block"></div>

    <div class="dropdown">
        <a href="#" class="user-profile-wrapper dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="text-end me-3 d-none d-sm-block">
                <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">Martin</p>
                <p class="mb-0 status-indicator">
                    <i class="bi bi-circle-fill status-dot"></i> Online
                </p>
            </div>
            
            <img src="https://ui-avatars.com/api/?name=Martin&background=random" alt="user-photo">
            
            <i class="bi bi-chevron-down ms-2 small text-secondary"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> My Profile</a></li>
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger">
                        <i class="bi bi-box-arrow-left me-2"></i> Log Out
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>