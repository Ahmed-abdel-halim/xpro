<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonVideoController extends Controller
{
    /** عرض دروس مادة معينة مع إمكانية رفع الفيديوهات */
    public function index(Subject $subject)
    {
        $subject->load(['grade.stage']);
        $courses  = $subject->courses()->with(['teacher', 'lessons'])->get();
        $teachers = \App\Models\User::where('role', 'teacher')->orderBy('name')->get();

        return view('admin.lessons.videos', compact('subject', 'courses', 'teachers'));
    }

    /** إضافة فيديو / درس لمدرس معين */
    public function storeForTeacher(Request $request, Subject $subject)
    {
        $request->validate([
            'teacher_id'   => 'required|exists:users,id',
            'course_title' => 'nullable|string|max:255',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'video'        => 'nullable|file|mimetypes:video/mp4,video/avi,video/quicktime,video/webm|max:512000',
            'video_url'    => 'nullable|url',
            'is_free'      => 'nullable|boolean',
        ]);

        $teacher = \App\Models\User::findOrFail($request->teacher_id);

        // جلب أو إنشاء كورس لهذا المدرس في هذه المادة
        $courseTitle = $request->filled('course_title')
            ? $request->course_title
            : ('دورة ' . $subject->name . ' - ' . $teacher->name);

        $course = Course::firstOrCreate(
            [
                'teacher_id' => $teacher->id,
                'subject_id' => $subject->id,
            ],
            [
                'title'       => $courseTitle,
                'description' => 'شرح مادة ' . $subject->name,
                'price'       => 0,
            ]
        );

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
        }

        $order = $course->lessons()->max('order') + 1;

        $course->lessons()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'video_url'   => $request->video_url ?? '',
            'video_path'  => $videoPath,
            'is_free'     => $request->boolean('is_free'),
            'order'       => $order,
        ]);

        return back()->with('success', 'تم إضافة الدرس بنجاح للأستاذ ' . $teacher->name . ' في مادة ' . $subject->name);
    }

    /** رفع فيديو لدرس معين */
    public function upload(Request $request, Lesson $lesson)
    {
        $request->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/avi,video/quicktime,video/webm|max:512000', // 500MB
        ]);

        // حذف الفيديو القديم إن وجد
        if ($lesson->video_path && file_exists(storage_path('app/public/' . $lesson->video_path))) {
            unlink(storage_path('app/public/' . $lesson->video_path));
        }

        $file = $request->file('video');
        $path = $file->store('lessons/videos', 'public');

        $lesson->update(['video_path' => $path]);

        return back()->with('success', 'تم رفع الفيديو بنجاح لدرس: ' . $lesson->title);
    }

    /** إضافة درس جديد من لوحة الأدمن */
    public function storeLesson(Request $request, Course $course)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'video'       => 'nullable|file|mimetypes:video/mp4,video/avi,video/quicktime,video/webm|max:512000',
            'video_url'   => 'nullable|url',
            'is_free'     => 'boolean',
        ]);

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
        }

        $order = $course->lessons()->max('order') + 1;

        $course->lessons()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'video_url'   => $request->video_url ?? '',
            'video_path'  => $videoPath,
            'is_free'     => $request->boolean('is_free'),
            'order'       => $order,
        ]);

        return back()->with('success', 'تم إضافة الدرس بنجاح.');
    }

    /** حذف درس */
    public function destroyLesson(Lesson $lesson)
    {
        if ($lesson->video_path && file_exists(storage_path('app/public/' . $lesson->video_path))) {
            unlink(storage_path('app/public/' . $lesson->video_path));
        }
        $lesson->delete();
        return back()->with('success', 'تم حذف الدرس بنجاح.');
    }
}
