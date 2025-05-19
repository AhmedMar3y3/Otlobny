@extends('layout')
@section('main')

<div class="container text-end">
    <h2>جميع الاسئلة الشائعة</h2>

    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- Add FAQ Button -->
    <button class="btn btn-primary btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#createFaqModal" style="margin: 10px">
        إضافة سؤال جديد
    </button>

    <!-- FAQs Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>السؤال</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faqs as $faq)
            <tr>
                <td>
                    <!-- Delete Button -->
                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-trash"></i></button>
                    </form>

                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#editFaqModal{{ $faq->id }}">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Show Button -->
                    <button class="btn btn-info btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#showFaqModal{{ $faq->id }}">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
                <td>{{ $faq->question }}</td>
                <td>{{ $faq->id }}</td>
            </tr>

            <!-- Show FAQ Modal -->
            <div class="modal fade text-end" id="showFaqModal{{ $faq->id }}" tabindex="-1" aria-labelledby="showFaqModalLabel{{ $faq->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showFaqModalLabel{{ $faq->id }}">عرض السؤال</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p style="color: black"><strong>السؤال:</strong> {{ $faq->question }}</p>
                            <p style="color: black"><strong>الإجابة:</strong> {{ $faq->answer }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit FAQ Modal -->
            <div class="modal fade text-end" id="editFaqModal{{ $faq->id }}" tabindex="-1" aria-labelledby="editFaqModalLabel{{ $faq->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editFaqModalLabel{{ $faq->id }}">تعديل السؤال</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- FAQ Question -->
                                <div class="mb-3">
                                    <label for="editFaqQuestion{{ $faq->id }}" class="form-label">السؤال</label>
                                    <input type="text" name="question" class="form-control text-end" id="editFaqQuestion{{ $faq->id }}" value="{{ $faq->question }}" required>
                                </div>
                                <!-- FAQ Answer -->
                                <div class="mb-3">
                                    <label for="editFaqAnswer{{ $faq->id }}" class="form-label">الإجابة</label>
                                    <textarea name="answer" class="form-control text-end" id="editFaqAnswer{{ $faq->id }}" required>{{ $faq->answer }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="12" class="text-center">لا توجد أسئلة متاحة.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create FAQ Modal -->
<div class="modal fade text-end" id="createFaqModal" tabindex="-1" aria-labelledby="createFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createFaqModalLabel">إضافة سؤال جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- FAQ Question -->
                    <div class="mb-3">
                        <label for="faqQuestion" class="form-label">السؤال</label>
                        <input type="text" name="question" class="form-control text-end" id="faqQuestion" required>
                    </div>
                    <!-- FAQ Answer -->
                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">الإجابة</label>
                        <textarea name="answer" class="form-control text-end" id="faqAnswer" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection