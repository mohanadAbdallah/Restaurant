@extends('layouts.master')
@section('content')
    <div class="container-fluid" dir="rtl">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <a href="{{route('items.create',['category'=>$category->id])}}" class="btn btn-success">إضافة عنصر</a>
    <div class="card text-right" style="width: 40% ;margin: 0 auto 10px;float: none;">
        <div class="card-header">
            القسم {{$category->title }}
        </div>
        <div class="card-body">
            @if(isset($category->subCategories))
                @foreach($category->subCategories as $subCategory)
                    <li>{{$subCategory->title}}</li>
                    @if($subCategory->subCategories)
                        @foreach($subCategory->subCategories as $subSubCategory)
                            <li class="mr-5">{{$subSubCategory->title}}</li>
                        @endforeach
                        @endif
                @endforeach
            @endif
        </div>
        <div class="card-footer">
            <div class="form-group">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#subCategoryModal"
                   class="btn btn-primary">
                    <i class="fa fa-plus-circle"> قسم فرعي</i>

                </a>
                <a href="{{route('categories.index')}}" class="btn btn-danger">الخلف</a>
            </div>
        </div>
    </div>

    <div class="modal" id="subCategoryModal" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة قسم فرعي </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('subcategories.store',$category->id)}}">
                        @csrf
                        <div class="form-group row text-right">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="name" class="form-label">إسم القسم</label>
                                <input type="text" class="form-control" id="name" name="title">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
