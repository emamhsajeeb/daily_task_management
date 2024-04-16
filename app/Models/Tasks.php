<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'number',
        'type',
        'description',
        'location',
        'side',
        'qty_layer',
        'planned_time',
        'status',
        'incharge',
        'completion_time',
        'inspection_details',
        'resubmission_count',
        'resubmission_date',
        'rfi_submission_date',
        'author_id',
        'task_id',

    ];


    public function authors()
    {
        return $this->belongsToMany(Author::class, 'task_has_author', 'task_id', 'author_id');
    }

    public function ncrs()
    {
        return $this->belongsToMany(NCR::class, 'task_has_ncr', 'task_id','ncr_id');
    }
}
