<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Author extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    public function tasks()
    {
        return $this->belongsToMany(Tasks::class, 'task_has_author', 'author_id', 'task_id');
    }
}
