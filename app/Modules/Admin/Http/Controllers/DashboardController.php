<?php


namespace App\Modules\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Quiz;
use App\Modules\Admin\Models\QuizResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function dashboard(Request $request){

        $quizDetailInstance =  Quiz::getInstance();
        $quizDetailInstanceResponse = $quizDetailInstance->getQuizDetail();

        return view('Admin::dashboard');

    }

    public function dataSource(){
        $sort = "question";
        $sortType = 'asc';
        if (isset($_GET['sortType'])) {
            if ($_GET['sortType'] == 'asc' || $_GET['sortType'] == 'desc') {
                $sortType = $_GET['sortType'];
            }
        }

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $quizDetailInstance =  Quiz::getInstance();
        $data = $quizDetailInstance->getQuizDetails($sort, $sortType);

        return (['data'=>$data]);
    }

    public function resultDataSource(){
        $sort = "quiz_result.correct_count";
        $sortType = 'asc';
        if (isset($_GET['sortType'])) {
            if ($_GET['sortType'] == 'asc' || $_GET['sortType'] == 'desc') {
                $sortType = $_GET['sortType'];
            }
        }

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $quizDetailInstance =  QuizResult::getInstance();
        $data = $quizDetailInstance->getQuizResultDetails($sort, $sortType);

        return (['data'=>$data]);
    }

    public function inputQuestion(Request $request){

        $quizDetailInstance = Quiz::getInstance();
        $response = $quizDetailInstance->insertQuiz($request->toArray());

        if ($response){
            return (['code'=>200,'message'=>"Quiz Inserted Successfully"]);
        }
        else{
            return (['code'=>400,'message'=>"Error occur while uploading. Try again later!"]);
        }
    }

}
