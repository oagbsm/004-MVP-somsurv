<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Survey Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <header class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <a href="/" class="text-2xl font-bold text-indigo-600">SomSurvey</a>
                </div>
                @if (Route::has('login'))

                <nav class="hidden md:flex space-x-10 py-2">
                <a href="#" class="text-gray-500 hover:text-indigo-600">Pricing</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Blog</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Contact</a>
                    @auth
                    <a href="/login" class="text-gray-500 hover:text-indigo-600">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Login</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 px-4  bg-indigo-600 text-white rounded hover:bg-indigo-700">Sign Up</a>
                    @endif
                    @endauth

                </nav>@endif
                <div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <!-- Text -->
                <div class="px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8">
                    <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl">
                        Create Engaging Surveys & Gather Feedback
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Start building beautiful, responsive surveys that your audience will love. Get insights in real-time and make data-driven decisions.
                    </p>
                    <div class="mt-6">
                        <a href="/login" class="px-8 py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700">Get Started</a>
                    </div>
                </div>
                
                <!-- Image -->
                <div class="mt-10 lg:mt-0">
                    <img class="rounded-lg shadow-lg ml-20 w-[500px] h-80" src="{{ asset('images/survey-image.webp') }}" alt="Survey illustration">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Why Choose Us</h2>
            <p class="mt-4 text-lg text-gray-600">Build surveys that deliver meaningful results with features that drive engagement.</p>
            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto bg-indigo-600 text-white rounded-full mb-6">
                        <!-- Icon -->
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 2h.01M9 16h6m-6-8h6m-6 4h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Customizable Templates</h3>
                    <p class="text-gray-600">Choose from a variety of survey templates tailored to your needs.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto bg-indigo-600 text-white rounded-full mb-6">
                        <!-- Icon -->
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Real-Time Analytics</h3>
                    <p class="text-gray-600">Get insights as responses come in, enabling you to make decisions quickly.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto bg-indigo-600 text-white rounded-full mb-6">
                        <!-- Icon -->
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V7m0 10l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Seamless Integration</h3>
                    <p class="text-gray-600">Integrate with your favorite tools like Slack, Mailchimp, and Google Sheets.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <p>&copy; 2024 SomSurvey. All Rights Reserved.</p>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-gray-400">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-400">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
