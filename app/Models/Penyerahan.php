<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyerahan extends Model
{
    use HasFactory;
    protected $table = 'penyerahan';
    protected $casts = [
        'pasal' => 'array'
    ];
    public $timestamps = false;
}
