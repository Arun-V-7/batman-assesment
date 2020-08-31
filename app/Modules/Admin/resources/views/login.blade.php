<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Admin Login | Batman</title>

    <link rel="stylesheet" href="/assets/css/validator-engine/validationEngine.jquery.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        .formError .formErrorContent {
            width: 152px;
        }
        html {
            background-color: #efefef;
        }
        body {
            font-family: "Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            line-height: 1.42857143;
            color: rgba(0, 0, 0, 0.87);
            background-color: transparent;
        }
        input {
            outline: none;
        }
        .center-block {
            width: 20%;
            background: white;
            margin: auto;
            text-align: center;
        }
        img {
            width: 50%;
        }
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
            padding: 32px;
            color: rgba(0, 0, 0, 0.87);
        }
        .md-form-group {
            position: relative;
            padding: 18px 0 24px 0;
        }
        .md-input {
            position: relative;
            /*z-index: 5;*/
            width: 100%;
            height: 34px;
            padding: 2px;
            color: inherit;
            background: transparent;
            border: 0;
            border-bottom: 1px solid rgba(160, 160, 160, 0.2);
            border-radius: 0;
            box-shadow: none;
        }
        input {
            outline: none;
        }
        .md-input ~ label {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
            display: inline-block;
            font-size: 0.85em;
            opacity: 0.5;
            -webkit-transition: all 0.2s;
            transition: all 0.2s;
        }
        .md-btn.md-raised:not([disabled]), .md-btn.md-fab {
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
        }
        .md-btn.md-raised {
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        .md-btn {
            position: relative;
            display: inline-block;
            padding: 6px;
            overflow: hidden;
            font-family: inherit;
            font-size: inherit;
            font-style: inherit;
            font-weight: bold;
            line-height: inherit;
            color: currentColor;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            white-space: nowrap;
            cursor: pointer;
            background: transparent;
            border: 0;
            border-radius: 3px;
            outline: none;
            transition: box-shadow 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), -webkit-transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            transition: box-shadow 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            font-variant: inherit;
        }
        .navbar-brand.m-t-lg.text-center {
            width: 100%;
            color: black;
            font-family: 'Blender','Helvetica Neue',Helvetica,Arial,sans-serif;
            font-size: 28px;
            margin-top: 30%;
        }
        .float-label .md-input ~ label {
            top: 20px;
            font-size: 1em;
        }
        .float-label .md-input.ng-dirty ~ label,
        .float-label .md-input.has-value ~ label {
            top: 0;
            font-size: 0.85em;
        }
        .md-input:focus,
        .md-input.focus {
            padding-bottom: 1px;
            border-color: #3f51b5;
            border-bottom-width: 2px;
        }
        .md-input:focus ~ label,
        .md-input.focus ~ label {
            top: 0 !important;
            font-size: 0.85em !important;
            color: #3f51b5;
            opacity: 1;
        }
        .alert {
            text-shadow: 0 1px 0 rgba(255, 255, 255, .2);
            -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .25), 0 1px 2px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .25), 0 1px 2px rgba(0, 0, 0, .05);
        }
        .alert-success {
            background-image: -webkit-linear-gradient(top, #dff0d8 0%, #c8e5bc 100%);
            background-image:      -o-linear-gradient(top, #dff0d8 0%, #c8e5bc 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#dff0d8), to(#c8e5bc));
            background-image:         linear-gradient(to bottom, #dff0d8 0%, #c8e5bc 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffdff0d8', endColorstr='#ffc8e5bc', GradientType=0);
            background-repeat: repeat-x;
            border-color: #b2dba1;
        }
        .alert-info {
            background-image: -webkit-linear-gradient(top, #d9edf7 0%, #b9def0 100%);
            background-image:      -o-linear-gradient(top, #d9edf7 0%, #b9def0 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#d9edf7), to(#b9def0));
            background-image:         linear-gradient(to bottom, #d9edf7 0%, #b9def0 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd9edf7', endColorstr='#ffb9def0', GradientType=0);
            background-repeat: repeat-x;
            border-color: #9acfea;
        }
        .alert-warning {
            background-image: -webkit-linear-gradient(top, #fcf8e3 0%, #f8efc0 100%);
            background-image:      -o-linear-gradient(top, #fcf8e3 0%, #f8efc0 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#fcf8e3), to(#f8efc0));
            background-image:         linear-gradient(to bottom, #fcf8e3 0%, #f8efc0 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffcf8e3', endColorstr='#fff8efc0', GradientType=0);
            background-repeat: repeat-x;
            border-color: #f5e79e;
        }
        .alert-danger {
            background-image: -webkit-linear-gradient(top, #f2dede 0%, #e7c3c3 100%);
            background-image:      -o-linear-gradient(top, #f2dede 0%, #e7c3c3 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#f2dede), to(#e7c3c3));
            background-image:         linear-gradient(to bottom, #f2dede 0%, #e7c3c3 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff2dede', endColorstr='#ffe7c3c3', GradientType=0);
            background-repeat: repeat-x;
            border-color: #dca7a7;
        }
        i.fa.fa-eye, i.fa.fa-eye-slash {
            position: absolute;
            bottom: 35px;
            right: 5px;
            cursor: pointer;
        }
        .hide{
            display: none;
        }
    </style>
</head>
<body>
<div class="app">
    <div class="center-block w-xxl w-auto-xs p-v-md">
        <div class="navbar">
            <div class="navbar-brand m-t-lg text-center">
			<a href='/'>
                <img style='padding-top:5%;' src="/assets/images/batman-logo.png">
			</a>
            </div>
        </div>

        <form id="loginForm" action="/admin/login" method="post">
            {{ csrf_field() }}
            <div class="p-lg panel md-whiteframe-z1 text-color m">
                @if(isset($error))
                    <div id="alert-message" class="alert alert-danger">{{ $error}}</div>
                @endif
                <div class="md-form-group float-label">
                    <input type="email" class="md-input validate[required,custom[email]]" id="email" name="email" value="bruce@vein.com"
                           data-prompt-position="centerRight" ng-model="user.email">
                    <label>Email</label>
                </div>
                <div class="md-form-group float-label">
                    <input type="password" class="md-input validate[required]" id="password" name="password" value="12345"
                           data-prompt-position="centerRight" ng-model="user.password">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                    <i class="fa fa-eye-slash hide" aria-hidden="true"></i>
                    <label>Password</label>
                </div>
				<div class="md-form-group float-label">
                    <input type="hidden" class="md-input" id="status" name="status" value="2"
                           data-prompt-position="centerRight" ng-model="user.status">
                </div>
                <button md-ink-ripple type="submit" id="mybutton" style="background:  dodgerblue; color: white; "
                        class="md-btn md-raised  btn-block p-h-md">Sign in
                </button>

            </div>
        </form>
    </div>
</div>


<script src="/assets/js/jquery/jquery/dist/jquery.js"></script>

<script src="/assets/js/validator-engine/jquery.validationEngine.js" type="text/javascript"
        charset="utf-8"></script>
<script src="/assets/js/validator-engine/jquery.validationEngine-en.js" type="text/javascript"
        charset="utf-8"></script>

<script>
    $(function () {
        $("#loginForm").validationEngine("attach", {
            onValidationComplete: function (form, status) {
                if (status == true) {
                    return true;
                }
            }
        });

        $(document).on('blur', 'input, textarea', function(e){
            $(this).val() ? $(this).addClass('has-value') : $(this).removeClass('has-value');
        });
    })

    $('.fa-eye').click(function () {
        $("#password").attr("type","text");
        $('.fa-eye').addClass('hide');
        $('.fa-eye-slash').removeClass('hide');
    });

    $('.fa-eye-slash').click(function () {
        $("#password").attr("type","password");
        $('.fa-eye-slash').addClass('hide');
        $('.fa-eye').removeClass('hide');
    });
</script>

</body>
</html>

