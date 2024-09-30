<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
    <div class="container mx-auto p-6">
        <h1 class="text-5xl font-bold text-white mb-8 text-center">Survey Analytics</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($surveys as $survey)
                <div class="bg-white rounded-lg shadow-lg p-6 mb-4 transition-transform transform hover:scale-105 hover:shadow-2xl duration-300">
                    <a href="{{ route('survey.showsingle', ['id' => $survey->id]) }}" class="block">
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $survey->survey_name }}</h2>
                        <p class="mt-2 text-gray-600">Total Responses: <span class="font-bold">{{ $analytics[$survey->id]['responses_count'] ?? 0 }}</span></p>

                        <h3 class="text-lg mt-4 text-gray-800">Questions:</h3>
                        @if (isset($analytics[$survey->id]['questions']))
                            @foreach ($analytics[$survey->id]['questions'] as $question)
                                <div class="mb-3 border-b pb-2">
                                    <strong class="text-gray-700">Question:</strong> {{ $question['question_text'] }}<br>
                                    <!-- <strong class="text-gray-700">Question type:</strong> {{ $question['question_type'] }}<br> -->

                                    <strong class="text-gray-700">Total Responses:</strong> {{ $question['total_responses'] }}<br>
                                    <strong class="text-gray-700">Answers:</strong> {{ implode(', ', $question['answers']) }}
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No responses for this survey yet.</p>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="inline-block bg-gray-800 text-white rounded-md px-4 py-2 hover:bg-gray-700">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
