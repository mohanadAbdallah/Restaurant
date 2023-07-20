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
                <h6 class="m-0 font-weight-bold text-primary">المستخدمين</h6>
                @can('add_user')
                    <a href="{{route('users.create')}}" class="btn btn-primary">Add User</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center mb-6" id="dataTable"
                           style="margin-bottom: 30px !important;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الإسم </th>
                            <th>الإيميل</th>
                            <th>رقم الجوال</th>
                            <th>العنوان</th>
                            <th>الصلاحية</th>
                            <th>الصورة</th>
                            <th>الإجراء</th>

                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($users))
                            <?php $_SESSION['i'] = 0; ?>
                            @foreach($users as $user)
                                <?php $_SESSION['i'] = $_SESSION['i'] + 1; ?>
                                <tr>
                                    <td>{{$_SESSION['i']}}</td>

                                    <td>
                                        <a href="{{route('users.show',$user->id)}}"
                                           style="text-decoration: none">{{$user->name ?? ''}}</a></td>
                                    <td>{{$user->email ?? ''}}</td>
                                    <td>{{$user->phone ?? ''}}</td>
                                    <td>{{$user->address ?? ''}}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $role)
                                                <label class="badge badge-primary">{{ $role }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{url("storage/images/".$user->image)}}" style="border-radius: 10px;"
                                             width="50px;">
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            @can('edit_user')
                                                <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete_user')
                                                <a href="javascript:void(0)"
                                                   onclick="delete_item({{$user->id}})"
                                                   data-toggle="modal" data-target="#delete_modal"
                                                   class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
                    <input name="id" id="user_id" class="form-control" type="hidden">
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
    </style>
    <script>
        function delete_item(id) {
            $('#user_id').val(id);
            var url = "{{url('dashboard/users')}}/" + id;
            $('#delete_form').attr('action', url);
        }
    </script>
    <!-- /.container-fluid -->
@endsection
