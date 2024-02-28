<div class="headerContent">
    <div class="col-md-10 mx-auto">
        <div class="text-center">
            <img src="{{ asset('/images/header.png') }}" width="100%" height="120px"/>
        </div>
        <nav class="navbar navbar-expand-lg topnav bg-gradient">
            <div class="container-fluid px-0">
                <b class="navbar-brand ps-3" href="/home">
                    SPEC G    
                </b>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <!--<span class="navbar-toggler-icon text-light" style="color: white"></span>-->
                    <i class="bi-three-dots" style="color: white"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link btnNav px-3" id="nav-home" href="/home">Home (Projects)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btnNav px-3" id="nav-client" href="/client-list">Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btnNav px-3" id="nav-task" href="/task-list">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btnNav px-3" id="nav-file" href="/file-list">Files</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btnNav px-3" id="nav-about" href="/about-us">About Us</a>
                        </li>
                        @if (session('role') == 'admin')
                            <li class="nav-item">
                                <a class="nav-link btnNav px-3" id="nav-admin" href="/admin">
                                    <i class="bi-person-circle"></i>
                                    Admin
                                </a>
                            </li>
                        @endif
                    </ul>
                    <form action="/search" method="post" class="d-flex">
                        @csrf
                        <input class="form-control form-control-sm" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-sm btn-outline-light" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="/logout" id="nav-logout" class="nav-link px-3">
                                Log Out   
                                <i class="bi-power"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
