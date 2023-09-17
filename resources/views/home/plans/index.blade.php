
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('home.partials.head')

<body>

@include('home.partials.navbar')
<!-- Service Section -->
<section id="service" class="pattern-style-4 has-overlay">
    <div class="container raise-2">
        <h3 class="section-title mb-6 pb-3 text-center">Our Plans</h3>
        <div class="row">
            @foreach($plans as $item)
                <div class="col-md-6 mb-4">
                    <a href="#" class="custom-list">

                        <div class="info">
                            <div class="head clearfix">
                                <h5 class="title float-left">{{$item->name}}</h5>

                            </div>
                            <div class="body">
                                <p>{{$item->description}}</p>
                                <p class="float-right"> ₪ Price {{$item->price}}</p>
                            </div>
                        </div>

                    </a>
                    <a href="{{route('plans.show',$item->slug)}}" class="btn btn-success">Buy Now</a>

                </div>
            @endforeach
        </div>
    </div>
</section>

</body>


</html>
