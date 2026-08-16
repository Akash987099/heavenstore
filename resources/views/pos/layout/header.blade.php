<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Heaven Kart || POS</title>
  <!-- Tailwind + Inter + FontAwesome -->
  <link rel="manifest" href="{{asset('manifest.json')}}">
  <meta name="theme-color" content="#128C7E">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  <link
        rel="apple-touch-icon"
        href="{{ asset('images/pwa/icon-192.png') }}"
    >
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * { font-family: 'Inter', sans-serif; }
    body { background: #F8FAFC; }
    .glass { background: rgba(255,255,255,0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.7); }
    .glass-dark { background: rgba(15,23,42,0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.08); }
    .gradient-primary { background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); }
    .card-hover { transition: all 0.2s ease; }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); }
    .progress-ring { transition: stroke-dashoffset 0.6s ease; }
    .step-card { transition: all 0.15s ease; }
    .step-card:hover { background: rgba(255,255,255,0.8); border-color: #25D36640; }
    .onboarding-illustration { background: linear-gradient(145deg, #E6F7ED, #D1F0E0); border-radius: 40px; }
    .sidebar-link { transition: all 0.15s; }
    .sidebar-link:hover { background: rgba(37, 211, 102, 0.08); color: #128C7E; }
    .sidebar-link.active { background: rgba(37, 211, 102, 0.12); color: #128C7E; font-weight: 600; }
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: #F1F5F9; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: #25D366; border-radius: 10px; }
  </style>
</head>
<body class="antialiased text-[#0F172A] bg-[#F8FAFC] flex h-screen overflow-hidden">


<script>
if ('serviceWorker' in navigator) {

    window.addEventListener('load', function () {

        navigator.serviceWorker.register(
            "{{ asset('sw.js') }}",
            {
                scope: '/pos/'
            }
        )
        .then(function (registration) {

            console.log(
                'Heaven POS PWA registered:',
                registration.scope
            );

        })
        .catch(function (error) {

            console.error(
                'PWA registration failed:',
                error
            );

        });

    });

}
</script>