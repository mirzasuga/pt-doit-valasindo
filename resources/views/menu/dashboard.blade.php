<nav class="navbar navbar-default" style="z-index:99999999;">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Dashboard</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!-- <li class="active">
                    <a href="{{ route('dashboard') }}">Dashboard <span class="sr-only">(current)</span></a>
                </li> -->
                <li><a id="nav_valas" href="{{ route('valas_index') }}">Valas</a></li>
                <li><a id="nav_mitra" href="{{ route('mitra_index') }}">Mitra</a></li>
                <li><a id="nav_mitra" href="{{ route('penukaran_index') }}">Penukaran</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PPSV <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('ppsv_index') }}">Entry PPSV</a></li>
                        <li><a href="{{ route('ppsv_approvals') }}">Approval PPSV</a></li>
                        <li><a href="{{ route('ppsv_status_view') }}">Status PPSV</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">BBSV <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('bbsv_entry') }}">Entry BBSV</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">BTUPSV<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('btupsv_index') }}">Entry BTUPSV</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kurs <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Info Kurs</a></li>
                        <li><a href="#">Booking Kurs</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a id="entry-valas" href="#entry-valas">Entry Valas</a></li>
                    </ul>
                </li>
                <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->nama_user }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                </ul>
                <li><a href="#">Register</a></li>
                <li><a href="#">Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>