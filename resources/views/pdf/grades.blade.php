<!DOCTYPE html>
<html>
<head>
    <title>Grades Report - {{ $student->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .student-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
        .na { color: #999; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Academic Grades Report</h1>
        <p>Generated on: {{ $date }}</p>
    </div>

    <div class="student-info">
        <h2>Student Information</h2>
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
    </div>

    <h2>Grades Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Class</th>
                <th>Teacher</th>
                <th>Grade</th>
                <th>Date Recorded</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $grade)
            <tr>
                <td>{{ $grade->class->name ?? '<span class="na">N/A</span>' }}</td>
                <td>{{ $grade->class->teacher->name ?? '<span class="na">N/A</span>' }}</td>
                <td>{{ $grade->grade }}</td>
                <td>{{ $grade->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">No grades found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Official School Document</p>
    </div>
</body>
</html>