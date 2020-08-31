<?php


namespace App\Modules\User\Models;


use App\Modules\Admin\Models\Quiz;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $table = 'quiz_result';
    protected $primaryKey = 'quiz_result_id';

    protected $connection = 'mysql';

    protected $fillable = [
        'user_id', 'question_attended', 'correct_count', 'wrong_count', 'total_score', 'created_at', 'updated_at'
    ];

    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new QuizResult();
        return self::$instance;
    }

    public function getQuizResultDetailById($id){
        try{
            $data = QuizResult::where('user_id',$id)->first();
            return $data;
        }catch (\Exception $e){
            return 0;
        }
    }

    public function insertQuizResult($data){
        try{
            return QuizResult::insert($data);
        }catch (\Exception $e){
            return false;
        }
    }

    public function UpdateQuizResult($data,$id){
        try{
            return QuizResult::where('quiz_result_id', $id)->update($data);
        }catch (\Exception $e){
            return false;
        }
    }

}
