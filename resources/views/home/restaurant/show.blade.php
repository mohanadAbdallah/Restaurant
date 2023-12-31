<!DOCTYPE html>
<html lang="ar" dir="rtl">

<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>



@include('home.partials.head')

<body>

@include('home.partials.navbar')


<!-- Testmonial Section -->
<section id="testmonial" class="pattern-style-3">
    <div class="container">
        {{--Chat--}}
        <div class="floating-chat">
            <a href="{{route('chat.index',request('restaurant'))}}" class="btn btn-primary">
                Online Chat
                <i class="fa fa-comments"></i>
            </a>
            <div class="chat">

            </div>
        </div>
        <h3 class="section-title mb-5 text-center">Categories</h3>

        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 my-3 my-md-0">
                <a href="{{route('home.category.show',$category->id)}}">

                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center mb-3">
                            <img class="mr-3" src="{{url('storage/images/'.$category->image)}}" alt="Download free bootstrap 4 landing page, free boootstrap 4 templates, Download free bootstrap 4.1 landing page, free boootstrap 4.1.1 templates, Pigga Landing page">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0">{{$category->title}}</h6>
                            </div>
                        </div>
                        <p class="mb-0">{{$category->description ?? ''}}</p>
                    </div>
                </div>
                </a>

            </div>
                @endforeach
        </div>
    </div>



    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    {{--Chat--}}

</section>

<!-- End of Testmonial Section -->


</body>

</html>

