<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
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
        .input-field {
            border-radius: 0.375rem;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            transition: border-color 0.3s ease-in-out;
        }
        .input-field:focus {
            border-color: #667eea;
        }
        .add-option-btn:hover, .submit-btn:hover, .add-question-btn:hover {
            background-color: #4c51bf;
        }
        .remove-question-btn {
            color: #e53e3e;
            font-size: 0.875rem;
            cursor: pointer;
        }
        .remove-option-btn {
            color: #e53e3e;
            font-size: 0.875rem;
            cursor: pointer;
            margin-left: 0.5rem;
        }
        .back-btn:hover {
            background-color: #e53e3e;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container max-w-3xl mx-auto p-8">
        <h2 class="text-4xl font-bold text-center text-indigo-600 mb-10">Create Your Survey</h2>

        <form id="survey-form" action="{{ route('survey.store') }}" method="POST" onsubmit="return validateSurvey()">
            @csrf
            
            <!-- Survey Name Input -->
            <div class="mb-8">
                <label for="survey_name" class="block text-xl font-medium text-gray-700 mb-2">Survey Name</label>
                <input type="text" name="survey_name" required class="input-field w-full focus:outline-none" placeholder="Enter survey name">
            </div>

            <div id="question-container" class="space-y-8">
                <div class="question p-4 bg-gray-50 rounded-lg shadow-md relative">
                    <label class="block text-lg font-medium text-gray-800">Question 1</label>
                    <input type="text" name="questions[0][question_text]" required class="input-field w-full mt-2" placeholder="Enter your question">
                    
                    <select name="questions[0][question_type]" class="input-field w-full mt-4" onchange="toggleOptions(this)">
                        <option value="dropdown">Dropdown</option>
                        <option value="rating">Rating</option>
                        <!-- <option value="text">Text</option> -->
                        <option value="checkbox">Checkboxes</option>
                        <option value="true-false">True/False</option>
                    </select>

                    <div class="options mt-4">
                        <label class="block text-md font-medium text-gray-700 mb-2">Options</label>
                        <div class="options-container space-y-2">
                            <div class="option-item flex items-center">
                                <input type="text" name="questions[0][options][]" class="input-field w-full mt-2" placeholder="Enter option 1">
                                <span class="remove-option-btn" onclick="removeOption(this)">Remove</span>
                            </div>
                            <div class="option-item flex items-center">
                                <input type="text" name="questions[0][options][]" class="input-field w-full mt-2" placeholder="Enter option 2">
                                <span class="remove-option-btn" onclick="removeOption(this)">Remove</span>
                            </div>
                        </div>
                        <button type="button" class="add-option-btn mt-4 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors" onclick="addOption(this, 0)">Add Option</button>
                    </div>

                    <!-- Remove Question Button -->
                    <span class="remove-question-btn absolute top-4 right-4" onclick="removeQuestion(this)">Remove</span>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <button type="button" onclick="addQuestion()" class="add-question-btn bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition-colors">Add Another Question</button>
                <button type="submit" class="submit-btn bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors">Submit Survey</button>
            </div>
        </form>

        <!-- Back to Dashboard Button -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('dashboard') }}" class="back-btn bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600 transition-colors">Back to Dashboard</a>
        </div>
    </div>

    <script>
        function addQuestion() {
            const container = document.getElementById('question-container');
            const questionCount = container.children.length;
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question', 'p-4', 'bg-gray-50', 'rounded-lg', 'shadow-md', 'relative');
            newQuestion.innerHTML = `
                <label class="block text-lg font-medium text-gray-800">Question ${questionCount + 1}</label>
                <input type="text" name="questions[${questionCount}][question_text]" required class="input-field w-full mt-2" placeholder="Enter your question">
                <select name="questions[${questionCount}][question_type]" class="input-field w-full mt-4" onchange="toggleOptions(this)">
                    <option value="dropdown">Dropdown</option>
                    <option value="rating">Rating</option>
                    // <option value="text">Text</option>
                    <option value="checkbox">Checkboxes</option>
                    <option value="true-false">True/False</option>
                </select>
                <div class="options mt-4">
                    <label class="block text-md font-medium text-gray-700 mb-2">Options</label>
                    <div class="options-container space-y-2">
                        <div class="option-item flex items-center">
                            <input type="text" name="questions[${questionCount}][options][]" class="input-field w-full mt-2" placeholder="Enter option 1">
                            <span class="remove-option-btn" onclick="removeOption(this)">Remove</span>
                        </div>
                        <div class="option-item flex items-center">
                            <input type="text" name="questions[${questionCount}][options][]" class="input-field w-full mt-2" placeholder="Enter option 2">
                            <span class="remove-option-btn" onclick="removeOption(this)">Remove</span>
                        </div>
                    </div>
                    <button type="button" class="add-option-btn mt-4 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors" onclick="addOption(this, ${questionCount})">Add Option</button>
                </div>
                <span class="remove-question-btn absolute top-4 right-4" onclick="removeQuestion(this)">Remove</span>
            `;
            container.appendChild(newQuestion);
            newQuestion.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function toggleOptions(selectElement) {
            const optionsDiv = selectElement.nextElementSibling;
            if (selectElement.value === 'dropdown' || selectElement.value === 'checkbox') {
                optionsDiv.style.display = 'block';
            } else {
                optionsDiv.style.display = 'none';
                // Clear the input fields in options if the question type is not option-based
                const inputs = optionsDiv.querySelectorAll('input');
                inputs.forEach(input => input.value = '');
            }
        }

        function addOption(button, questionIndex) {
            const optionsContainer = button.previousElementSibling;
            const optionCount = optionsContainer.children.length + 1;
            const optionItem = document.createElement('div');
            optionItem.classList.add('option-item', 'flex', 'items-center');
            optionItem.innerHTML = `
                <input type="text" name="questions[${questionIndex}][options][]" class="input-field w-full mt-2" placeholder="Enter option ${optionCount}">
                <span class="remove-option-btn" onclick="removeOption(this)">Remove</span>
            `;
            optionsContainer.appendChild(optionItem);
        }

        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            optionItem.remove();
        }

        function removeQuestion(button) {
            const question = button.closest('.question');
            question.remove();
        }

        function validateSurvey() {
            const questions = document.querySelectorAll('.question');
            if (questions.length < 1) {
                alert('You must have at least one question.');
                return false;
            }
            for (let question of questions) {
                const questionType = question.querySelector('select[name$="[question_type]"]').value;
                const options = question.querySelectorAll('input[name^="questions"][name$="[options][]"]');

                // Only check options for Dropdown and Checkbox question types
                if (questionType === 'dropdown' || questionType === 'checkbox') {
                    for (let option of options) {
                        if (option.value.trim() === '') {
                            alert('All option fields must be filled for Dropdown and Checkbox questions.');
                            return false;
                        }
                    }
                }
            }
            return true;
        }
    </script>
</body>
</html>
 