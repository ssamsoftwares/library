@extends('layouts.main')

@push('page-title')
    <title>{{ __('Edit uploaded Student') }}</title>
@endpush

@push('heading')
    {{ __('Edit Student') }} : {{ $bulkUploadStudent->name }}
@endpush

@section('content')
    <x-status-message />

    <a href="{{route('student.bulkUploadStudents')}}" class="btn btn-warning m-2"><i class="fa fa-backward"></i> {{'Back'}}</a>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('student.bulkUploadStudentsUpdate', [$bulkUploadStudent->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" :value="$bulkUploadStudent - > id">
                        <h4 class="card-title mb-3">{{ __('Personal Details') }}</h4>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="name" label="Student Name" :value="$bulkUploadStudent->name" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="email" label="Email" :value="$bulkUploadStudent->email" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <x-form.input name="phone_number" label="Phone Number" :value="$bulkUploadStudent->phone_number" />
                            </div>

                            <div class="col-lg-4">
                                <x-form.input name="course" label="Course" :value="$bulkUploadStudent->course" />
                            </div>

                            <div class="col-lg-4">
                                <x-form.input name="graduation" label="Graduation" :value="$bulkUploadStudent->graduation" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="address" label="Address" :value="$bulkUploadStudent->address" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="remark" label="Remark" :value="$bulkUploadStudent->remark" />
                            </div>
                        </div>


                        <div>
                            <button class="btn btn-primary mt-2" type="submit">{{ __('Update Student') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
