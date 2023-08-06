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
        <div class="card text-right" style="width: 40% ;margin: 0 auto 10px;float: none;">
            <div class="card-header">
                {{$user->name }}
            </div>
            <div class="card-body">
                @if(isset($user))
                        <li>الاسم : {{$user->name}}</li>
                        <li>رقم الهاتف : {{$user->phone}}</li>
                        <li>الإيميل : {{$user->email}}</li>
                        <li>العنوان : {{$user->address}}</li>
                 @endif
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <a href="javascript:void(0)" onclick="history.back()" class="btn btn-danger">الخلف</a>
                </div>
            </div>
        </div>

    </div>
@endsection
