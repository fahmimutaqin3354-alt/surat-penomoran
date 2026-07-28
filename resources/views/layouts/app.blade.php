<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Arsip Surat')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])


    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


            <!-- Page Content -->
         {{--$_GET   <main>
                @yield('content')
            </main>--}}
        </div>
    </body>

    @stack('styles')

    <style>

        body{
            font-family:'Poppins',sans-serif;
            background:#f4f6f9;
        }

        .main-content{
            margin-left:260px;
            margin-top:70px;
            padding:25px;
          
        }

        @media(max-width:991px){

            .main-content{
                margin-left:0;
            }

        }

    </style>

</head>


<body>

@include('layouts.navbar')

@include('layouts.sidebar')

<div class="main-content">

    @yield('content')

</div>

@include('layouts.footer')


@stack('scripts')

</body>


</html>
