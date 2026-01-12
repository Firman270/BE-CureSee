<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;

    protected $table = 'skin_analyses';
    protected $primaryKey = 'analyses_id';

    protected $fillable = [
        'user_id',
        'image_url',
        'result_text',
        'confidence_score',
    ];

    /**
     * ANALYSIS → BELONGS TO USER
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}