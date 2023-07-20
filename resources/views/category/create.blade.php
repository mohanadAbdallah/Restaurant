@extends('layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid" dir="rtl">
        <div class="row">
            <div class="col-md-10">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <form dir="rtl" class="card p-1 p-sm-5 setting-form text-right mb-5" enctype="multipart/form-data"
                      action="{{route('categories.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="name" class="form-label">إسم القسم</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-sm-6">
                            <img src="#" alt="Uploaded Image" id="previewImage"
                                 style="display: none;max-width: 75px;max-height: 75px;border-radius: 5px;margin: 18px 150px -37px 0;">
                        </div>
                    </div>
                    <div class="form-group row mb-3">

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <img src="#" alt="Uploaded Image" id="previewImage" style="display: none;width: 40px;">
                        <label for="formFile" class="form-label">الصورة</label>
                        <input class="form-control" name="image" style="padding: 9px 22px 0px 1px;height: 48px;"
                               type="file" id="imageInput">
                    </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="parent_id">القسم الأب : (إختياري )</label>

                            <select name="parent_id" class="form-control" id="parent_id">
                                <option value="">None</option>
                                @if($categories)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="text-left mt-5">
                        <a href="{{route('categories.index')}}" type="button" style="text-decoration: none;color: white" class="btn btn-danger">الخلف</a>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>

        </div>

        <hr>

    </div>
    <style>
        .form-check-label {
            margin: 0px 29px 0px 0px;
        }
        .list-group{
            padding: 18px;
        }
    </style>
    <script type="text/javascript">

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

@endsection
