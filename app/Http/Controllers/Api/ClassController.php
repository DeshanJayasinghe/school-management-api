<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        try {
            return ClassModel::with(['teacher', 'students'])->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch classes', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'teacher_id' => 'required|exists:users,id',
            ]);

            return ClassModel::create($request->only(['name', 'teacher_id']));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create class', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(ClassModel $class)
    {
        try {
            return $class->load(['teacher', 'students']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch class details', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, ClassModel $class)
    {
        try {
            $request->validate([
                'name' => 'sometimes|string',
                'teacher_id' => 'sometimes|exists:users,id',
            ]);

            $class->update($request->only(['name', 'teacher_id']));
            return $class;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update class', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(ClassModel $class)
    {
        try {
            $class->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete class', 'message' => $e->getMessage()], 500);
        }
    }

    public function enrollStudent(Request $request, ClassModel $class)
    {
        try {
            $request->validate(['student_id' => 'required|exists:users,id']);
            $class->students()->attach($request->student_id);
            return response()->json(['message' => 'Student enrolled']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to enroll student', 'message' => $e->getMessage()], 500);
        }
    }

    public function unenrollStudent(Request $request, ClassModel $class)
    {
        try {
            $request->validate(['student_id' => 'required|exists:users,id']);
            $class->students()->detach($request->student_id);
            return response()->json(['message' => 'Student unenrolled']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to unenroll student', 'message' => $e->getMessage()], 500);
        }
    }
}