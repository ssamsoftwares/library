@extends('layouts.main')

@push('page-title')
<title>{{ __('Add New Student')}}</title>
@endpush

@push('heading')
{{ __('Add New Student') }}
@endpush

@section('content')

<x-status-message/>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('student.store') }}" enctype="multipart/form-data">
                    @csrf
                    <h4 class="card-title mb-3">{{__('Personal Details')}}</h4>

                    <div class="row">
                        <div class="col-lg-12">
                           <x-form.input name="name" label="Full Name"  />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="personal_number" label="Personal Number" />
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="emergency_number" label="Emergency Number"  />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="dob" label="DOB" type="date" value="<?php echo date('Y-m-d'); ?>"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="email" label="Email Address"/>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="password" label="Passsword" type="password"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="confirm-password" label="Confirm Password" type="password"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="course" label="Course"/>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-lg-6">
                                <x-form.input name="payment" label="Payment" type="text" />
                            </div>

                        <div class="col-lg-6">
                                <x-form.input name="pending_payment" label="Pending Payment" type="text" />
                            </div>
                     </div> --}}


                    <div class="row">
                        {{-- <div class="col-lg-6">
                            <x-form.input name="subscription" label="Subscription"/>
                        </div> --}}

                        <div class="col-lg-12">
                            <x-form.input name="remark_singnature" label="Remark Singnature"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="hall_number" label="Hall Number" type="text"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="vehicle_number" label="Vehicle Number" type="text"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="current_address" label="Current Address"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="permanent_address" label="Permanent Address"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.input name="aadhar_number" label="Aadhar Number" type="text"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <label for="">Aadhar Front side Image Upload</label>
                            <input type="file" accept="image/*" name="aadhar_front_img" id="aadhar_front_img"
                                onchange="loadFile(event, 'output1')" class="form-control">
                        </div>
                        <div class="col-lg-5">
                            <img id="output1" src="" alt=""
                                style="max-width: 50%; max-height: 100px;">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-7">
                            <label for="">Aadhar back side Image Upload</label>
                            <input type="file" accept="image/*" name="aadhar_back_img" id="aadhar_back_img"
                                onchange="loadFile(event, 'output2')" class="form-control">
                        </div>

                        <div class="col-lg-5">
                            <img id="output2" src="" alt=""
                                style="max-width: 50%; max-height: 100px;">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-7">
                            <label for="">Student Image</label>
                            <input type="file" accept="image/*" name="image" id="student_image"
                                onchange="loadFile(event, 'output3')" class="form-control">
                        </div>

                        <div class="col-lg-5">
                            <img id="output3" src="" alt=""
                                style="max-width: 50%; max-height: 100px;">
                        </div>
                    </div>


                    <div>
                        <button class="btn btn-primary mt-2" type="submit">{{__('Add Student')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection
 {{-- Image Preview Script --}}
 <script>
    function loadFile(event, outputId) {
        var output = document.getElementById(outputId);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src); // Free up memory
        };
    }
</script>
