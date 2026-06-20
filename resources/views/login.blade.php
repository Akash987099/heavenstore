<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin || Login</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <style>
        body {
            /* Modern dark gradient background */
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            /* Agar aap background mein cafe ki image lagana chahte hain toh upar wali line hata kar niche wali line uncomment karein */
            /* background: url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=1920&auto=format&fit=crop') no-repeat center center/cover; */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Decorative Glowing Blobs -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30"></div>

    <div id="alert-container" class="fixed bottom-5 right-5 space-y-3 z-50"></div>
    
    <!-- Glassmorphism Form Container -->
    <section class="w-full max-w-md p-8 rounded-2xl shadow-2xl backdrop-blur-xl bg-white/10 border border-white/20 z-10 relative">
        
        <!-- Logo Section -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-md shadow-inner border border-white/20 p-2">
                <!-- Logo Image: Agar ye path exist nahi karega, toh onerror wala SVG icon chal jayega -->
                <img src="{{ asset('assets/images/logo.png') }}" alt="Cafe Logo" class="w-full h-full object-contain drop-shadow-lg" onerror="this.outerHTML='<svg class=\'w-10 h-10 text-blue-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M20 8H4M4 8a4 4 0 014-4h8a4 4 0 014 4M4 8v10a2 2 0 002 2h12a2 2 0 002-2V8m-6 4h.01\'></path></svg>'">
            </div>
        </div>

        <h1 class="text-3xl font-extrabold text-center text-white mb-2 tracking-tight">Admin Portal</h1>
        <p class="text-center text-gray-300 text-sm mb-8">Sign in to manage your cafe</p>

        <form class="space-y-5" id="loginform" method="POST">
            @csrf
            <div>
                <label for="email" class="block mb-1.5 text-sm font-medium text-gray-200">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <input type="email" name="email" id="email" placeholder="admin@cafe.com"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-gray-900/50 text-white placeholder-gray-400 border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition-all outline-none"
                        required>
                </div>
            </div>
            <div>
                <label for="password" class="block mb-1.5 text-sm font-medium text-gray-200">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-gray-900/50 text-white placeholder-gray-400 border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition-all outline-none"
                        required>
                </div>
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-500 hover:to-indigo-500 focus:ring-4 focus:ring-blue-500/30 transform transition-all active:scale-[0.98]">
                    Sign In
                </button>
            </div>
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
