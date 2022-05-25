<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> </title>
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> 
        <!-- Template Stylesheet -->
        <link href="{{ asset('css/style.css') }}"  rel="stylesheet">
    </head>    
    <body class="page_login"> 
            @yield('content')  
            <!-- Template Javascript -->
            <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>