<!DOCTYPE html>
<html lang="ar" dir="rtl">

@include('home.partials.head')

<body>

@include('home.partials.navbar')

<!-- Page Header -->
<header class="header">
    <div class="overlay">
        <img src="{{asset('assets/imgs/logo.svg')}}"
             alt="Download free bootstrap 4 landing page, free boootstrap 4 templates, Download free bootstrap 4.1 landing page, free boootstrap 4.1.1 templates, Pigga Landing page"
             class="logo">
        <h1 class="subtitle">Welcome To Our Restaurant</h1>
        <h1 class="title">Really Fresh &amp; Tasty</h1>
    </div>
</header>
<!-- End Of Page Header -->

<!-- Team Section -->
<section id="team">
    <div class="container">
        <h3 class="section-title mb-5 text-center">Our Restaurants</h3>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            @foreach($restaurants as $restaurant)
                <a href="{{route('home.restaurant.show',$restaurant->id)}}">
                    <div class="col-md-4 my-3">
                        <div class="team-wrapper text-center">
                            <img src="{{url('storage/images/'.$restaurant->image)}}"
                                 class="circle-120 rounded-circle mb-3 shadow"
                                 alt="Download free bootstrap 4 landing page, free boootstrap 4 templates, Download free bootstrap 4.1 landing page, free boootstrap 4.1.1 templates, Pigga Landing page">
                            <h5 class="my-3">{{$restaurant->name}}</h5>
                            <p>{{$restaurant->description}}</p>
                            <h6 class="socials mt-3">
                                <a href="javascript:void(0)" class="px-2"><i class="ti-facebook"></i></a>
                                <a href="javascript:void(0)" class="px-2"><i class="ti-twitter"></i></a>
                                <a href="javascript:void(0)" class="px-2"><i class="ti-instagram"></i></a>
                                <a href="javascript:void(0)" class="px-2"><i class="ti-google"></i></a>
                            </h6>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
    <!-- End of Team Section -->
<script>
    const userId = "{{auth()->id()}}"
</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Prefooter Section  -->
<div class="py-4 border border-lighter border-bottom-0 border-left-0 border-right-0 bg-dark">
    <div class="container">
        <div class="row justify-content-between align-items-center text-center">
            <div class="col-md-3 text-md-left mb-3 mb-md-0">
                <img src="{{asset('assets/imgs/navbar-brand.svg')}}" width="100"
                     alt="Download free bootstrap 4 landing page, free boootstrap 4 templates, Download free bootstrap 4.1 landing page, free boootstrap 4.1.1 templates, Pigga Landing page"
                     class="mb-0">
            </div>
            <div class="col-md-9 text-md-right">
                <a href="#" class="px-3"><small class="font-weight-bold">Our Company</small></a>
                <a href="#" class="px-3"><small class="font-weight-bold">Our Location</small></a>
                <a href="#" class="px-3"><small class="font-weight-bold">Help Center</small></a>
                <a href="components.html" class="pl-3"><small class="font-weight-bold">Components</small></a>
            </div>
        </div>
    </div>
</div>
<!-- End of PreFooter Section -->

<!-- Page Footer -->
<footer class="border border-dark border-left-0 border-right-0 border-bottom-0 p-4 bg-dark">
    <div class="container">
        <div class="row align-items-center text-center text-md-left">
            <div class="col">
                <p class="mb-0 small">&copy;
                    <script>document.write(new Date().getFullYear())</script>
                    , <a href="https://www.devcrud.com" target="_blank">DevCrud</a> All rights reserved
                </p>
            </div>
            <div class="d-none d-md-block">
                <h6 class="small mb-0">
                    <a href="javascript:void(0)" class="px-2"><i class="ti-facebook"></i></a>
                    <a href="javascript:void(0)" class="px-2"><i class="ti-twitter"></i></a>
                    <a href="javascript:void(0)" class="px-2"><i class="ti-instagram"></i></a>
                    <a href="javascript:void(0)" class="px-2"><i class="ti-google"></i></a>
                </h6>
            </div>
        </div>
    </div>

</footer>
<!-- End of Page Footer -->

<!-- core  -->
<script src="{{asset('assets/vendors/jquery/jquery-3.4.1.js')}}"></script>
<script src="{{asset('assets/vendors/bootstrap/bootstrap.bundle.js')}}"></script>
<!-- bootstrap affix -->
<script src="{{asset('assets/vendors/bootstrap/bootstrap.affix.j')}}s"></script>
<!-- Pigga js -->
<script src="{{asset('assets/js/pigga.js')}}"></script>

</body>
</html>
