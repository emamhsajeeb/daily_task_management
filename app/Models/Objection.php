<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    protected $fillable = [
        'obj_no',
        'ref_no',
        'obj_type',
        'issue_date',
        'chainages',
        'details',
        'status',
        'remarks'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Tasks::class, 'task_has_objection', 'obj_id', 'task_id');
    }
}
