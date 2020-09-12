<?php


namespace App\Modules\User\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Quiz;
use App\Modules\User\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboard(Request $request){

        $quizResultDetailInstance =  QuizResult::getInstance();
        $quizDetailInstance =  Quiz::getInstance();
        $quizResultDetailInstanceResponse = $quizResultDetailInstance->getQuizResultDetailById(Auth::user()->id);
        if ($quizResultDetailInstanceResponse){
            return view('User::dashboard',['correctScore'=>$quizResultDetailInstanceResponse->correct_count,'totalScore'=>$quizResultDetailInstanceResponse->total_score]);
        }else{
            $quizResponse = $quizDetailInstance->getQuizDetail();
            return view('User::dashboard',['quiz'=>$quizResponse,'totalQuiz'=>count($quizResponse)]);
        }

    }

    public function getQuizQuestions(Request $request){

        $quizDetailInstance =  Quiz::getInstance();
        $quizResultDetailInstance =  QuizResult::getInstance();
        $quizResponse = $quizDetailInstance->getQuizDetail();
        $quizResultDetailResponse = $quizResultDetailInstance->getQuizResultDetailById(Auth::user()->id);
        $div = '';
        $a = 1;
        if (!$quizResultDetailResponse){
            $div = '<div>
                        <h3>'.$a.')  '.$quizResponse[0]->question.'</h3>
                        <input type="radio" name="answer" value="'.$quizResponse[0]->option_a.'">'.$quizResponse[0]->option_a.'<br>
                        <input type="radio" name="answer" value="'.$quizResponse[0]->option_b.'">'.$quizResponse[0]->option_b.'<br>
                        <input type="radio" name="answer" value="'.$quizResponse[0]->option_c.'">'.$quizResponse[0]->option_c.'<br>
                        <input type="radio" name="answer" value="'.$quizResponse[0]->option_d.'">'.$quizResponse[0]->option_d.'<br>
                        <input type="hidden" id="mark" value="'.$quizResponse[0]->mark.'">
                        <input type="hidden" id="quiz_id" value="'.$quizResponse[0]->quiz_id.'"><hr>
                        <div class="align-right">
                        <img class="loading-gif hide" src="/assets/images/loding.gif">
                        <a onclick="getNextQuestion(1)">Next</a>
                        </div>
                    </div>';
            return (['code'=>200,'messageData'=>$div]);
        }

    }

    public function getNextQuestion(Request $request){
        $quizDetailInstance =  Quiz::getInstance();
        $quizResultDetailInstance =  QuizResult::getInstance();
        $quizFullResponse = $quizDetailInstance->getQuizDetail();
        $quizResponse = $quizDetailInstance->getQuizDetailById($request->quiz_id);
        $quizResultDetailResponse = $quizResultDetailInstance->getQuizResultDetailById(Auth::user()->id);
        $arr=[];
		$a = $request->questionNo + 1;
        $div = '<div>
                        <h3>'.$a.')  '.$quizFullResponse[$request->questionNo]->question.'</h3>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_a.'">'.$quizFullResponse[$request->questionNo]->option_a.'<br>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_b.'">'.$quizFullResponse[$request->questionNo]->option_b.'<br>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_c.'">'.$quizFullResponse[$request->questionNo]->option_c.'<br>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_d.'">'.$quizFullResponse[$request->questionNo]->option_d.'<br>
                        <input type="hidden" id="mark" value="'.$quizFullResponse[$request->questionNo]->mark.'">
                        <input type="hidden" id="quiz_id" value="'.$quizFullResponse[$request->questionNo]->quiz_id.'"><hr>
                        <div class="align-right">
                        <img class="loading-gif hide" src="/assets/images/loding.gif">
                        <a onclick="getNextQuestion('.$a.')">Next</a>
                        </div>
                    </div>';
        if (!$quizResultDetailResponse){
				$arr['user_id'] = Auth::user()->id;
                $arr['question_attended'] = $request->quiz_id;
				$arr['created_at'] = now();
                $arr['updated_at'] = now();
            if ($request->answer == $quizResponse->correct_answer){
                $arr['correct_count'] = $request->mark;
                $arr['wrong_count'] = 0;
            }else{
                $arr['correct_count'] = 0;
                $arr['wrong_count'] = $request->mark;
            }
			$insertResponse = $quizResultDetailInstance->insertQuizResult($arr);
            return (['code'=>200,'messageData'=>$div]);
        }
        else{
            $arr['updated_at'] = now();
            if ($request->answer == $quizResponse->correct_answer){
                $arr['correct_count'] = $quizResultDetailResponse->correct_count + $request->mark ;
            }else{
                $arr['wrong_count'] = $quizResultDetailResponse->wrong_count + $request->mark;
            }
            $updateResponse = $quizResultDetailInstance->updateQuizResult($arr,$quizResultDetailResponse->quiz_result_id);
            if ($request->questionNo != (count($quizFullResponse)-1)){
                return (['code'=>200,'messageData'=>$div]);
            }
            else{
                $div = '<div>
                        <h3>'.$a.')  '.$quizFullResponse[$request->questionNo]->question.'</h3>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_a.'">'.$quizFullResponse[$request->questionNo]->option_a.'<br>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_b.'">'.$quizFullResponse[$request->questionNo]->option_b.'<br>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_c.'">'.$quizFullResponse[$request->questionNo]->option_c.'<br>
                        <input type="radio" name="answer" value="'.$quizFullResponse[$request->questionNo]->option_d.'">'.$quizFullResponse[$request->questionNo]->option_d.'<br>
                        <input type="hidden" id="mark" value="'.$quizFullResponse[$request->questionNo]->mark.'">
                        <input type="hidden" id="quiz_id" value="'.$quizFullResponse[$request->questionNo]->quiz_id.'"><hr>
                        <div class="align-right">
                        <img class="loading-gif hide" src="/assets/images/loding.gif">
                        <a onclick="submitQuiz()">Submit</a>
                        </div>
                    </div>';
                return (['code'=>200,'messageData'=>$div]);
            }
        }
    }

    public function submitQuiz(Request $request){
        $quizDetailInstance =  Quiz::getInstance();
        $quizResultDetailInstance =  QuizResult::getInstance();
        $quizFullResponse = $quizDetailInstance->getQuizDetail();
        $quizResponse = $quizDetailInstance->getQuizDetailById($request->quiz_id);
        $quizResultDetailResponse = $quizResultDetailInstance->getQuizResultDetailById(Auth::user()->id);
        $arr=[];
        $div = '';
        if ($request->answer == $quizResponse->correct_answer){
            $arr['correct_count'] = $quizResultDetailResponse->correct_count + $request->mark ;
            $arr['total_score'] = $quizResultDetailResponse->correct_count +$quizResultDetailResponse->wrong_count + $request->mark ;
            $arr['updated_at'] = now();
            $updateResponse = $quizResultDetailInstance->updateQuizResult($arr,$quizResultDetailResponse->quiz_result_id);
            $div = '<div style="display: flex;">
                    <div class="col-md-6"><h3>Your Score</h3></div>
                    <div class="col-md-6">
                    <h3>'.$arr['correct_count'].'/'.$arr['total_score'].'</h3>
                    </div></div>';
        }else{
            $arr['wrong_count'] = $quizResultDetailResponse->wrong_count + $request->mark;
            $arr['total_score'] = $quizResultDetailResponse->correct_count +$quizResultDetailResponse->wrong_count + $request->mark ;
            $arr['updated_at'] = now();
            $updateResponse = $quizResultDetailInstance->updateQuizResult($arr,$quizResultDetailResponse->quiz_result_id);
            $div = '<div style="display: flex;">
                    <div class="col-md-6"><h3>Your Score</h3></div>
                    <div class="col-md-6">
                        <h3>'.$quizResultDetailResponse->correct_count.'/'.$arr['total_score'].'</h3>
                    </div></div>';
        }

        return (['code'=>200,'messageData'=>$div]);
    }

    public function submitQuizAnswer(Request $request){
		dd($request);
        $quizDetailInstance =  Quiz::getInstance();
        $quizResultDetailInstance =  QuizResult::getInstance();
        $quizFullResponse = $quizDetailInstance->getQuizDetail();
        $arr=[];
        $arr['user_id'] = Auth::user()->id;
        $arr['question_attended'] = count($quizFullResponse);
        $arr['created_at'] = now();
        $arr['updated_at'] = now();
        $correctAnswer = 0;$wrongAnswer = 0;$totalScore = 0;
        foreach ($quizFullResponse as $key => $value){
            if ($value->correct_answer===$request->answer[$key]){
                $correctAnswer = $correctAnswer+$value->mark;
            }
            else{
                $wrongAnswer = $wrongAnswer+$value->mark;
            }
            $totalScore = $totalScore+$value->mark;
        }
        $arr['total_score'] = $totalScore;
        $arr['correct_count'] = $correctAnswer;
        $arr['wrong_count'] = $wrongAnswer;
        $insertResponse = $quizResultDetailInstance->insertQuizResult($arr);
        if ($insertResponse){
            return (['code'=>200,'message'=>$arr]);
        }else{
            return (['code'=>400,'message'=>'Error while submiting Try again!']);
        }
    }


}
