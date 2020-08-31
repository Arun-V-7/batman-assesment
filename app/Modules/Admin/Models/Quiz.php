<?php


namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz';
    protected $primaryKey = 'quiz_id';

    protected $connection = 'mysql';

    protected $fillable = [
        'question', 'option_a', 'option_b', 'option_c',
        'option_d ', 'correct_answer ', 'mark ', 'created_at', 'updated_at'
    ];

    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new Quiz();
        return self::$instance;
    }

    public function getQuizDetail(){
        try{
            $data = Quiz::get();
            return $data;
        }catch (\Exception $e){
            return 0;
        }
    }

    public function getQuizDetailById($id){
        try{
            $data = Quiz::where('quiz_id',$id)->first();
            return $data;
        }catch (\Exception $e){
            return 0;
        }
    }

    public function getQuizDetails($sort,$sortType){
        try{
            $data = Quiz::orderBy($sort,$sortType)->get();
            return $data;
        }catch (\Exception $e){
            return 0;
        }
    }

    public function insertQuiz($data){
        try{
            return Quiz::insert($data);
        }catch (\Exception $e){
            return false;
        }
    }

}
