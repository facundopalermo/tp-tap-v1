<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text'];
    
    protected $hidden = ['created_at', 'updated_at'];

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
