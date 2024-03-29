<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'isCorrect', 'question_id'];

    protected $hidden = ['created_at', 'updated_at', 'isCorrect', 'question_id'];

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
