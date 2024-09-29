<x-app-layout>


    <!-- Navigation Bar -->


    <!-- Dashboard Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Business Dashboard</h1>

            <!-- Dashboard Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Create Survey Button -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Create Survey</h2>
                    <p class="text-gray-600 mb-4">Build a new survey to gather insights from your users.</p>
                    <a href="/business/create" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Survey</a>
                </div>

                <!-- View Surveys Button -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">View Surveys</h2>
                    <p class="text-gray-600 mb-4">Manage your existing surveys and review responses.</p>
                    <a href="/business/viewsurvey" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">View Surveys</a>
                </div>

                <!-- View Analytics Button -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">View Analytics</h2>
                    <p class="text-gray-600 mb-4">Analyze responses to your surveys with real-time data.</p>
                    <a href="/business/analytics" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">View Analytics</a>
                </div>
            </div>
        </div>
    </section>

    </x-app-layout>

