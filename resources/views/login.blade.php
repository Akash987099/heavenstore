<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin || Login</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body class="min-h-screen flex items-center justify-center">
    <div id="alert-container" class="fixed bottom-5 right-5 space-y-3 z-50"></div>
    <section class="w-full max-w-md p-6 rounded-xl shadow-lg backdrop-blur-md bg-white/30 dark:bg-gray-800/30">
        <h1 class="text-2xl font-bold text-center text-white mb-4">Admin</h1>
        <form class="space-y-4" id="loginform" method="POST">
            @csrf
            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-white">Your email</label>
                <input type="email" name="email" id="email" placeholder="name@company.com"
                    class="w-full px-4 py-2 rounded-lg bg-white/80 text-black border border-gray-300 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
            <div>
                <label for="password" class="block mb-1 text-sm font-medium text-white">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="w-full px-4 py-2 rounded-lg bg-white/80 text-black border border-gray-300 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Sign
                in</button>
        </form>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var adminLoginUrl = "{{ route('logins') }}";
        var adminIndexUrl = "{{ route('index') }}";
    </script>
    <script src="{{ asset('assets/js/login.js') }}"></script>
</body>

</html>
