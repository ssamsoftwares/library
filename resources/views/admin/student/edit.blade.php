@extends('layouts.main')

@push('page-title')
    <title>{{ __('Edit Student') }}</title>
@endpush

@push('heading')
    {{ __('Edit Student') }} : {{ $student->name }}
@endpush

@section('content')
    <x-status-message />

    <a href="{{ route('students') }}" class="btn btn-warning m-2"><i class="fa fa-backward"></i> {{ 'Back' }}</a>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('student.update', [$student->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" :value="$student - > id">
                        <h4 class="card-title mb-3">{{ __('Personal Details') }}</h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.input name="name" label="Full Name" :value="$student->name" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="personal_number" label="Personal Number" :value="$student->personal_number" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="emergency_number" label="Emergency Number" :value="$student->emergency_number" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="dob" label="DOB" type="date" :value="$student->dob" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="email" label="Email Address" :value="$student->email" />
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="password" label="Passsword" type="password"/>
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="confirm-password" label="Confirm Password" type="password"/>
                            </div>
                        </div> --}}


                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="course" label="Course" :value="$student->course" />
                            </div>
                        </div>

                        {{--
                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="payment" label="Payment" type="text" :value="$student->payment" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="pending_payment" label="Pending Payment" type="text"
                                    :value="$student->pending_payment" />
                            </div>
                        </div> --}}


                        <div class="row">
                            {{-- <div class="col-lg-6">
                                <x-form.input name="subscription" label="Subscription" :value="$student->subscription" />
                            </div> --}}

                            <div class="col-lg-12">
                                <x-form.input name="remark_singnature" label="Remark Singnature" :value="$student->remark_singnature" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="hall_number" label="Hall Number" type="text" :value="$student->hall_number" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="vehicle_number" label="Vehicle Number" type="text"
                                    :value="$student->vehicle_number" />
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="current_address" label="Current Address" :value="$student->current_address" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.textarea name="permanent_address" label="Permanent Address" :value="$student->permanent_address" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.input name="aadhar_number" label="Aadhar Number" type="text"
                                    :value="$student->aadhar_number" />
                            </div>
                        </div>

                        {{-- Aadhar Front side Image Upload --}}
                        <div class="row">
                            <div class="col-lg-8">
                                <label for="aadhar_front_img">Aadhar Front side Image Upload</label>
                                <input type="file" accept="image/*" name="aadhar_front_img" id="aadhar_front_img"
                                    class="form-control" onchange="loadFile(event, 'preview_aadhar_front_img')">
                            </div>
                            <div class="col-lg-4 mt-lg-2">
                                @if (!empty($student->aadhar_front_img))
                                    <img src="{{ asset($student->aadhar_front_img) }}" id="preview_aadhar_front_img"
                                        alt="" width="50" height="50">
                                @else
                                    <img src="" id="preview_aadhar_front_img" alt="" width="50"
                                        height="50">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <label for="aadhar_back_img">Aadhar Back side Image Upload</label>
                                <input type="file" accept="image/*" name="aadhar_back_img" id="aadhar_back_img"
                                    class="form-control" onchange="loadFile(event, 'preview_aadhar_back_img')">
                            </div>
                            <div class="col-lg-4 mt-lg-2">
                                @if (!empty($student->aadhar_back_img))
                                    <img src="{{ asset($student->aadhar_back_img) }}" id="preview_aadhar_back_img"
                                        alt="" width="50" height="50">
                                @else
                                    <img src="" id="preview_aadhar_back_img" alt="" width="50"
                                        height="50">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <label for="student_image">Student image</label>
                                <input type="file" accept="image/*" name="image" id="student_image"
                                    class="form-control" onchange="loadFile(event, 'preview_student_image')">
                            </div>
                            <div class="col-lg-4 mt-lg-2">
                                @if (!empty($student->image))
                                    <img src="{{ asset($student->image) }}" id="preview_student_image" alt=""
                                        width="50" height="50">
                                @else
                                    <img src="" id="preview_student_image" alt="" width="50"
                                        height="50">
                                @endif
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <x-form.radio label="Status" name="status" id="" :value="$student->status" />
                            </div>
                        </div> --}}

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
    {{-- Image Preview Script --}}
    <script>
        function loadFile(event, outputId) {
            var output = document.getElementById(outputId);
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    output.src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                output.src = ""; // Set the image source to blank if no file is selected
            }
        }
    </script>
@endpush
