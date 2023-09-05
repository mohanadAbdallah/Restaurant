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
                      action="{{route('items.update',$item->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="f-name" class="form-label">اسم المنتج</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$item->name}}">
                        </div>
                        <div class="col-sm-6">
                            <label for="l-name" class="form-label">السعر</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{$item->price}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <img src="#" alt="Uploaded Image" id="previewImage"
                                 style="display: none;max-width: 75px;max-height: 75px;border-radius: 5px;margin: 18px 150px -37px 0;">
                            @if($item->image != null)
                                <img src="{{url("storage/images/".$item->image ?? '')}}" alt="Uploaded Image" id="ItemImage" style="display: block;max-width: 100px;max-height: 100px;border-radius: 5px;margin: 18px 150px -37px 0;">
                            @endif
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <textarea class="form-control" name="description" id="floatingTextarea2" style="height: 100px">
                                {{$item->description}}
                            </textarea>
                            <label for="floatingTextarea2">الوصف (إختياري )</label>

                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <img src="{{url('storage/images/'.$item->image ?? '')}}" alt="Uploaded Image" id="previewImage" style="display: none;width: 40px;">
                            <label for="formFile" class="form-label">الصورة</label>
                            <input class="form-control" name="image" style="padding: 9px 22px 0px 1px;height: 48px;"
                                   type="file" id="imageInput">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label class="form-label">القسم</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option disabled selected>إختر القسم</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$item->category_id == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
                                @endforeach
                            </select>
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

    <script type="text/javascript">

        document.getElementById('imageInput').addEventListener('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('previewImage').setAttribute('src', e.target.result);
                document.getElementById('previewImage').style.display = 'block';
                document.getElementById('ItemImage').style.display = 'none';

            }

            reader.readAsDataURL(file);
        });
    </script>
    <!-- /.container-fluid -->
@endsection
