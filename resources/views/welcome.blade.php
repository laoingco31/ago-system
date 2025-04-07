<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BWIS - Welcome</title>

    <!-- Bootstrap & Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Fonts & Icons -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            transition: background 0.3s, color 0.3s;
        }
        [data-bs-theme="dark"] {
            background-color: #121212;
            color: #ffffff;
        }

        /* Deep Sea Background */
        .deep-sea-bg {
            position: relative;
            background: linear-gradient(to bottom, #001f3f, #003366, #004080, #00509e);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            overflow: hidden;
        }

        /* Bubbles Animation */
        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: floatUp 10s infinite ease-in-out;
        }
        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0.5); opacity: 1; }
            100% { transform: translateY(-10vh) scale(1.2); opacity: 0; }
        }

        /* Title Animation */
        .animated-text {
            animation: fadeInUp 1.5s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Button Effects */
        .btn-custom {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .btn-custom:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="deep-sea-bg">
        <!-- Bubbles -->
        <div class="bubble" style="width: 30px; height: 30px; left: 10%; animation-duration: 8s;"></div>
        <div class="bubble" style="width: 40px; height: 40px; left: 30%; animation-duration: 12s;"></div>
        <div class="bubble" style="width: 50px; height: 50px; left: 50%; animation-duration: 9s;"></div>
        <div class="bubble" style="width: 25px; height: 25px; left: 70%; animation-duration: 10s;"></div>
        <div class="bubble" style="width: 60px; height: 60px; left: 90%; animation-duration: 7s;"></div>

        <h1 class="text-5xl font-bold animated-text">Welcome to <span class="text-yellow-300">BWIS</span></h1>
        <p class="text-lg opacity-80 mt-4 animated-text">Your smart and simple inventory tracking system.</p>

        <div class="mt-6 flex gap-4">
            @auth
                <a href="{{ url('/home') }}" class="btn btn-light btn-lg btn-custom">
                    <i class="fas fa-home"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg btn-custom">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg btn-custom">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            @endauth
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const htmlElement = document.documentElement;
            const savedTheme = localStorage.getItem("theme") || "light";
            htmlElement.setAttribute("data-bs-theme", savedTheme);
        });
    </script>
</body>
</html>
