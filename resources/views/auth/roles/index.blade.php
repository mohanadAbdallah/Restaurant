@extends('layouts.master')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid" dir="rtl">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
    @endif
    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">الصلاحيات</h6>
                <a href="{{route('roles.create')}}" class="btn btn-primary">Add Role</a>
            </div>
            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table table-bordered text-center" id="dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الإسم</th>
                            <th>الإجراءات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id ?? ''}}</td>
                                <td>
                                    <span class="badge badge-success">
                                    {{$role->name ?? ''}}
                                    </span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="delete_item({{$role->id}})"
                                       data-toggle="modal"
                                       data-target="#delete_modal"
                                       class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="{{route('roles.edit',$role->id)}}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
                    <input name="id" id="role_id" class="form-control" type="hidden">
                    <input name="_method" type="hidden" value="DELETE">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Deletion.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Confirm delete Role.</p>
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
            $('#role_id').val(id);
            var url = "{{url('roles')}}/" + id;
            $('#delete_form').attr('action', url);
        }
    </script>
    <!-- /.container-fluid -->
@endsection
