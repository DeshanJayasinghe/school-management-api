<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'class_id', 'grade'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function class() {
        return $this->belongsTo(ClassModel::class)->withDefault([
        'name' => 'Deleted Class',
        'teacher' => new User(['name' => 'N/A'])
    ]);
    }
}