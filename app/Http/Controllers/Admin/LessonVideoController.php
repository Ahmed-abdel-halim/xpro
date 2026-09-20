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
        return back()->with('success', 'تم حذف المحاضرة / الرابط بنجاح.');
    }

    /** عرض وإدارة جميع الروابط والمحاضرات لكافة المواد مع إمكانية التصفية والإضافة والحذف */
    public function allLectures(Request $request)
    {
        $stages = \App\Models\Stage::with('grades.subjects')->get();
        $teachers = \App\Models\User::where('role', 'teacher')->orderBy('name')->get();
        $subjects = Subject::with('grade.stage')->orderBy('name')->get();

        $query = Lesson::with(['course.subject.grade.stage', 'course.teacher'])
            ->latest('id');

        if ($request->filled('subject_id')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        } elseif ($request->filled('grade_id')) {
            $query->whereHas('course.subject', function ($q) use ($request) {
                $q->where('grade_id', $request->grade_id);
            });
        } elseif ($request->filled('stage_id')) {
            $query->whereHas('course.subject.grade', function ($q) use ($request) {
                $q->where('stage_id', $request->stage_id);
            });
        }

        if ($request->filled('teacher_id')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('teacher_id', $request->teacher_id);
            });
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $lessons = $query->paginate(25)->withQueryString();

        return view('admin.lessons.all', compact('lessons', 'stages', 'subjects', 'teachers'));
    }

    /** إضافة رابط محاضرة سريعة لأي مادة من لوحة الأدمن */
    public function storeQuickLecture(Request $request)
    {
        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'teacher_id'   => 'required|exists:users,id',
            'title'        => 'required|string|max:255',
            'video_url'    => 'required|url',
            'description'  => 'nullable|string|max:1000',
            'is_free'      => 'nullable|boolean',
        ], [
            'subject_id.required' => 'يرجى اختيار المادة الدراسية',
            'teacher_id.required' => 'يرجى اختيار الأستاذ القائم على الشرح',
            'title.required'      => 'يرجى كتابة عنوان المحاضرة',
            'video_url.required'  => 'يرجى إدخال رابط المحاضرة',
            'video_url.url'       => 'يرجى إدخال رابط صحيح (مثل: https://youtube.com/...)',
        ]);

        $subject = Subject::findOrFail($request->subject_id);
        $teacher = \App\Models\User::findOrFail($request->teacher_id);

        $course = Course::firstOrCreate(
            [
                'teacher_id' => $teacher->id,
                'subject_id' => $subject->id,
            ],
            [
                'title'       => 'شرح مادة ' . $subject->name . ' - الأستاذ ' . $teacher->name,
                'description' => 'شرح منهج مادة ' . $subject->name,
                'price'       => 0,
            ]
        );

        $order = $course->lessons()->max('order') + 1;

        $course->lessons()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'video_url'   => $request->video_url,
            'is_free'     => $request->boolean('is_free', true),
            'order'       => $order,
        ]);

        return back()->with('success', 'تم رفع رابط المحاضرة بنجاح لمادة ' . $subject->name . ' باسم الأستاذ ' . $teacher->name);
    }
}
