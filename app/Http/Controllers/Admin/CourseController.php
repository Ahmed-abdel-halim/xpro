<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function destroy(Course $course)
    {
        // Delete course thumbnail if exists
        if ($course->thumbnail && file_exists(public_path('storage/' . $course->thumbnail))) {
            unlink(public_path('storage/' . $course->thumbnail));
        }

        $course->delete();

        return back()->with('success', 'تم حذف الكورس بنجاح');
    }
}
