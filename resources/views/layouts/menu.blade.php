<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            <img src="./assets/img/bridgestone_outline.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">BSKP-Penggajian</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/employee') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">groups</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Karyawan</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Gaji
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/salarygrade') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">price_change</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Gaji - Per Grade</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/salaryannual') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">payments</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Gaji - Per Tahun</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/salarymonthly') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">payments</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Gaji - Per Bulan</span>
                </a>
            </li>

            {{-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Gaji Reguler
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/salaryregular') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">payments</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Gaji Reguler</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="./virtual-reality.html">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Slip Gaji</span>
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/salary') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Seluruh Data Gaji</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-danger" href="./sign-in.html">

                    <div class="text-danger text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>

                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn btn-danger mt-4 w-100" href="" type="button">Logout</a>
        </div>
    </div> --}}
</aside>
