<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;



class GradeController extends Controller
{
    public function index()
    {
        try {
            return Grade::with(['student', 'class'])->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch grades', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:users,id',
                'class_id' => 'required|exists:classes,id',
                'grade' => 'required|string|max:10',
            ]);

            return Grade::create($request->only(['student_id', 'class_id', 'grade']));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create grade', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Grade $grade)
    {
        try {
            return $grade->load(['student', 'class']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch grade', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Grade $grade)
    {
        try {
            $request->validate([
                'grade' => 'required|string|max:10',
            ]);

            $grade->update($request->only(['grade']));
            return $grade;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update grade', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete grade', 'message' => $e->getMessage()], 500);
        }
    }
    

   
    
}