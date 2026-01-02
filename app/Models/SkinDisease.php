<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkinDisease extends Model
{
    use HasFactory;

    protected $table = 'skin_diseases';
    protected $primaryKey = 'disease_id';

    protected $fillable = [
        'disease_name',
        'description',
        'recommended_action',
    ];

    /**
     * DISEASE → MANY ANALYSES
     */
    public function skinAnalyses()
    {
        return $this->hasMany(SkinAnalysis::class, 'disease_id', 'disease_id');
    }
}
