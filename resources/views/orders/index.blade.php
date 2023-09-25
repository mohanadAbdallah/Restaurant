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
                <h6 class="m-0 font-weight-bold text-primary">الطلبات</h6>
            </div>



            <div class="card-body">
                <form  action="{{route('orders.index')}}" method="get">

                    <label>
                        <select name="orders" class="form-control">
                            <option value="3" {{request()->orders == 3 ? 'selected' : ''}}>كل الطلبات</option>
                            <option value="1" {{request()->orders == 1 ? 'selected' : ''}}>الطلبات المكتملة</option>
                            <option value="2" {{request()->orders == 2 ? 'selected' : ''}}>الطلبات المعلقة</option>
                            <option value="0" {{request()->orders == 0 ? 'selected' : ''}}>الطلبات الملغية</option>
                        </select>
                    </label>
                    <button type="submit" class="btn btn-success">Filter</button>
                </form>
                <div class="table-responsive" dir="rtl">
                    <table class="table table-bordered text-right" id="dataTable">
                        {{--                        @can('view_order')--}}
                        <thead>

                        <tr>
                            <th># رقم الطلب</th>
                            <th>إسم المستخدم</th>
                            <th>حالة الطلب</th>
                            <th>الإجمالي</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($orders))
                            <?php $_SESSION['i'] = 0 ?>
                            @foreach($orders as $order)

                                    <tr>
                                        <td>
                                            <a href="{{route('orders.show',$order->id)}}"
                                                style="text-decoration: none;color: #858796;margin: 0px 12px 0px 0px;">
                                                #{{$order->number ?? '--'}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$order->user->name ?? ''}}
                                        </td>
                                        <td>
                                            <span class="{{$order->status_badge ?? ''}}">{{$order->order_status ?? ''}}</span>
                                        </td>

                                        <td>
                                            ₪{{$order->total ?? ''}}
                                        </td>

                                        <td>{{$order->created_at->diffForHumans() ?? ''}}</td>

                                        <td>
                                            <div class="form-group">
                                                @can('view_item')
                                                    <a href="{{route('orders.show',$order->id)}}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fa fa-atom"></i>
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
                        @endif
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


