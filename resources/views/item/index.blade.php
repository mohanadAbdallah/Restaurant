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
                <h6 class="m-0 font-weight-bold text-primary">العناصر</h6>
                @can('add_item')
                    <a href="{{route('items.create')}}" class="btn btn-primary">إضافة عنصر</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive" dir="rtl">
                    <table class="table table-bordered text-right" id="dataTable">
                        @can('view_item')
                            <thead>

                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>السعر</th>
                                <th>الوصف</th>
                                <th>القسم</th>
                                <th>الصورة</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($items))
                                <?php $_SESSION['i'] = 0 ?>
                                @foreach($items as $item)
                                    <?php $_SESSION['i'] = $_SESSION['i'] + 1 ?>
                                    <tr>
                                        <td>{{$_SESSION['i']}}</td>
                                        <td>{{$item->name ?? ''}}</td>
                                        <td>{{$item->price ?? ''}}</td>
                                        <td>{{$item->description ?? ''}}</td>
                                        <td>

                                            @foreach($item->categories as $category)
                                                <label class="badge badge-success" style="border-radius: 0px;">
                                                    {{$category->title ?? ''}}
                                                </label>
                                            @endforeach
                                           </td>


                                        <td>
                                            <img src="{{url("storage/images/".$item->image ?? '')}}" width="50px">
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                @can('edit_item')
                                                    <a href="{{route('items.edit',$item->id)}}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete_item')
                                                    <a href="javascript:void(0)"
                                                       onclick="delete_item({{$item->id}})"
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
            var url = "{{url('dashboard/items')}}/" + id;
            $('#delete_form').attr('action', url);
        }
    </script>
    <!-- /.container-fluid -->
@endsection

