<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/imgareaselect-default.css')}}" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.imgareaselect.pack.js')}}"></script>


</head>
<body>
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <!-- Main content -->
            <section class="content" style="margin: 50px">
                <div class="row">
                    <div class="col-xs-4">
                        {!! Form::open(['url' => '', 'method' => 'post','class'=>'form-horizontal','enctype'=>"multipart/form-data",'id'=>'data']) !!}
                        <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                            {!! Form::label('name','Nama Lengkap',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('name', null , ['class'=>'form-control alphabetsOnly','id'=>'name','required'=>true]) !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                            {!! Form::label('email',"Email",['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::email('email',null,['class'=>'form-control checkEmail','id'=>'email','required'=>true]) !!}
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('foto',"Foto",['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                <input type="file" id="foto" name="foto" accept="image/gif, image/jpeg, image/png" onchange="readURL(this);" class="hidden">
                                <img id="previewImage" src="{{asset("image/blank.jpeg")}}" alt="your image" width="150" height="200" />
                            </div>
                        </div>
                        <input type="hidden" name="x1" value="" id="x1" />
                        <input type="hidden" name="y1" value="" id="y1" />
                        <input type="hidden" name="x2" value="" id="x2" />
                        <input type="hidden" name="y2" value="" id="y2" />
                        <input type="hidden" name="w" value="" id="w" />
                        <input type="hidden" name="h" value="" id="h" />
                        <!-- /.box-body -->

                        <div class="box-footer">
                            {!! Form::submit(isset($model) ? 'Update' : 'Save', ['class'=>'btn btn-success','id'=>'save']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $u)
                                    <tr>
                                        <td>{{$u->name}}</td>
                                        <td>{{$u->email}}</td>
                                        <td>
                                            <img src="{{asset("storage/".$u->foto)}}" height="50">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</body>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function () {
        $('#previewImage').imgAreaSelect({ maxWidth: 200, maxHeight: 150, handles: true,onSelectChange: preview });
    });

    function preview(img, selection) {
        $('#x1').val(selection.x1);
        $('#y1').val(selection.y1);
        $('#x2').val(selection.x2);
        $('#y2').val(selection.y2);
        $('#w').val(selection.width);
        $('#h').val(selection.height);
    }


    $('.alphabetsOnly').keypress(function (e) {
        var regex = new RegExp(/^[a-zA-Z\s]+$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            e.preventDefault();
            return false;
        }
    });

    $('.checkEmail').keyup(function (e) {
        $.ajax({
            url: '/check-email',
            type: 'POST',
            data: {_token: CSRF_TOKEN, email: $(this).val()  },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if(data.status){
                    alert("email already taken");
                }else{
                    console.log("email not found");
                }
            }
        });
    });
    $('#previewImage').click(function () {
        $('#foto').trigger( "click" );
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewImage')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("form#data").submit(function(e) {
        e.preventDefault();
        let email = $('#email').val();

        if(!isEmail(email)){
            alert("Email tidak valid");
            return false;
        }

        if(!$("#foto").val()){
            alert("Foto belum d pilih");
            return false;
        }
        //submit all data via ajax
        var formData = new FormData(this);
        $.ajax({
            url: 'save-data-user',
            type: 'POST',
            data: formData,
            success: function (data) {
                alert("succes input data");
                $("#data")[0].reset();
                $('#previewImage')
                    .attr('src', "{{asset('image/blank.jpeg')}}")
                    .width(150)
                    .height(200);
            },
            error:function(data){
              console.log(data.responseText);
              alert("pastikan data di isi dengan benar");
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
</html>
