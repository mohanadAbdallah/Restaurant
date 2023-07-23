@extends('layouts.master')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
    @endif

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">#{{$order->number}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" dir="rtl">
                    <table class="table table-bordered text-right" id="dataTable">
                            <thead>

                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>الإجمالي</th>
                                <th>الصورة</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>

                            <tbody>
                                <?php $_SESSION['i'] = 0 ?>
                              @foreach($order->items as $item)
                                    <?php $_SESSION['i'] = $_SESSION['i'] + 1 ?>
                                    <tr>

                                        <td>{{$_SESSION['i']}}</td>
                                        <td>{{$item->name ?? ''}}</td>
                                        <td>{{$item->price ?? ''}}₪</td>
                                        <td>{{$item->pivot->quantity ?? ''}}</td>

                                        <td>{{$item->price * $item->pivot->quantity ?? ''}}₪</td>


                                        <td>
                                            <img src="{{url("storage/images/".$item->image ?? '')}}" width="50px">
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                @can('edit_item')
                                                    <a href="{{route('orders.edit',$order->id)}}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete_item')
                                                    <a href="javascript:void(0)"
                                                       onclick="delete_item({{$order->id}})"
                                                       data-toggle="modal" data-target="#delete_modal"
                                                       class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
{{--                        @endcan--}}
                    </table>
                </div>
            </div>
        </div>

    </div>
    {{--    Delete Modal--}}
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete_form" method="post" action="">
                    @csrf
                    @method('Delete')
                    <input name="id" id="item_id" class="form-control" type="hidden">
                    <input name="_method" type="hidden" value="DELETE">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Deletion.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Confirm delete restaurant.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        div.dataTables_wrapper div.dataTables_filter input {
            margin-left: -30rem;
            display: inline-block;
            width: auto;
        }

        div.dataTables_wrapper div.dataTables_length label {
            font-weight: normal;
            text-align: left;
            margin-left: 36rem;
            margin-top: 0.6rem;
            white-space: nowrap;
        }

        div.dataTables_wrapper div.dataTables_info {
            padding-top: 0.85em;
            margin: 0px 0px 0px 201px;
        }
    </style>
    <script>
        function delete_item(id) {
            $('#item_id').val(id);
            var url = "{{url('dashboard/orders')}}/" + id;
            $('#delete_form').attr('action', url);
        }
    </script>
    <!-- /.container-fluid -->
@endsection


