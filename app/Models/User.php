<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'teacher', 'student'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Check user role
    public function isAdmin() { return $this->role === 'admin'; }
    public function isTeacher() { return $this->role === 'teacher'; }
    public function isStudent() { return $this->role === 'student'; }

    // Relationships
    public function taughtClasses() {
        return $this->hasMany(ClassModel::class, 'teacher_id');
    }

    public function enrolledClasses() {
        return $this->belongsToMany(ClassModel::class, 'student_class', 'student_id', 'class_id');
    }

    public function grades() {
        return $this->hasMany(Grade::class, 'student_id');
    }
}