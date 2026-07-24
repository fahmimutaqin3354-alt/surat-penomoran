<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">

    <div class="container-fluid">

        <span class="navbar-brand fw-bold">

            <i class="bi bi-folder2-open"></i>

            Sistem Arsip Surat

        </span>

        <ul class="navbar-nav ms-auto">

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle text-white"
                   href="#"
                   data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle"></i>

                    {{ Auth::user()->name }}

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <a class="dropdown-item" href="{{ route('profile.edit') }}">

                            <i class="bi bi-person"></i>

                            Profil

                        </a>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button class="dropdown-item">

                                <i class="bi bi-box-arrow-right"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>
