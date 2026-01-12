<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
    'admin_id',
    'title',
    'content',
    'image',
];


    /**
     * BLOG → BELONGS TO ADMIN
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
