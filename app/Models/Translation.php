<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory;
    
    protected $fillable = ['key_name', 'value', 'language_id', 'tags'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
