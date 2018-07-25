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
                <form id="example-form" action="{{route('save-data-user')}}" method="post">
                    <div>
                        <h3>Step 1</h3>
                        <section>
                            {!! Form::token() !!}
                            <label for="first_name">First Name</label>
                            {!! Form::text("first_name",null,["class"=>"form-control alphabetsOnly ","id"=>"first_name "]) !!}

                            <label for="last_name">Last Name </label>
                            {!! Form::text("last_name",null,["class"=>"form-control alphabetsOnly required","id"=>"last_name"]) !!}
                            <label for="email">Email </label>
                            {!! Form::email("email",null,["class"=>"form-control checkEmail required","id"=>"email"]) !!}
                            <label></label>

                            <label for="password">Password </label>
                            {!! Form::password("password",["class"=>"form-control required","id"=>"password"]) !!}

                            <label for="confirmed">Confirm Password *</label>
                            {!! Form::password("confirmed",["class"=>"form-control required","id"=>"confirmed"]) !!}

                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                        </section>
                        <h3>Step 2</h3>
                        <section style="position: inherit">

                            <div id="list-address">
                                <label for="address">Address</label>
                                {!! Form::text("addresses[]",null,["class"=>"form-control required","id"=>"addresses"]) !!}
                            </div>

                            <p>
                                <button class="btn btn-success" id="add-address" type="button">Add Address</button>
                            </p>
                            <label for="date_of_birth">Date Of Birth</label>
                            {!! Form::text("date_of_birth",null,["class"=>"form-control required","id"=>"date_of_birth","onkeydown"=>"return false"]) !!}
                            <label for="membership_id">Memberships</label><br/>
                            <select id="membership_id" name="membership_id" style="width: 600px;"></select><br/>
                            {{--{!! Form::select("membership_id",[],["class"=>"col-md-12 form-control required","id"=>"membership_id",'style'=>'width:600px;']) !!}--}}
                            <label for="card_type">Type Credit Card</label>
                            {!! Form::select("card_type",["VISA"=>"VISA","MASTERCARD"=>"MASTERCARD"],null,['class'=>"form-control required",'id'=>'card_type']) !!}
                            <label for="credit_card"> Credit Card Number</label>
                            {!! Form::text("card_number",null,["class"=>"form-control numericOnly required ","id"=>"card_number"]) !!}
                            <label for="expiry_month"> Credit Card Expiry Month</label>
                            {!! Form::text("expiry_month",null,["class"=>"form-control numericOnly required","id"=>"expiry_month"]) !!}
                            <label for="expiry_year"> Credit Card Expiry Year</label>
                            {!! Form::text("expiry_year",null,["class"=>"form-control  numericOnly required","id"=>"expiry_year"]) !!}
                        </section>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script>

    var form = $("#example-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            confirmed: {
                equalTo: "#password"
            },
            card_number: {
                required: true,
                creditcard: true
            },
            expiry_month:{
                maxlength:2,
                minlength:2
            },
            expiry_year:{
                maxlength:4,
                minlength:2
            },
            password:{
                minlength:4
            }
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden";

            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            console.log(currentIndex+"onFinishing");
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            form.submit();
        }
    });

    $('#date_of_birth').datetimepicker({
        viewMode: 'years',
        format: 'YYYY-MM-DD',
        minDate: "1950-01-01",
        maxDate: new Date(),
        defaultDate: "1994-01-01"
    });
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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


    $(".numericOnly").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    $('#add-address').on('click',function(e){
        var html='<label for="address">Address</label><input class="form-control" id="address" name="addresses[]" type="text">';
        $("#list-address").append(html);
    });
    $('#membership_id').select2({
        placeholder: 'Type a word',
        ajax: {
            url: '/get-memberships',
            dataType: 'json',
            processResults: function (data) {
                console.log(data);
                return {
                    results:  $.map(data, function (item) {
                        console.log(item);
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });


</script>
</html>
