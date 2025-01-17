<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KolosEU') }}</title>

        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <!-- Bootstrap Icons CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">



        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/js/accessibility.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <div class="mb-14"></div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Footer Section -->
        <footer class="bg-gray-900 text-white py-8 mt-16">
            <div class="max-w-7xl mx-auto text-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">About KolosEU</h3>
                        <p class="text-gray-400">KolosEU is a versatile platform designed for gamers to host and participate in tournaments across various genres including video games, card games, board games, and more!</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Tournaments</a></li>
                            <li><a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white">About</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                        <p class="text-gray-400">Have questions? Reach out to our support team and we will get back to you as soon as possible.</p>
                        <ul class="space-y-2 mt-4">
                            <li><a href="mailto:support@koloseu.com" class="text-gray-400 hover:text-white">support@koloseu.com</a></li>
                            <li><a href="tel:+1234567890" class="text-gray-400 hover:text-white">+1 (234) 567-890</a></li>
                        </ul>
                    </div>

                    <div class="social-icons">
                        <h3>Follow Us:</h3>
                        <div class="flex justify-center space-x-6 mt-6">
                            <ul class="flex space-x-6">
                                <li><a href="https://www.facebook.com" class="text-blue-600 hover:text-blue-800" target="_blank"><i class="bi bi-facebook"></i> Facebook</a></li>
                                <li><a href="https://x.com" class="text-blue-400 hover:text-blue-600" target="_blank"><i class="bi bi-twitter-x"></i> X</a></li>
                            </ul>
                        </div>

                        <div class="flex justify-center space-x-6 mt-6">
                            <ul class="flex space-x-6">
                                <li><a href="https://www.instagram.com" class="text-pink-600 hover:text-pink-800" target="_blank"><i class="bi bi-instagram"></i> Instagram</a></li>
                                <li><a href="https://www.youtube.com" class="text-red-600 hover:text-red-800" target="_blank"><i class="bi bi-youtube"></i> YouTube</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="mt-8">
                    <p class="text-gray-400 text-sm">© 2025 KolosEU. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
