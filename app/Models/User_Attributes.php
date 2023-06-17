<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Attributes extends Model
{
    use HasFactory;
    protected $table = "user_attributes";
    protected $fillable = [
        'user_id',
        'age',
        'mobile',
        'city',
        'country',
        'address',
        'address2',
        'last_visit_at',
        'last_visit_timezone_type',
        'last_visit_timezone',
        'credit',
        'gender'

        // 'attributes'
        ];
    //protected $casts = ['attributes' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
