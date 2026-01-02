<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkinAnalysis extends Model
{
    use HasFactory;

    protected $table = 'skin_analyses';
    protected $primaryKey = 'analyses_id';

    protected $fillable = [
        'user_id',
        'disease_id',
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

    /**
     * ANALYSIS → BELONGS TO DISEASE
     */
    public function disease()
    {
        return $this->belongsTo(SkinDisease::class, 'disease_id');
    }
}
