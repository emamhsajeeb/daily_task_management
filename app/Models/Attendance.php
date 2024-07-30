<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'punchin',
        'punchout',
        'punchin_location',
        'punchout_location',
        'symbol'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
