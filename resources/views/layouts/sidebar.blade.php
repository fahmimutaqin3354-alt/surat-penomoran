<div class="bg-dark text-white position-fixed vh-100 shadow"
     style="width:260px;top:56px;left:0;">

    <div class="p-4">

      <div class="text-center mb-4">

    <img
        src="{{ asset('image/logo.jpg') }}"
        alt="Logo PT Microdata Indonesia"
        class="img-fluid mb-3"
        style="max-width:170px;">

    <small class="text-light d-block">

        Sistem Arsip Surat

    </small>

</div>

<hr class="text-secondary">

        <ul class="nav flex-column">

            <li class="nav-item mb-2">

                <a href="{{ route('dashboard') }}"
                   class="nav-link text-white">

                    <i class="bi bi-speedometer2"></i>

                    Dashboard

                </a>

            </li>

            <li class="nav-item mb-2">

                <a href="{{ route('surat_masuk.index') }}"
class="nav-link text-white">

<i class="bi bi-envelope-arrow-down"></i>

Surat Masuk

</a>

            </li>

            <li class="nav-item mb-2">

    <a href="{{ route('surat_keluar.index') }}"
       class="nav-link text-white">

        <i class="bi bi-envelope-arrow-up"></i>

        Surat Keluar

    </a>

</li>

            <li class="nav-item mb-2">

                <a href="#"
                   class="nav-link text-white">

                    <i class="bi bi-folder"></i>

                    Arsip Surat

                </a>

            </li>

            <li class="nav-item mb-2">

                <a href="#"
                   class="nav-link text-white">

                    <i class="bi bi-people"></i>

                    Kelola User

                </a>

            </li>

            <li class="nav-item mb-2">

                <a href="#"
                   class="nav-link text-white">

                    <i class="bi bi-bar-chart"></i>

                    Laporan

                </a>

            </li>

        </ul>

    </div>

</div>
