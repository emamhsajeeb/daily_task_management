<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NCR extends Model
{
    use HasFactory;

    protected $fillable = [
        'ncr_ref_no',
        'chainages',
        'description',
        'status',
        'remarks'
    ];
}
