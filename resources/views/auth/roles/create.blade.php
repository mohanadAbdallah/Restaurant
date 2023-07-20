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
                      action="{{route('roles.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="name" class="form-label">إسم الصلاحية</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-end">
                            <div class="form-group">

                                <br/>
                                <div class="row">
                                        <div class="list-group">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                <h5>Users</h5>
                                            </button>
                                            @foreach($permissions as $value)
                                                @if($value->parent=="user")
                                                    <button type="button" for="ch1" class="list-group-item list-group-item-action btn-ch">
                                                        <div class="form-check mb-0">
                                                            <label class="form-check-label">
                                                                <input class="form-input-styled" type="checkbox" name="permission[]"  value="{{$value->id}}">
                                                                {{$value->name_key }}
                                                            </label>
                                                        </div>
                                                    </button>
                                                @endif
                                            @endforeach
                                    </div>
                                    <div class="list-group">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                <h5>Roles</h5>
                                            </button>
                                            @foreach($permissions as $value)
                                                @if($value->parent=="role")
                                                    <button type="button" for="ch1" class="list-group-item list-group-item-action btn-ch">
                                                        <div class="form-check mb-0">
                                                            <label class="form-check-label">
                                                                <input class="form-input-styled" type="checkbox" name="permission[]"  value="{{$value->id}}">
                                                                {{$value->name_key }}
                                                            </label>
                                                        </div>
                                                    </button>
                                                @endif
                                            @endforeach
                                    </div>
                                    <div class="list-group">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                <h5>Restaurants</h5>
                                            </button>
                                            @foreach($permissions as $value)
                                                @if($value->parent=="restaurant")
                                                    <button type="button" for="ch1" class="list-group-item list-group-item-action btn-ch">
                                                        <div class="form-check mb-0">
                                                            <label class="form-check-label">
                                                                <input class="form-input-styled" type="checkbox" name="permission[]"  value="{{$value->id}}">
                                                                {{$value->name_key }}
                                                            </label>
                                                        </div>
                                                    </button>
                                                @endif
                                            @endforeach
                                    </div>
                                    <div class="list-group">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                <h5>Categories</h5>
                                            </button>
                                            @foreach($permissions as $value)
                                                @if($value->parent=="category")
                                                    <button type="button" for="ch1" class="list-group-item list-group-item-action btn-ch">
                                                        <div class="form-check mb-0">
                                                            <label class="form-check-label">
                                                                <input class="form-input-styled" type="checkbox" name="permission[]"  value="{{$value->id}}">
                                                                {{$value->name_key }}
                                                            </label>
                                                        </div>
                                                    </button>
                                                @endif
                                            @endforeach
                                    </div>
                                    <div class="list-group">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                <h5>Items</h5>
                                            </button>
                                            @foreach($permissions as $value)
                                                @if($value->parent=="item")
                                                    <button type="button" for="ch1" class="list-group-item list-group-item-action btn-ch">
                                                        <div class="form-check mb-0">
                                                            <label class="form-check-label">
                                                                <input class="form-input-styled" type="checkbox" name="permission[]"  value="{{$value->id}}">
                                                                {{$value->name_key }}
                                                            </label>
                                                        </div>
                                                    </button>
                                                @endif
                                            @endforeach
                                    </div>

                                    <div class="list-group">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                <h5>Orders</h5>
                                            </button>
                                            @foreach($permissions as $value)
                                                @if($value->parent=="order")
                                                    <button type="button" for="ch1" class="list-group-item list-group-item-action btn-ch">
                                                        <div class="form-check mb-0">
                                                            <label class="form-check-label">
                                                                <input class="form-input-styled" type="checkbox" name="permission[]"  value="{{$value->id}}">
                                                                {{$value->name_key }}
                                                            </label>
                                                        </div>
                                                    </button>
                                                @endif
                                            @endforeach
                                    </div>

                                </div>
                              </div>
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
    <style>
        .form-check-label {
            margin: 0px 29px 0px 0px;
        }
        .list-group{
            padding: 18px;
        }
    </style>
    <!-- /.container-fluid -->
@endsection
