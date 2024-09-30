<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->survey_name }} - Survey Responses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-5xl font-bold text-gray-800 mb-8">{{ $survey->survey_name }}</h1>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Survey Responses</h2>

            @if (empty($questionAnswers))
                <p class="mt-4 text-gray-600">No responses available for this survey yet.</p>
            @else
                <p class="mt-4 text-gray-600">
                    Total Responses: <span class="font-bold">{{ $responses->count() }}</span>
                </p>

                @foreach ($questionAnswers as $questionIndex => $question)
                    <div class="mt-4 border-b pb-4">
                        <h3 class="text-lg font-semibold text-gray-700">{{ $question['question_text'] }}</h3>
                        <p class="text-gray-500 italic">Question Type: {{ ucfirst($question['question_type']) }}</p> <!-- Display question type -->
                        
                        @if ($question['question_type'] === 'rating' && isset($question['average_rating']))
                            <p class="text-gray-600">Average Rating: <span class="font-bold">{{ number_format($question['average_rating'], 2) }}</span></p>
                        @elseif ($question['question_type'] === 'true-false')
                            @php
                                $trueCount = isset($question['answers']) ? count(array_filter($question['answers'], fn($answer) => $answer === 'true')) : 0;
                                $falseCount = isset($question['answers']) ? count(array_filter($question['answers'], fn($answer) => $answer === 'false')) : 0;
                                $totalCount = $trueCount + $falseCount;
                                $truePercentage = $totalCount > 0 ? ($trueCount / $totalCount) * 100 : 0;
                                $falsePercentage = $totalCount > 0 ? ($falseCount / $totalCount) * 100 : 0;
                            @endphp

                            <p class="text-gray-600">True: <span class="font-bold">{{ number_format($truePercentage, 2) }}%</span></p>
                            <p class="text-gray-600">False: <span class="font-bold">{{ number_format($falsePercentage, 2) }}%</span></p>
                        @elseif ($question['question_type'] === 'dropdown' || $question['question_type'] === 'checkbox')
                            @php
                                // Count unique responses and their occurrences
                                $responseCount = [];
                                foreach ($question['answers'] as $answer) {
                                    // For checkbox, each answer may contain multiple selections, split them
                                    if ($question['question_type'] === 'checkbox') {
                                        $answersArray = explode(',', $answer); // Assuming answers are comma-separated
                                        foreach ($answersArray as $option) {
                                            $option = trim($option); // Trim whitespace
                                            if (isset($responseCount[$option])) {
                                                $responseCount[$option]++;
                                            } else {
                                                $responseCount[$option] = 1;
                                            }
                                        }
                                    } else {
                                        // For dropdown, count directly
                                        if (isset($responseCount[$answer])) {
                                            $responseCount[$answer]++;
                                        } else {
                                            $responseCount[$answer] = 1;
                                        }
                                    }
                                }

                                // Calculate the total responses for percentage calculation
                                $totalResponses = count($responses);
                            @endphp

                            <ul class="list-disc pl-6">
                                @if ($totalResponses === 0)
                                    <li>No answers for this question.</li>
                                @else
                                    @foreach ($responseCount as $option => $count)
                                        <li class="text-gray-600">
                                            {{ $option }}: <span class="font-bold">{{ $count }}</span> 
                                            ({{ number_format(($count / $totalResponses) * 100, 2) }}%)
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @else
                            <ul class="list-disc pl-6">
                                @if (empty($question['answers']))
                                    <li>No answers for this question.</li>
                                @else
                                    @foreach ($question['answers'] as $answer)
                                        <li class="text-gray-600">{{ $answer }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="inline-block bg-gray-800 text-white rounded-md px-4 py-2 hover:bg-gray-700">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
