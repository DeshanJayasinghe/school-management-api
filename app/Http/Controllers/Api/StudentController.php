<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class StudentController extends Controller
{
    /**
     * Get authenticated student's enrolled classes
     */
    public function getMyClasses(Request $request)
    {
        try {
            $classes = $request->user()
                ->enrolledClasses()
                ->with(['teacher:id,name', 'grades' => function($q) use ($request) {
                    $q->where('student_id', $request->user()->id);
                }])
                ->get();

            return response()->json([
                'success' => true,
                'classes' => $classes
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch classes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated student's grades
     */
    public function getMyGrades(Request $request)
    {
        try {
            $grades = $request->user()
                ->grades()
                ->with(['class:id,name', 'class.teacher:id,name'])
                ->get();

            return response()->json([
                'success' => true,
                'grades' => $grades
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch grades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function exportGradesPdf(Request $request)
{
    try {
        $student = $request->user();
        
        // Load grades with class and teacher, handling potential nulls
        $grades = $student->grades()
            ->with(['class.teacher'])
            ->get()
            ->map(function ($grade) {
                // Ensure class exists, otherwise create dummy data
                if (!$grade->class) {
                    $grade->class = new \App\Models\ClassModel([
                        'name' => 'Deleted Class',
                        'teacher' => new \App\Models\User(['name' => 'N/A'])
                    ]);
                }
                // Ensure teacher exists
                elseif (!$grade->class->teacher) {
                    $grade->class->teacher = new \App\Models\User(['name' => 'N/A']);
                }
                return $grade;
            });

        if ($grades->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No grades found to export'
            ], 404);
        }

        $data = [
            'student' => $student,
            'grades' => $grades,
            'date' => now()->format('F j, Y')
        ];

        $pdf = Pdf::loadView('pdf.grades', $data);
        return $pdf->download("{$student->name}_grades_report.pdf");

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate PDF',
            'error' => $e->getMessage()
        ], 500);
    }
}
}