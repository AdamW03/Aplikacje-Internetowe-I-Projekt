<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="KolosEU Logo" class="h-96">  <!-- Jeszcze większe logo -->
        </div>
        <h1 class="text-3xl font-semibold text-center text-gray-800">Welcome to KolosEU Platform</h1>
        <p class="mt-2 text-center text-lg text-gray-600">Your go-to hub for organizing all types of gaming tournaments: from online and LAN events to card games, board games, and retro tournaments.</p>
    </x-slot>

    <div class="bg-white py-10">
        <!-- Platform Overview Section -->
        <section class="max-w-7xl mx-auto px-6 sm:px-10">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">What is KolosEU?</h2>
                <p class="text-lg text-gray-600 mt-2">KolosEU is a versatile platform designed to help you organize, manage, and participate in gaming tournaments across various genres. Whether it's competitive eSports, casual LAN parties, card games, board games, or even retro events — we've got you covered.</p>
            </div>

            <!-- Tournament Types Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Online & LAN Tournaments</h3>
                    <p class="text-gray-600 mt-4">Host your next big gaming event with ease. From competitive eSports to casual gatherings, we support all the popular multiplayer games. Our platform is optimized for both online and LAN setups.</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Card Games</h3>
                    <p class="text-gray-600 mt-4">Play and compete in a variety of card games. Whether you love Magic: The Gathering, Hearthstone, or local trading card games, our platform allows you to host tournaments for all your favorite card games.</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Board Games</h3>
                    <p class="text-gray-600 mt-4">For board game enthusiasts, KolosEU makes organizing tournaments of any complexity a breeze. From chess to strategy games, we provide a seamless experience for both players and event organizers.</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Retro Tournaments</h3>
                    <p class="text-gray-600 mt-4">For retro game lovers, we provide the tools to organize and relive the classics. Whether you're a fan of old-school arcade games, retro consoles, or vintage PC games, our platform supports it all.</p>
                </div>
            </div>
        </section>

        <!-- Slider -->
        <div class="relative w-full max-w-4xl mx-auto mt-10 overflow-hidden">
            <div class="flex transition-transform duration-500 ease-in-out" id="slider" style="width: 400%; display: flex;">
                <!-- Image 1 -->
                <div class="w-3/4 h-96 mx-4">
                    <img src="{{ asset('images/slider-image1.jpg') }}" alt="Image 1" class="object-cover w-full h-full">
                </div>
                <!-- Image 2 -->
                <div class="w-3/4 h-96 mx-4">
                    <img src="{{ asset('images/slider-image2.jpg') }}" alt="Image 2" class="object-cover w-full h-full">
                </div>
                <!-- Image 3 -->
                <div class="w-3/4 h-96 mx-4">
                    <img src="{{ asset('images/slider-image3.jpg') }}" alt="Image 3" class="object-cover w-full h-full">
                </div>
                <!-- Image 4 -->
                <div class="w-3/4 h-96 mx-4">
                    <img src="{{ asset('images/slider-image4.jpg') }}" alt="Image 4" class="object-cover w-full h-full">
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button id="prev" class="absolute top-1/2 left-0 transform -translate-y-1/2 px-4 py-2 bg-gray-700 text-white rounded-full">‹</button>
            <button id="next" class="absolute top-1/2 right-0 transform -translate-y-1/2 px-4 py-2 bg-gray-700 text-white rounded-full">›</button>
        </div>

        <script>
            const prevButton = document.getElementById('prev');
            const nextButton = document.getElementById('next');
            const slider = document.getElementById('slider');
            let currentIndex = 0;
            const images = slider.getElementsByTagName('div');
            const totalImages = images.length;

            function showImage(index) {
                const offset = -index * 25;
                slider.style.transform = `translateX(${offset}%)`;
            }

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
                showImage(currentIndex);
            });

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
                showImage(currentIndex);
            });

            setInterval(() => {
                currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
                showImage(currentIndex);
            }, 6000);

            showImage(currentIndex);
        </script>

        <!-- Platform Features Section -->
        <section class="max-w-7xl mx-auto px-6 sm:px-10 mt-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Features of KolosEU</h2>
                <p class="text-lg text-gray-600 mt-2">We offer a comprehensive set of tools to enhance your tournament experience.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Easy Registration</h3>
                    <p class="text-gray-600 mt-4">Streamlined player registration, easy bracket setup, and the ability to manage participants in real-time.</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Easy Tournament Registration</h3>
                    <p class="text-gray-600 mt-4">Register for tournaments in just a few clicks, with a simple and intuitive interface designed for all players.</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">User-Friendly Interface</h3>
                    <p class="text-gray-600 mt-4">Our platform offers a smooth, easy-to-navigate interface, making it effortless to sign up, track progress, and manage your tournaments.</p>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        @guest
        <section class="bg-gray-900 py-16">
            <div class="text-center text-white px-6 sm:px-10">
                <h2 class="text-3xl font-semibold">Join KolosEU Today</h2>
                <p class="mt-4 text-lg">Sign up now and start organizing your tournaments on one of the most comprehensive and user-friendly platforms available. Whether you're a player or an organizer, KolosEU is the perfect place to bring your gaming community together.</p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white py-2 px-6 rounded-md text-xl">Get Started</a>
                </div>
            </div>
        </section>
        @endguest
    </div>
</x-app-layout>
