@extends('layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid" dir="rtl">

        <div class="row">
            <div class="col-md-10">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <form dir="rtl" class="card p-1 p-sm-5 setting-form text-right mb-5" enctype="multipart/form-data" action="{{route('profile.update',auth()->user()->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" class="form-control" id="name" value="{{$user->name ?? '--'}}" name="name">
                        </div>
                        <div class="col-sm-6">
                            <label for="address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="address" value="{{$user->address ?? '--'}}" name="address">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                                <img src="{{url("storage/images/".$user->image ?? '')}}" alt="Uploaded Image" id="previewImage" style="display: none;max-width: 100px;max-height: 100px;border-radius: 5px;margin: 18px 150px -37px 0;">
                             @if(auth()->user()->image != null)
                                <img src="{{url("storage/images/".$user->image ?? '')}}" alt="Uploaded Image" id="UserImage" style="display: block;max-width: 100px;max-height: 100px;border-radius: 5px;margin: 18px 150px -37px 0;">
                            @endif
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="f-name" class="form-label">رقم الجوال</label>
                            <input type="text" class="form-control" id="phone" value="{{$user->phone ?? '--'}}"  name="phone">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="formFile" class="form-label">إختر صورة</label>
                            <input class="form-control" name="image" style="padding: 9px 22px 0px 1px;height: 48px;" type="file" id="imageInput">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="email" class="form-label">الإيميل</label>
                            <input type="text" class="form-control" id="email" value="{{$user->email ?? '--'}}" name="email">
                        </div>

                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="password" class="form-label">كلمةالمرور</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="password_confirmation" class="form-label">تأكيد كلمةالمرور</label>
                            <input class="form-control" name="password_confirmation" type="password" id="password_confirmation">
                        </div>
                    </div>

                    <div class="text-left mt-5">
                        <a href="#" type="button" style="text-decoration: none;color: white" class="btn btn-danger">الخلف</a>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </form>
            </div>

        </div>

        <hr>

    </div>
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('previewImage').setAttribute('src', e.target.result);
                document.getElementById('previewImage').style.display = 'block';
                document.getElementById('UserImage').style.display = 'none';
            }

            reader.readAsDataURL(file);
        });
    </script>
    <!-- /.container-fluid -->
@endsection
