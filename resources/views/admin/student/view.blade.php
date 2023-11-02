@extends('layouts.main')
@push('page-title')
    <title>{{ 'Student - ' }} {{ $student->name }}</title>
@endpush

@push('heading')
    {{ 'Student Detail' }}
@endpush

@push('heading-right')
@endpush

@section('content')

    {{-- Student details --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">{{ 'Student Details' }}</h5>
                <div class="card-body">

                    <h5 class="card-title">
                        <span> Student Photo :</span>
                        <span>
                            @if (!empty($student->image))
                            <img src="{{asset($student->image)}}" alt="studentImg" width="85" class="rounded-circle img-thumbnail">
                            @else
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                            @endif
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Student Name :</span>
                        <span>
                            {{ $student->name }}
                        </span>
                    </h5>
                    <hr>
                    <h5 class="card-title">
                        <span>Email  : </span>
                        <span>{{ $student->email }}</span>
                    </h5>
                    <hr />
                    <h5 class="card-title">
                        <span>Date Of Birth : </span>
                        <span>{{ \Carbon\Carbon::parse($student->dob)->format('d-M-Y') }}</span>

                    </h5>
                    <hr />
                    <h5 class="card-title">
                        <span>Course : </span>
                        <span> {{ $student->course }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Subscription : </span>
                        <span>{{ $student->subscription }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Payment : </span>
                        <span>{{ $student->payment }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Pending Payment : </span>
                        <span>{{ $student->pending_payment }}</span>
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
                        <span>{{ $student->personal_number }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Emergency Number :</span>
                        <span>{{ $student['emergency_number'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Current Address :</span>
                        <span>{{ $student['current_address'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Permanent Address :</span>
                        <span>{{ $student['permanent_address'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Remark Singnature :</span>
                        <span>{{ $student['remark_singnature'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Hall Number :</span>
                        <span>{{ $student['hall_number'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Vehicle Number :</span>
                        <span>{{ $student['vehicle_number'] }}</span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Aadhar Number :</span>
                        <span>{{ $student['aadhar_number'] }}</span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Aadhar Front Image :</span>
                        <span>
                            @if (!empty($student->aadhar_front_img))
                            <img src="{{asset($student->aadhar_front_img)}}" alt="aadhar_front_img" width="85">
                            @else
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                            @endif

                        </span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Aadhar Back Image :</span>
                        <span>
                            @if (!empty($student->aadhar_back_img))
                            <img src="{{asset($student->aadhar_back_img)}}" alt="aadhar_back_img" width="85">
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
