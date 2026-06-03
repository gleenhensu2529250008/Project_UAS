<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AnimeFlix' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#0f0f0f;
            color:white;
        }

        .navbar{
            background:#151515;
        }

        .navbar-brand{
            color:#ff1493 !important;
            font-weight:bold;
            font-size:28px;
        }

        .nav-link{
            color:white !important;
        }

        .nav-link:hover{
            color:#ff1493 !important;
        }

        .btn-pink{
            background:#ff1493;
            color:white;
            border:none;
        }

        .btn-pink:hover{
            background:#ff33a8;
        }

        .anime-card{
            background:#1b1b1b;
            border:none;
            transition:0.3s;
        }

        .anime-card:hover{
            transform:translateY(-5px);
        }

        .anime-card img{
            height:350px;
            object-fit:cover;
        }

        .profile{
            width:35px;
            height:35px;
            border-radius:50%;
            object-fit:cover;
        }

        footer{
            background:#151515;
            padding:40px 0;
        }

        .search-input{
            background:#222;
            border:none;
            color:white;
        }

        .search-input:focus{
            background:#222;
            color:white;
            box-shadow:none;
        }

    </style>

</head>
<body>

@yield('content')

<footer class="mt-5">
    <div class="container text-center">
        <h4 style="color:#ff1493;">AnimeFlix</h4>
        <p>Nikmati anime favoritmu kapan saja.</p>
    </div>
</footer>

</body>
</html>