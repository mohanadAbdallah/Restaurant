<!-- First Navigation -->
<nav class="navbar nav-first navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('assets/imgs/navbar-brand.svg')}}" alt="Download free bootstrap 4 landing page, free boootstrap 4 templates, Download free bootstrap 4.1 landing page, free boootstrap 4.1.1 templates, Pigga Landing page">
        </a>

    </div>
</nav>
<!-- End of First Navigation -->

<!-- Second Navigation -->
<nav class="nav-second navbar custom-navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
    <div class="container">
        <div class="col-3">
          @if($doesntHaveRoles)
            <div class="dropdown" >
                <a class="btn btn-outline-dark" style="font-size: 20px;" href="{{route('cart.view')}}">
                    <i class="fa fa-shopping-cart" ></i>
                    Cart <span class="badge badge-danger">{{ count((array) session('cart')) }}</span>
                </a>
            </div>
            @endif
        </div>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                @if(auth()->user())
                    <li class="nav-item">

                        <a class = "nav-link" href="#" data-toggle="modal" data-target="#logoutModal">Logout
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        </a>

                    </li>
                @endif

                @hasanyrole('Admin|Super Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                @endrole


             @if(!auth()->user())
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.login')}}">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('auth.register')}}">Register</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about')}}">About Us </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('contact')}}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Of Second Navigation -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-right">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تأكيد المغادرة ؟</h5>
                <button class="close" style="margin: 0px 0px 0px 0px" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">هل تريد تأكيد تسجيل الخروج ؟ </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">إغلاق</button>
                <form method="post" action="{{route('user.logout')}}">
                    @csrf
                    <button type="submit" class="btn btn-primary mr-2">تأكيد</button>
                </form>

            </div>
        </div>
    </div>
</div>


