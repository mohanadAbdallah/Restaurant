@extends('layouts.master')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid" dir="rtl">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">الأقسام</h6>
            </div>
            <div class="card-body">
                <div class="tab-content text-right my-3" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="n" role="tabpanel" aria-labelledby="nav-emp1-tab">
                        <div class="table-responsive">

                            <table class="table table-bordered text-center" id="dataTable">
                                <thead>
                                <a href="{{route('categories.create')}}" class="btn btn-primary mb-4 "
                                   style="margin: 0px 868px 0px 0px;">إضافة قسم</a>
                                <tr>
                                    <th>#</th>
                                    <th>الأقسام</th>
                                    <th>slug</th>
                                    <th>القسم الأب</th>

                                    <th>الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($categories)
                                    <?php $_SESSION['i'] = 0 ?>
                                    @foreach($categories as $category)
                                        <?php $_SESSION['i'] = $_SESSION['i'] + 1 ?>
                                        <tr>
                                            <td>{{$_SESSION['i']}}</td>
                                            <td>
                                                <a href="{{route('categories.show',$category->id)}}"
                                                   style="text-decoration: none;color: inherit">{{$category->title ?? ''}}</a>
                                            </td>
                                            <td>
                                                {{$category->slug}}
                                            </td>
                                            <td>{{$category->parent->title ?? '--'}}</td>

                                            <div class="form-group" style="font-size: 5px;">
                                                <td>
                                                    <a href="{{route('categories.edit',$category->id)}}"
                                                       class="btn btn-primary btn-sm"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)"
                                                       onclick="delete_item({{$category->id}})"
                                                       data-toggle="modal" data-target="#delete_modal"
                                                       class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                </td>
                                            </div>

                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete_form" method="post" action="">
                    @csrf
                    @method('Delete')
                    <input name="id" id="category_id" class="form-control" type="hidden">
                    <input name="_method" type="hidden" value="DELETE">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Deletion.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Confirm delete user.</p>
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

        div#nav-tab {
            gap: 10px;
            flex-direction: row;
        }
    </style>
    <script>
        function delete_item(id) {
            $('#category_id').val(id);
            var url = "{{url('dashboard/categories')}}/" + id;
            $('#delete_form').attr('action', url);
        }
    </script>
    <!-- /.container-fluid -->
@endsection
