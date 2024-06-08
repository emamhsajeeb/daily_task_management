<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class NCR extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'ncr_no',
        'ref_no',
        'ncr_type',
        'issue_date',
        'chainages',
        'details',
        'status',
        'remarks'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Tasks::class, 'task_has_ncr', 'ncr_id', 'task_id');
    }
}
