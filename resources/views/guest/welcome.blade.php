<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WibuDesu</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#0d0d0d;
            color:white;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family:Segoe UI, sans-serif;
        }

        .hero{
            max-width:1200px;
            width:100%;
            padding:50px;
        }

        .logo{
            font-size:40px;
            font-weight:bold;
        }

        .logo span{
            color:#ff1493;
        }

        .title{
            font-size:65px;
            font-weight:800;
            line-height:1.1;
        }

        .title span{
            color:#ff1493;
        }

        .description{
            color:#bdbdbd;
            font-size:18px;
            margin-top:20px;
            margin-bottom:30px;
        }

        .btn-pink{
            background:#ff1493;
            color:white;
            border:none;
            padding:12px 30px;
            border-radius:10px;
            font-weight:bold;
            text-decoration:none;
            transition:0.3s;
        }

        .btn-pink:hover{
            background:#ff3cab;
            color:white;
        }

        .btn-outline-custom{
            border:2px solid #ff1493;
            color:#ff1493;
            padding:12px 30px;
            border-radius:10px;
            text-decoration:none;
            margin-left:10px;
            transition:0.3s;
        }

        .btn-outline-custom:hover{
            background:#ff1493;
            color:white;
        }

        .anime-image{
            width:100%;
            max-width:500px;
        }

    </style>

</head>
<body>

<div class="container hero">

    <div class="row align-items-center">

        <div class="col-lg-6">

            <h1 class="logo">
                Wibu<span>Desu</span>
            </h1>

            <h2 class="title mt-4">
                Watch & Read <br>
                <span>Your Favorite Anime</span>
            </h2>

            <p class="description">
                Tempat terbaik untuk membaca Manga, menonton Anime,
                dan menikmati Light Novel favoritmu dalam satu platform.
            </p>

            <div class="mt-4">

<a href="{{ route('home') }}" class="btn-pink">
    Get Started
</a>

<a href="{{ route('login') }}" class="btn-outline-custom">
    Login
</a>
            </div>

        </div>

        <div class="col-lg-6 text-center">

            <img
                src="https://images6.alphacoders.com/606/thumb-1920-606263.jpg"
                alt="Anime"
                class="anime-image rounded-4 shadow-lg"
            >

        </div>

    </div>

</div>

</body>
</html>