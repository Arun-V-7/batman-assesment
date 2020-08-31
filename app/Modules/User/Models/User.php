<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $connection = 'mysql';

    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password',
        'remember_token ', 'status ', 'created_at', 'updated_at'
    ];

    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new User();
        return self::$instance;
    }
}
