<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') | Batman</title>


    <!-- Modal popup script-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Modal popup script end-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/assets/css/style.css" rel="stylesheet">


    <style>
        html {
            background-color: #efefef;
        }
        body {
            font-family: poppins-regular;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            line-height: 1.42857143;
            color: rgba(0, 0, 0, 0.87);
            background-color: transparent;
            margin: 0;
        }
        @font-face {
            src: url("/assets/fonts/Poppins-Regular.ttf");
            font-family: poppins-regular;
        }
        i {
            margin: 0 6%;
        }
    </style>

    @yield('head')
</head>

<body>

<div>
    @include('Admin::layouts.sidebar')
    @yield('content')
</div>


@include('Admin::layouts.scripts')
@yield('scripts')
</body>
</html>
