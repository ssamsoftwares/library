@extends('layouts.main')
@push('page-title')
    <title>{{ 'Student - ' }} {{ $studentProfile->name }}</title>
@endpush

@push('heading')
    {{ 'My Profile  -' }} {{ $studentProfile->name }}
    {{-- <div class="float-left">
        <a href="{{route('student.studentProfileEdit')}}" class="btn btn-primary btn-sm mt-4">Edit Profile</a>
    </div> --}}
@endpush

@push('heading-right')
@endpush

@section('content')

    {{-- Student details --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">{{ 'My Details' }}</h5>
                <div class="card-body">

                    <h5 class="card-title">
                        <span> Student Photo :</span>
                        <span>
                            @if (!empty($studentProfile->image))
                            <img src="{{asset($studentProfile->image)}}" alt="studentImg" width="85" class="rounded-circle img-thumbnail">
                            @else
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                            @endif
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Student Name :</span>
                        <span>
                            {{ $studentProfile->name }}
                        </span>
                    </h5>
                    <hr>
                    <h5 class="card-title">
                        <span>Email  : </span>
                        <span>{{ $studentProfile->email }}</span>
                    </h5>
                    <hr />
                    <h5 class="card-title">
                        <span>Date Of Birth : </span>
                        <span>{{ \Carbon\Carbon::parse($studentProfile->dob)->format('d-M-Y') }}</span>

                    </h5>
                    <hr />
                    <h5 class="card-title">
                        <span>Course : </span>
                        <span> {{ $studentProfile->course }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Subscription : </span>
                        <span>{{ $studentProfile->subscription }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Payment : </span>
                        <span>{{ $studentProfile->payment }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Pending Payment : </span>
                        <span>{{ $studentProfile->pending_payment }}</span>
                    </h5>
                    <hr>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">Contact Details</h5>
                <div class="card-body">
                    <h5 class="card-title">
                        <span>Personal Number : </span>
                        <span>{{ $studentProfile->personal_number }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Emergency Number :</span>
                        <span>{{ $studentProfile['emergency_number'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Current Address :</span>
                        <span>{{ $studentProfile['current_address'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Permanent Address :</span>
                        <span>{{ $studentProfile['permanent_address'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Remark Singnature :</span>
                        <span>{{ $studentProfile['remark_singnature'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Hall Number :</span>
                        <span>{{ $studentProfile['hall_number'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Vehicle Number :</span>
                        <span>{{ $studentProfile['vehicle_number'] }}</span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Aadhar Number :</span>
                        <span>{{ $studentProfile['aadhar_number'] }}</span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Aadhar Front Image :</span>
                        <span>
                            @if (!empty($studentProfile->aadhar_front_img))
                            <img src="{{asset($studentProfile->aadhar_front_img)}}" alt="aadhar_front_img" width="85">
                            @else
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                            @endif

                        </span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Aadhar Back Image :</span>
                        <span>
                            @if (!empty($studentProfile->aadhar_back_img))
                            <img src="{{asset($studentProfile->aadhar_back_img)}}" alt="aadhar_back_img" width="85">
                            @else
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                            @endif

                        </span>
                    </h5>
                    <hr>

                </div>
            </div>
        </div>

    </div>

@endsection
