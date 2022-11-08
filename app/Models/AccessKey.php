<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessKey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'key'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        return $query->whereDate('created_at' , '=', Carbon::today())->whereTime('created_at' , '>',Carbon::now()->subHours(1));

    }
}
