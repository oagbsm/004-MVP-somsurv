<?php

namespace App\Http\Controllers;
use App\Models\Survey; 
use App\Models\Response; // Import the Survey model
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{




    
//USERS
public function show($id)
{
    // Retrieve the survey by ID or fail if not found
    $survey = Survey::findOrFail($id); 
    
    // Assuming you store questions and options as JSON
    $questions = json_decode($survey->questions); // Decode questions from JSON
    $cleanedOptions = explode(',', $survey->options); // Split the options into an array

    // Pass the survey data to the view
    return view('user.survey_detail', [
        'survey' => $survey,
        'questions' => $questions, // Pass questions to the view
        'cleanedOptions' => $cleanedOptions, // Pass all options to the view
    ]);
}
public function submitAnswers(Request $request)
{
    $userId = $request->user()->id; // Get the user ID

    $surveyId = $request->input('survey_id'); // Get the survey ID

    // Get the answers array from the request
    $answers = $request->input('answers'); // This will be an array of answers with question texts

    // Prepare an array to store the formatted answers
    $formattedAnswers = [];

    // Iterate through each answer
    foreach ($answers as $index => $data) {
        // Get the corresponding question text
        $questionText = $data['question_text'] ?? 'Unknown Question';

        // If the answer is an array (for checkboxes), convert it to a string
        $answer = $data['answer'];
        if (is_array($answer)) {
            $answer = implode(',', $answer); // Join checkbox answers with commas
        }

        // Store the question index, question text, and answer in the formatted answers array
        $formattedAnswers[] = [
            'question_index' => $index,
            'question_text' => $questionText,
            'answer' => $answer,
        ];
    }

    $formattedAnswersJson = json_encode($formattedAnswers); // Encode the formatted answers to JSON

    // Save the formatted answers to the survey_responses table
    $response = new Response();
    $response->survey_id = $surveyId;
    $response->user_id = $userId;
    $response->formatted_answers = $formattedAnswersJson; // Store JSON
    $response->save();

    // Flash a success message and redirect
    Session::flash('alert', 'Your action was successful! Please wait 1 hr while your credits are being verified.');
    return redirect()->route('dashboard'); // Assuming 'dashboard' is the name of the route for '/user'
}

public function userviewsurvey(){
    $userId = auth()->id(); // or any other method to retrieve user ID

    // Retrieve all surveys (modify this according to your survey model)
    $surveys = DB::table('surveys')->get(); // Assuming you have a 'surveys' table

    // Count the number of completed responses for the user
    $completedCount = DB::table('responses')
        ->where('user_id', $userId)
        ->count();



    $surveys = Survey::all();
    $completedSurveyIds = Response::where('user_id', $userId)
    ->pluck('survey_id')
    ->toArray();
        // dd($completedSurveyIds);
        $completedSurveyIds = Response::where('user_id', $userId)
        ->pluck('survey_id')
        ->toArray();

    // Fetch surveys that the user has not completed
    $surveys = Survey::whereNotIn('id', $completedSurveyIds)->get();

    // Pass the surveys to the 'surveys.index' view
        return view('user.dashboard', [
            'surveys' => $surveys,
            'completedCount' => $completedCount,
        ]);    // Pass the surveys to the 'surveys.index' view
    // dd($surveys);

}
//--------------------------------------------8-8-8-8-8--8-8-8----------------BUSINESS


public function viewsurveydetail($id)
{
    $survey = Survey::findOrFail($id);
    return view('business.view-survey-detail', compact('survey'));
}

public function analytics()
{
    $userId = Auth::id();
    
    // Fetch surveys created by the user
    $surveys = Survey::where('user_id', $userId)->get();
    
    // Prepare an array to store analytics data
    $analytics = [];

    // Process each survey
    foreach ($surveys as $survey) {
        // Fetch responses for each survey
        $responses = Response::where('survey_id', $survey->id)->get();

        // Initialize analytics for each survey
        $analytics[$survey->id] = [
            'survey_name' => $survey->survey_name,
            'responses_count' => $responses->count(), // Directly count responses
            'questions' => [],
        ];

        // Process each response
        foreach ($responses as $response) {
            $formattedAnswers = json_decode($response->formatted_answers, true); // Decode JSON
            
            // Process each answer in the response
            foreach ($formattedAnswers as $answer) {
                $questionIndex = $answer['question_index'];
                $questionText = $answer['question_text'];
                $userAnswer = $answer['answer'];

                // Initialize analytics for each question if not already set
                if (!isset($analytics[$survey->id]['questions'][$questionIndex])) {
                    $analytics[$survey->id]['questions'][$questionIndex] = [
                        'question_text' => $questionText,
                        'answers' => [],
                        'total_responses' => 0, // Initialize total_responses
                    ];
                }

                // Store the answer and increment the total responses count for the question
                $analytics[$survey->id]['questions'][$questionIndex]['answers'][] = $userAnswer;
                $analytics[$survey->id]['questions'][$questionIndex]['total_responses']++;
            }
        }
    }

    // Pass the analytics data to the view
    return view('business.view-analytics', compact('surveys', 'analytics'));
}



public function showResponses($id)
{
    // Fetch the survey by ID
    $survey = Survey::findOrFail($id);
    
    // Get the survey name
    $surveyName = $survey->survey_name;

    // Fetch responses for the survey
    $responses = Response::where('survey_id', $id)->get();

    // Pass the survey name and responses to the view
    return view('business.survey-responses', compact('surveyName', 'responses'));
}



public function viewResponses($surveyId)
{
    // Fetch responses for the survey
    $responses = Response::where('survey_id', $surveyId)->get();

    // Return view with responses (create a new view if necessary)
    return view('business.survey-responses', compact('responses'));
}




public function destroy($id)
{
    // Retrieve the survey by its ID
    $survey = Survey::findOrFail($id);

    // Delete the survey
    $survey->delete();

    // Redirect back to the surveys list with a success message
    return redirect()->back()->with('success', 'Survey deleted successfully.');
}

    public function create()
    {
                // Get the currently authenticated user
        return view('business.create-survey');
    }
    public function viewsurvey()
    {
                // Get the currently authenticated user
              $surveys = Survey::where('user_id', Auth::id())->get();

        // Return the view with survey data
        return view('business.view-survey', compact('surveys'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'survey_name' => 'required|string|max:255', // Validate the survey name
            'questions.*.question_text' => 'required|string|max:255', // Validate each question text
            'questions.*.question_type' => 'required|string|in:text,rating,dropdown,checkbox,true-false', // Validate question types
            'questions.*.options' => 'nullable|array|max:3', // Validate options, if provided
            'questions.*.options.*' => 'nullable|string|max:255', // Validate each option text
        ]);
    
        // Retrieve the authenticated user's ID
        $userId = Auth::id();
    
        // Prepare questions data
        $questions = $request->input('questions');
    
        // Create a new survey entry in the database
        $survey = Survey::create([
            'survey_name' => $request->input('survey_name'),
            'user_id' => $userId,
            'questions' => json_encode($questions), // Store the questions as JSON
        ]);
    
        // Display a success message or redirect as needed
        return redirect()->route('business')->with('success', 'Survey created successfully.');
    }
    

    
    
        
}
