<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Details - {{ $survey->survey_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .question-item {
            padding: 1rem;
            border-radius: 0.375rem;
            background-color: #f9fafb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        h1, h2 {
            font-family: 'Inter', sans-serif;
        }
        a.back-btn {
            transition: background-color 0.3s ease-in-out;
        }
        a.back-btn:hover {
            background-color: #e53e3e;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-8">
    <!-- Survey Header -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h1 class="text-4xl font-bold text-indigo-600 mb-4">{{ $survey->survey_name }}</h1>
        <p class="text-lg text-gray-600">Survey ID: {{ $survey->id }}</p>
        <p class="text-lg text-gray-600">Created by User ID: {{ $survey->user_id }}</p>
    </div>

    <!-- Survey Questions Section -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-indigo-600 mb-6">Survey Questions</h2>
        <div class="space-y-4">
            @foreach (json_decode($survey->questions) as $index => $question)
                <div class="question-item">
                    <span class="text-xl font-medium text-gray-800">Q{{ $index + 1 }}:</span>
                    <span class="text-lg text-gray-700">{{ htmlspecialchars($question->question_text) }}</span>

                    <div class="mt-2">
                        <span class="text-lg font-medium text-gray-700">Type:</span>
                        <span class="text-gray-800">{{ ucfirst($question->question_type) }}</span>
                    </div>

                    <div class="mt-2">
                        <span class="text-lg font-medium text-gray-700">Options:</span>
                        <ul class="list-disc ml-5 text-gray-800">
                            @if ($question->question_type === 'true-false')
                                <li>True</li>
                                <li>False</li>
                            @else
                                @foreach ($question->options as $option)
                                    <li>{{ htmlspecialchars($option) }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex justify-start">
        <a href="/business/viewsurvey" class="back-btn inline-block bg-red-500 text-white rounded-lg px-6 py-3 hover:bg-red-600">Back to Surveys</a>
    </div>
</div>

</body>
</html>
