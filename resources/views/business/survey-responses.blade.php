<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
xs    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold mb-6">{{ $survey->survey_name }} Responses</h1>

        @if ($responses->isEmpty())
            <p class="text-gray-500">No responses yet for this survey.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($responses as $response)
                    @php
                        $formattedAnswers = json_decode($response->formatted_answers, true); // Decode JSON
                    @endphp

                    <div class="bg-white rounded-lg shadow-lg p-4 mb-4">
                        <h2 class="text-xl font-semibold">Response ID: {{ $response->id }}</h2>

                        <div class="mt-4">
                            @foreach ($formattedAnswers as $answer)
                                <div class="mb-3">
                                    <strong>Question:</strong> {{ $answer['question_text'] }}<br>
                                    <strong>Answer:</strong> {{ $answer['answer'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-800 text-white rounded-md px-4 py-2 hover:bg-gray-700">Back to Dashboard</a>
    </div>
</body>
</html>
