<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = ['name', 'teacher_id'];

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students() {
        return $this->belongsToMany(User::class, 'student_class', 'class_id', 'student_id');
    }

    public function grades() {
        return $this->hasMany(Grade::class, 'class_id');
    }
}