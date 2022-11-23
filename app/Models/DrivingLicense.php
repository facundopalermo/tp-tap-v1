<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingLicense extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Método que genera la licencia mediante hash md5
     */
    public function generate(): string|null {

        if( $this->key == null ||
            $this->nota == null ||
            $this->visiontest == null ||
            $this->created_at == null
        ){return null;}

        if($this->license == null) {

            $this->generadapor = auth()->user()->id;
            $str = $this->id . $this->key . $this->nota . $this->created_at;
            $this->license = hash('md5', $str);
            $this->save();
        }

        return $this->license;
    }
}
