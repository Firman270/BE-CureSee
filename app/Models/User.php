<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
<<<<<<< HEAD
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
=======
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

>>>>>>> 5c6469d (push kode awal)
    protected $fillable = [
        'firebase_uid',
        'email',
        'password',
        'name',
        'username',
        'role',
        'gender',
        'age',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    /* ================= RELATIONS ================= */

    // USER → banyak skin analyses
    public function skinAnalyses()
    {
        return $this->hasMany(SkinAnalysis::class, 'user_id', 'id');
    }

    // ADMIN → banyak blogs
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'admin_id', 'id');
    }

    /* ================= ROLE CHECK ================= */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
