<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>WibuDesu</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>
<body>

<nav>

    <a href="/">WibuDesu</a>

    @guest
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endguest

    @auth
        <a href="/dashboard">Dashboard</a>
        <a href="/collections">Koleksi</a>
        <a href="/profile">Profile</a>
    @endauth

</nav>

<div>

    @yield('content')

</div>

</body>
</html>