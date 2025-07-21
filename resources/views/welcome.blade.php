<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Selamat Datang di Website Kami</h1>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-200">Login</a>
            <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition duration-200">Register</a>
        </div>
    </div>

</body>
</html>
