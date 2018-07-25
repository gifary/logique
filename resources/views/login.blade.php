<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Laravel</title>

    <link rel="stylesheet" href="{{asset('css/all.css')}}">

    <script type="text/javascript" src="{{asset('js/vendor.js')}}"></script>


</head>
<body>
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                {{session('message')}}
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <!-- Main content -->
            <div id="wizard">
                <form  action="{{route('login')}}" method="post">
                    {!! Form::token() !!}
                    <div class="text-center" style="padding:50px 0">
                        <div class="logo">login</div>
                        <!-- Main Form -->
                        <div class="login-form-1">
                            <form id="login-form" class="text-left">
                                <div class="login-form-main-message"></div>
                                <div class="main-login-form">
                                    <div class="login-group">
                                        <div class="form-group">
                                            <label for="lg_username" class="sr-only">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="lg_password" class="sr-only">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">Login</button>
                                </div>
                            </form>
                        </div>
                        <!-- end:Main Form -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
