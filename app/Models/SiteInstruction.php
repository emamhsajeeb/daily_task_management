<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'si_ref_no',
        'chainages',
        'description',
        'status',
        'remarks'
    ];
}
