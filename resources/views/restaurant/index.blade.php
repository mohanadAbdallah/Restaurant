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
                <h6 class="m-0 font-weight-bold text-primary">المطاعم</h6>
                @can('add_restaurant')
                    <a href="{{route('restaurant.create')}}" class="btn btn-primary">إضافة مطعم</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive" dir="rtl">
                    <table class="table table-bordered text-right" id="dataTable">
                        @can('view_restaurant')
                            <thead>

                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>رقم الجوال</th>
                                <th>العنوان</th>
                                <th>المسؤول</th>
                                <th>الشعار</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($restaurants))
                                <?php $_SESSION['i'] = 0 ?>
                                @foreach($restaurants as $restaurant)
                                    <?php $_SESSION['i'] = $_SESSION['i'] + 1 ?>
                                    <tr>
                                        <td>{{$_SESSION['i']}}</td>
                                        <td>{{$restaurant->name ?? ''}}</td>
                                        <td>{{$restaurant->phone ?? ''}}</td>
                                        <td>{{$restaurant->address ?? ''}}</td>
                                        <td>{{$restaurant->user->name ?? ''}}</td>
                                        <td>
                                            <img src="{{url("storage/images/".$restaurant->image ?? '')}}" width="50px">
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                @can('edit_restaurant')
                                                    <a href="{{route('restaurant.edit',$restaurant->id)}}"
                                                       class="btn btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete_restaurant')
                                                    <a href="javascript:void(0)"
                                                       onclick="delete_item({{$restaurant->id}})"
                                                       data-toggle="modal" data-target="#delete_modal"
                                                       class="btn btn-danger"><i class="fa fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        @endcan
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
                    <input name="id" id="restaurant_id" class="form-control" type="hidden">
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
            $('#restaurant_id').val(id);
            var url = "{{url('restaurant')}}/" + id;
            $('#delete_form').attr('action', url);
        }
    </script>
    <!-- /.container-fluid -->
@endsection

