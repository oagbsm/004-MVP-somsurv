<x-app-layout>
    @if(Session::has('alert'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ Session::get('alert') }}</span>
        </div>
    @endif

    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Welcome Back!</h1>
                    <p class="text-lg mb-4">{{ __("You're logged in!") }}</p>
                    <h2 class="text-xl font-semibold">Credits: ${{ $completedCount * 0.5 }}</h2>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <h1 class="text-3xl font-bold mb-6">Available Surveys</h1>
                
                @if ($surveys->isEmpty())
                    <p class="text-gray-600">No surveys available at the moment.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($surveys as $survey)
                            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                <h2 class="text-xl font-semibold mb-2">{{ $survey->survey_name }}</h2>
                                <p class="text-gray-700 mb-4">{{ Str::limit($survey->description, 100) }}</p>
                                <a href="{{ route('survey.show', $survey->id) }}" class="inline-block bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition-colors duration-300">Take Survey</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

