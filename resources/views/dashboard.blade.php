@extends('layouts.master')
@section('content')
    <!-- Content Row -->
{{--    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>--}}

{{--    <script>--}}
{{--        var pusher = new Pusher('22424c7e721c3213c490', {--}}
{{--            cluster: 'ap3'--}}
{{--        });--}}
{{--        var channel = pusher.subscribe('App.Models.User.'+"{{ auth()->id() }}");--}}

{{--        channel.bind('chat', function(data) {--}}
{{--            console.log(JSON.stringify(data.message.message))--}}
{{--        });--}}
{{--    </script>--}}

    <div class="row d-flex flex-row-reverse">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                        <div class="col ml-2 text-right">
                            <div class="font-weight-bold text-primary text-uppercase mb-1">
                                المطاعم
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$data['restaurants']}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('view_user')
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>

                            <div class="col ml-2 text-right">
                                <div class="font-weight-bold text-success text-uppercase mb-1">
                                    المستخدمين
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{$data['users'] -  1 }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endcan
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                        <div class="col ml-2 text-right">
                            <div class="font-weight-bold text-info text-uppercase mb-1">
                                الطلبات
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                        <div class="col ml-2 text-right">
                            <div class="font-weight-bold text-warning text-uppercase mb-1">
                                الاجمالي
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">6</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
@endsection
