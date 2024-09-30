<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->survey_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .button {
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #1d4ed8;
        }
        .star {
            cursor: pointer;
            color: #d1d5db; /* Gray color */
            font-size: 2rem; /* Size of the stars */
        }
        .star.checked {
            color: #fbbf24; /* Yellow color */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-white mb-6 text-center">{{ $survey->survey_name }}</h1>
        <div class="card p-6">
            <form action="{{ route('survey.submit', $survey->id) }}" method="POST" id="surveyForm">
                @csrf

                <!-- Hidden input for the survey ID -->
                <input type="hidden" name="survey_id" value="{{ $survey->id }}">

                @foreach (json_decode($survey->questions) as $index => $question)
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">{{ $question->question_text }}</label>

                        {{-- Handle question types --}}
                        @switch($question->question_type)
                            @case('text')
                                <input type="text" name="answers[{{ $index }}][answer]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" placeholder="Your answer" required>
                                <input type="hidden" name="answers[{{ $index }}][question_text]" value="{{ $question->question_text }}">
                                @break

                            @case('rating')
                                <div class="flex items-center mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="answers[{{ $index }}][answer]" value="{{ $i }}" id="rating-{{ $index }}-{{ $i }}" class="hidden rating" required>
                                        <label for="rating-{{ $index }}-{{ $i }}" class="star" onclick="highlightStars(this, {{ $i }})">&#9733;</label>
                                    @endfor
                                    <input type="hidden" name="answers[{{ $index }}][question_text]" value="{{ $question->question_text }}">
                                </div>
                                @break

                            @case('dropdown')
                                <select name="answers[{{ $index }}][answer]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" required>
                                    <option value="" disabled selected>Select an option</option>
                                    @foreach ($question->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="answers[{{ $index }}][question_text]" value="{{ $question->question_text }}">
                                @break

                            @case('checkbox')
                                @foreach ($question->options as $option)
                                    <div class="mt-2">
                                        <input type="checkbox" name="answers[{{ $index }}][answer][]" value="{{ $option }}" id="option-{{ $index }}-{{ $loop->index }}" class="mr-2">
                                        <label for="option-{{ $index }}-{{ $loop->index }}">{{ $option }}</label>
                                    </div>
                                @endforeach
                                <input type="hidden" name="answers[{{ $index }}][question_text]" value="{{ $question->question_text }}">
                                @break

                            @case('true-false')
                                <div class="mt-2">
                                    <input type="radio" name="answers[{{ $index }}][answer]" value="true" id="true-{{ $index }}" required class="mr-2">
                                    <label for="true-{{ $index }}">True</label>
                                </div>
                                <div class="mt-2">
                                    <input type="radio" name="answers[{{ $index }}][answer]" value="false" id="false-{{ $index }}" required class="mr-2">
                                    <label for="false-{{ $index }}">False</label>
                                </div>
                                <input type="hidden" name="answers[{{ $index }}][question_text]" value="{{ $question->question_text }}">
                                @break

                            @default
                                <p class="text-red-600">Invalid question type.</p>
                        @endswitch
                    </div>
                @endforeach

                <button type="submit" class="button bg-blue-500 text-white py-2 px-4 rounded w-full">Submit Answers</button>
            </form>
        </div>
    </div>

    <script>
        function highlightStars(star, count) {
            // Clear previous selections
            const stars = star.parentNode.querySelectorAll('.star');
            stars.forEach((s, index) => {
                if (index < count) {
                    s.classList.add('checked');
                } else {
                    s.classList.remove('checked');
                }
            });

            // Set the corresponding radio button checked
            const radioButton = star.parentNode.querySelector(`input[value="${count}"]`);
            radioButton.checked = true;
        }

        document.getElementById('surveyForm').addEventListener('submit', function (e) {
            let valid = true;  // Flag to track if form is valid
            const unansweredQuestions = [];

            // Validate all required inputs (text, rating, dropdown, true/false)
            this.querySelectorAll('input[required], select[required]').forEach((element) => {
                if (!element.value) {
                    unansweredQuestions.push(element);
                    valid = false;
                }
            });

            // Validate that at least one checkbox is selected per checkbox question
            const checkboxGroups = document.querySelectorAll('[name^="answers["][name$="][answer][]"]');
            let checkboxGroupValid = true;
            checkboxGroups.forEach((checkbox) => {
                const questionIndex = checkbox.name.match(/answers\[(\d+)\]/)[1];
                const checkboxes = document.querySelectorAll(`input[name="answers[${questionIndex}][answer][]"]`);
                const isAnyChecked = Array.from(checkboxes).some((checkbox) => checkbox.checked);

                if (!isAnyChecked) {
                    unansweredQuestions.push(checkbox);
                    checkboxGroupValid = false;
                }
            });

            if (!checkboxGroupValid || !valid) {
                e.preventDefault();  // Prevent form submission if any validation fails
                alert('Please complete the entire survey and select at least one checkbox for checkbox questions.');
            }
        });
    </script>
</body>
</html>
