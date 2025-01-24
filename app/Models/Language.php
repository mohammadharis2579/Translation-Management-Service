<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    
    use HasFactory;
    
    protected $fillable = ['locale', 'name'];

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
