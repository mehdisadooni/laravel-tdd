<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const NOT_STARTED = 'not_started';
    const STARTED = 'started';
    const PENDING = 'pending';

    protected $guarded = [];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
