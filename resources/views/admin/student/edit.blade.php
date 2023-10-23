@extends('layouts.main')

@push('page-title')
<title>{{__('Edit Student')}}</title>
@endpush

@push('heading')
{{ __('Edit Student') }} : {{ $student->name }}
@endpush

@section('content')

<x-status-message />

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('student.update',[$student->id]) }}" enctype="multipart/form-data">
                    @csrf
                   <input type="hidden" name="id" :value="$student->id" >
                    <h4 class="card-title mb-3">{{__('Personal Details')}}</h4>

                    <div class="row">
                        <div class="col-lg-12">
                           <x-form.input name="name" label="Full Name" :value="$student->name"  />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="personal_number" label="Personal Number" :value="$student->personal_number" />
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="emergency_number" label="Emergency Number"  :value="$student->emergency_number"  />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="email" label="Email Address" :value="$student->email" />
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="dob" label="DOB" type="date" :value="$student->dob" />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.textarea name="course" label="Course" :value="$student->course" />
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.select name="plan" label="Plan" chooseFileComment="--Select Plan--" :options="[
                                'plan1' => 'Plan1',
                                  'plan2' => 'Plan2',
                                  'plan3' => 'Plan3',
                              ]" :selected="$student->plan"   />

                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="mode_of_payment" label="Mode of Payment" type="text" :value="$student->mode_of_payment"  />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="subscription" label="Subscription" :value="$student->subscription" />
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="remark_singnature" label="Remark Singnature" :value="$student->remark_singnature" />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.input name="hall_number" label="Hall Number" type="text" :value="$student->hall_number"  />
                        </div>

                        <div class="col-lg-6">
                            <x-form.input name="vehicle_number" label="Vehicle Number" type="text" :value="$student->vehicle_number" />
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
                            <x-form.input name="aadhar_number" label="Aadhar Number" type="text" :value="$student->aadhar_number" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <x-form.input name="aadhar_front_img" label="Aadhar Front side Image Upload" type="file"/>
                        </div>
                            <div class="col-lg-4 mt-lg-4">
                                @if (! @empty($student->aadhar_front_img))
                                <img src="{{asset($student->aadhar_front_img)}}" alt="studentAadharImgFront" width="50" height="50">
                                @else
                                <strong class="text-primary">No File</strong>
                                @endif
                            </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-8">
                            <x-form.input name="aadhar_back_img" label="Aadhar Back side Image Upload" type="file"/>
                        </div>
                            <div class="col-lg-4 mt-lg-4">
                                @if (! @empty($student->aadhar_back_img))
                                <img src="{{asset($student->aadhar_back_img)}}" alt="studentAadharImgBack" width="50" height="50">
                                @else
                                <strong class="text-primary">No File</strong>
                                @endif
                            </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-8">
                            <x-form.input name="image" label="image" type="file"/>
                        </div>
                            <div class="col-lg-4 mt-lg-4">
                                @if (! @empty($student->image))
                                <img src="{{asset($student->image)}}" alt="StudentIMG" width="50" height="50">
                                @else
                                <strong class="text-primary">No File</strong>
                                @endif
                            </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">{{__('Update Student')}}</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>

@endsection
