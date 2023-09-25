
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('home.partials.head')

<body>

@include('home.partials.navbar')
<!-- Service Section -->
<section id="service" class="pattern-style-4 has-overlay">
    <div class="container raise-2">
        <h3 class="section-title mb-6 pb-3 text-center">Our Food Orders</h3>
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-6 mb-5" style="margin-bottom: 100px;">
                    <a href="#" class="custom-list">
                        <div class="img-holder">
                            <img src="{{url('storage/images/'.$item->image)}}" alt="{{$item->name}}">
                        </div>
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
                    <button class="btn btn-success add-to-cart" data-item-id="{{ $item->id }}">Add to Cart</button>

                </div>
            @endforeach
        </div>
    </div>
</section>


<div class="modal show_login_modal text-right" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تسجيل دخول</h5>
                <button type="button" class="btn-close" data-dismiss="modal"  aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <p>يجب عليك تسجيل الدخول, توجه لصفحة تسجيل الدخول.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{route('user.login')}}"  class="btn btn-success mr-2">Login</a>
            </div>
        </div>
    </div>
</div>
<!-- End of Featured Food Section -->

</body>
<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    $(document).ready(function() {
        $('.add-to-cart').on('click', function() {
            const ItemId = $(this).data('item-id');
            $.ajax({
                type: 'POST',
                url: '{{ route('cart.add') }}',
                data: {
                    Item_Id: ItemId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log(response)
                    if (response.login_required) {
                        window.location.href = '{{ route('user.login') }}';
                    } else {
                        alert(response.message);
                        window.location.reload();
                    }

                },
                error: function(error) {
                    if(error.status == 401) {

                        Swal.fire({
                            title: 'أنت غير مسجل دخول في الموقع ؟',
                            showCancelButton: true,
                            confirmButtonText: 'تسجيل دخول',
                            cancelButtonText: `إغلاق`,
                        }).then((result) => {

                            if (result.isConfirmed) {
                                window.location.href = '{{ route('user.login') }}';
                            } else if (result.isCanceled) {
                                Swal.fire('Changes are not saved', '', 'info')
                            }
                        })
                    }
                }
            });
        });
    });
</script>


</html>
