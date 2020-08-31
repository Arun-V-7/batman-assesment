<?php


namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getQuizResultDetails($sort,$sortType){
        try{
            $data = DB::table('quiz_result')
                ->join('users', 'users.id', '=', 'quiz_result.user_id')
                ->select('quiz_result.*', 'users.name')
                ->orderBy($sort,$sortType)
                ->get();
//            $data = QuizResult::orderBy($sort,$sortType)->get();
            return $data;
        }catch (\Exception $e){
            return 0;
        }
    }


}
