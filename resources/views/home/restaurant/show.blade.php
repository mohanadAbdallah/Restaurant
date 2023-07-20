<!DOCTYPE html>
<html lang="ar" dir="rtl">

@include('home.partials.head')

<body>

@include('home.partials.navbar')

<!-- Testmonial Section -->
<section id="testmonial" class="pattern-style-3">
    <div class="container">
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
</section>
<!-- End of Testmonial Section -->

</body>

</html>

