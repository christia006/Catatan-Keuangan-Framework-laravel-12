<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todos';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'user_id', 'title', 'description', 'cover', 'is_finished'
    ];

    public $timestamps = true;
}
