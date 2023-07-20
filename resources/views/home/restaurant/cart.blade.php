<!DOCTYPE html>
<html lang="ar" dir="rtl">
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('home.partials.head')

<body>

@include('home.partials.navbar')
<!-- Service Section -->


<table id="cart" class="table table-bordered text-right">
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <thead>
    <tr>
        <th>العناصر</th>
        <th>السعر</th>
        <th>الكمية</th>
        <th>المجموع</th>
        <th></th>
    </tr>
    </thead>

    <tbody>



@php $total = 0 @endphp
@if(session('cart'))
    @foreach(session('cart') as $id => $details)

        <tr data-id ="{{ $id }}">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Price">₪ {{ $details['price'] }}</td>
            <td data-th="Quantity">
                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
            </td>

            <td data-th="Subtotal" class="text-center">₪ {{ $details['price'] * $details['quantity'] }}</td>

            <td class="actions">
                <a class="btn btn-danger btn-sm delete-product">
                    <i class="fa fa-trash"></i></a>
            </td>
        </tr>
    @endforeach

@else
    <p>Your cart is empty.</p>
@endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5" class="text-left">
            <form action="{{route('orders.store')}}" method="post">
                @csrf
                <button class="btn btn-danger">تأكيد الطلب</button>
                <a href="{{ route('home') }}" class="btn btn-primary"><i class="fa fa-angle-left"></i> إكمال التسوق</a>
            </form>

        </td>
    </tr>
    </tfoot>
</table>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<script type="text/javascript">

    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
                console.log(response)
                window.location.reload();
            }
        });
    });

    $(".delete-product").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('delete.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });


</script>
