@extends('dashboard.layouts.master')

@section('css')

@endsection

@section('pageTitle')
{{$pageTitle}}
@endsection
@section('content')
@include('dashboard.layouts.common._partial.messages')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                <span class="mt-1 text-muted fw-bold fs-7">{{$pageTitle}}</span>
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="py-3 card-body">
            <div class="container">
                <div class="container">
                    <h2 class="mb-4">{{ $pageTitle }}</h2>
                
                    <form action="{{ route('admin.privacy.update', $privacy->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                
                        <ul class="nav nav-tabs" id="localeTabs" role="tablist">
                            @foreach (config('translatable.locales') as $index => $locale)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($index === 0) active @endif" id="{{ $locale }}-tab" data-bs-toggle="tab"
                                    data-bs-target="#{{ $locale }}" type="button" role="tab">
                                    {{ $locale === 'ar' ? 'العربية' : 'English' }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                
                        <div class="tab-content mt-4" id="localeTabsContent">
                            @foreach (config('translatable.locales') as $index => $locale)
                            @php
                            $trans = $privacy->translate($locale);
                            $title = $trans->title ?? '';
                            $description = $trans->description ?? [];
                            @endphp
                
                            <div class="tab-pane fade @if($index === 0) show active @endif" id="{{ $locale }}" role="tabpanel">
                                <div class="mb-3">
                                    <label for="title_{{ $locale }}" class="form-label">العنوان ({{ $locale }})</label>
                                    <input type="text" class="form-control" name="title[{{ $locale }}]" id="title_{{ $locale }}"
                                        value="{{ $title }}" required>
                                </div>
                
                                <div class="mb-3">
                                    <label class="form-label">الوصف ({{ $locale }})</label>
                                    <div id="description-list-{{ $locale }}">
                                        @forelse($description as $point)
                                        <div class="input-group mb-2">
                                            <input type="text" name="description[{{ $locale }}][]" class="form-control"
                                                value="{{ $point }}">
                                            <button type="button" class="btn btn-danger remove-point">−</button>
                                        </div>
                                        @empty
                                        <div class="input-group mb-2">
                                            <input type="text" name="description[{{ $locale }}][]" class="form-control"
                                                placeholder="أدخل نقطة">
                                            <button type="button" class="btn btn-danger remove-point">−</button>
                                        </div>
                                        @endforelse
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary add-point" data-locale="{{ $locale }}">+ إضافة
                                        نقطة</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                
                        <button type="submit" class="btn btn-primary mt-4">حفظ التعديلات</button>
                    </form>
                </div>
            </div>
        </div>
        <!--begin::Body-->
    </div>
    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
            document.querySelectorAll('.add-point').forEach(button => {
                button.addEventListener('click', function () {
                    const locale = this.getAttribute('data-locale');
                    const container = document.getElementById(`description-list-${locale}`);
                    const inputGroup = document.createElement('div');
                    inputGroup.classList.add('input-group', 'mb-2');
                    inputGroup.innerHTML = `
                        <input type="text" name="description[${locale}][]" class="form-control" placeholder="أدخل نقطة">
                        <button type="button" class="btn btn-danger remove-point">−</button>
                    `;
                    container.appendChild(inputGroup);
                });
            });
        
            document.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-point')) {
                    e.target.closest('.input-group').remove();
                }
            });
    </script>
    @endpush