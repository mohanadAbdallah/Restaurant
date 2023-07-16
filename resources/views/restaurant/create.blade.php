@extends('layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid" dir="rtl">
        <div class="row">
            <div class="col-md-8">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <form dir="rtl" class="card p-1 p-sm-5 setting-form text-right mb-5" enctype="multipart/form-data"
                      action="{{route('restaurant.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="f-name" class="form-label">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-sm-6">
                            <label for="l-name" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <img src="#" alt="Uploaded Image" id="previewImage"
                                 style="display: none;max-width: 75px;max-height: 75px;border-radius: 5px;margin: 18px 150px -37px 0;">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="f-name" class="form-label">رقم الجوال</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <img src="#" alt="Uploaded Image" id="previewImage" style="display: none;width: 40px;">
                            <label for="formFile" class="form-label">شعار المطعم</label>
                            <input class="form-control" name="image" style="padding: 9px 22px 0px 1px;height: 48px;"
                                   type="file" id="imageInput">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label class="form-label">المستخدم</label>
                            {{--                            <button class="btn btn-primary" data-toggle="">--}}
                            {{--                                add user--}}
                            {{--                            </button>--}}
                            <select class="form-control" name="user_id" id="userSelect">
                                <option disabled selected>إختر المستخدم</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 mb-sm-0" style="margin: 32px -9px 63px -44px;">
                            @can('add_user')

                                <a href="javascript:void(0)" data-toggle="modal" data-target="#store_modal"
                                   class="btn btn-primary">
                                    <i class="fa fa-user"></i>
                                    create user </a>
                            @endcan
                        </div>

                    </div>
                    <div class="text-left mt-5">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="#" type="button" style="text-decoration: none;color: white" class="btn btn-danger">الخلف</a>
                    </div>

                </form>
            </div>

        </div>

        <hr>

    </div>
    <div class="modal fade" id="store_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" dir="rtl">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="store_form" method="post" action="{{route('users.store')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">إضافة مستخدم.</h5>
                        <button type="button" style="margin: 0px 0px 0px 0px" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>

                    <div class="modal-body text-right">

                        <div class="form-group row">
                            <div class="col-sm-6 ">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="col-sm-6">
                                <label for="address" class="form-label">العنوان</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-6">
                                <img src="#" alt="Uploaded Image" id="previewImage"
                                     style="display: none;max-width: 75px;max-height: 75px;border-radius: 5px;margin: 18px 150px -37px 0;">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm-6 ">
                                <label for="f-name" class="form-label">رقم الجوال</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-sm-6 ">
                                <img src="#" alt="Uploaded Image" id="previewImage" style="display: none;width: 40px;">
                                <label for="formFile" class="form-label">إختر صورة</label>
                                <input class="form-control" name="image" style="padding: 9px 22px 0px 1px;height: 48px;"
                                       type="file" id="imageInput">
                            </div>
                        </div>

                        <div class="form-group row ">
                            <div class="col-sm-6 ">
                                <label for="email" class="form-label">الإيميل</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>

                            <div class="col-sm-6 ">

                            </div>

                        </div>
                        <div class="form-group row mb-5">
                            <div class="col-sm-6 ">
                                <label for="password" class="form-label">كلمةالمرور</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="col-sm-6 ">
                                <label for="password_confirmation" class="form-label">تأكيد كلمةالمرور</label>
                                <input class="form-control" name="password_confirmation" type="password"
                                       id="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm-6 ">

                            </div>
                            <div class="col-sm-4 ">
                                <select class="form-control" name="roles">
                                    <option disabled selected>إختر الصلاحية</option>
                                    @foreach(\Illuminate\Support\Facades\DB::table('roles')->get()  as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="create_new_user" class="btn btn-primary addUser">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">

        $('.addUser').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{route('users.store')}}',
                data: $('#store_form').serialize(),
                beforeSend: function () {
                    $('#create_new_user').html('....Please wait');
                },
                success: function (data) {

                    var optionText = data.data.name;
                    var optionValue = data.data.id;

                    $('#userSelect').append(`<option value="${optionValue}" selected>
                                       ${optionText}
                                  </option>`);

                    $('#store_modal').modal('hide');
                    $('#store_form')[0].reset();


                },

                error: function (error) {
                    console.error(error);
                },
                complete: function () {
                    $('#create_new_user').html('Create New')
                }

            });

        });

        document.getElementById('imageInput').addEventListener('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('previewImage').setAttribute('src', e.target.result);
                document.getElementById('previewImage').style.display = 'block';
            }

            reader.readAsDataURL(file);
        });
    </script>
    <!-- /.container-fluid -->
@endsection
