<?php

namespace Elison\ProgressiveSeeder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeederHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
    ];
}
