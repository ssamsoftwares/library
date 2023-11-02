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
                            <x-form.input name="email" label="Email Address"/>
                        </div>
                        <div class="col-lg-6">
                            <x-form.input name="dob" label="DOB" type="date" value="<?php echo date('Y-m-d'); ?>"/>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="course" label="Course"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                                <x-form.input name="payment" label="Payment" type="text" />
                            </div>

                        <div class="col-lg-6">
                                <x-form.input name="pending_payment" label="Pending Payment" type="text" />
                            </div>
                     </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="subscription" label="Subscription"/>
                        </div>

                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
                            <x-form.input name="aadhar_number" label="Aadhar Number" type="text"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="aadhar_front_img" label="Aadhar Front Image" type="file"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="aadhar_back_img" label="Aadhar Back Image" type="file"/>
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="image" label="Student image" type="file"/>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('Add Student')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection
