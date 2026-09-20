<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $lessons = $course->lessons()->orderBy('order')->get();
        return view('teacher.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        return view('teacher.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:upload,url',
            'video' => 'required_if:video_type,upload|file|max:1024000',
            'video_url' => 'required_if:video_type,url|nullable|string|max:500',
            'is_free' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $videoUrl = $request->video_url;

        if ($request->video_type === 'upload' && $request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
            $videoUrl = Storage::disk('public')->url($videoPath);
        }

        $course->lessons()->create([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $videoUrl,
            'is_free' => $request->has('is_free'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('teacher.courses.lessons.index', $course->id)
            ->with('success', 'تم إضافة الدرس بنجاح.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        if ($course->teacher_id !== auth()->id() || $lesson->course_id !== $course->id) {
            abort(403);
        }

        return view('teacher.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        if ($course->teacher_id !== auth()->id() || $lesson->course_id !== $course->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:upload,url',
            'video' => 'nullable|file|max:1024000',
            'video_url' => 'required_if:video_type,url|nullable|string|max:500',
            'is_free' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_free' => $request->has('is_free'),
            'order' => $request->order ?? 0,
        ];

        if ($request->video_type === 'url') {
            $data['video_url'] = $request->video_url;
        } elseif ($request->video_type === 'upload' && $request->hasFile('video')) {
            // Delete old video if it's a local file
            if ($lesson->video_url && str_contains($lesson->video_url, '/storage/')) {
                $oldPath = str_replace(Storage::disk('public')->url(''), '', $lesson->video_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
            $data['video_url'] = Storage::disk('public')->url($videoPath);
        }

        $lesson->update($data);

        return redirect()->route('teacher.courses.lessons.index', $course->id)
            ->with('success', 'تم تحديث الدرس بنجاح.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        if ($course->teacher_id !== auth()->id() || $lesson->course_id !== $course->id) {
            abort(403);
        }

        if ($lesson->video_url) {
            $oldPath = str_replace('/storage/', '', $lesson->video_url);
            Storage::disk('public')->delete($oldPath);
        }

        $lesson->delete();

        return redirect()->route('teacher.courses.lessons.index', $course->id)
            ->with('success', 'تم حذف الدرس بنجاح.');
    }

    /** رفع رابط محاضرة سريعة للأستاذ في مادته مباشرة */
    public function storeQuickLecture(Request $request)
    {
        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'title'        => 'required|string|max:255',
            'video_url'    => 'required|url',
            'description'  => 'nullable|string|max:1000',
            'is_free'      => 'nullable|boolean',
        ], [
            'subject_id.required' => 'يرجى اختيار المادة الدراسية',
            'title.required'      => 'يرجى كتابة عنوان المحاضرة',
            'video_url.required'  => 'يرجى إدخال رابط المحاضرة',
            'video_url.url'       => 'يرجى إدخال رابط صحيح (مثل: https://youtube.com/...)',
        ]);

        $teacher = auth()->user();
        $subject = \App\Models\Subject::findOrFail($request->subject_id);

        $course = Course::firstOrCreate(
            [
                'teacher_id' => $teacher->id,
                'subject_id' => $subject->id,
            ],
            [
                'title'       => 'شرح مادة ' . $subject->name . ' - الأستاذ ' . $teacher->name,
                'description' => 'المحاضرات والشروحات الخاصة بمادة ' . $subject->name,
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

        return back()->with('success', 'تم رفع رابط المحاضرة بنجاح لمادة ' . $subject->name);
    }

    /** حذف المحاضرة السريعة للأستاذ */
    public function destroyQuickLecture(Lesson $lesson)
    {
        if ($lesson->course->teacher_id !== auth()->id()) {
            abort(403);
        }

        if ($lesson->video_path && file_exists(storage_path('app/public/' . $lesson->video_path))) {
            unlink(storage_path('app/public/' . $lesson->video_path));
        }

        $lesson->delete();

        return back()->with('success', 'تم حذف المحاضرة بنجاح');
    }
}
