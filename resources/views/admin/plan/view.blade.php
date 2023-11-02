@extends('layouts.main')
@push('page-title')
    <title>{{ 'Asign Plan - ' }} {{ $plan->plan }}</title>
@endpush

@push('heading')
    {{ 'Asign Plan Detail' }}
@endpush

@push('heading-right')
@endpush

@section('content')

    {{--Asign Plan Student details --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">Plan Details</h5>
                <div class="card-body">
                    <h5 class="card-title">
                        <span>{{'Plan Name'}} : </span>
                        <span>{{ Str::ucfirst($plan->plan) }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{'Payment Mode'}} :</span>
                        <span>{{ $plan['mode_of_payment'] }}</span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>{{ 'Valid From Date ' }} :</span>
                        <span>{{ $plan['valid_from_date'] }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{ 'Valid Upto Date' }} :</span>
                        <span>{{ $plan['valid_upto_date'] }}</span>
                    </h5>
                    <hr>


                </div>
            </div>
        </div>



        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">{{ 'Student Details' }}</h5>
                <div class="card-body">

                    {{-- <h5 class="card-title">
                        <span> {{'Student Photo'}} :</span>
                        <span>
                            @if (!empty($plan->student->image))
                            <img src="{{asset($plan->student->image)}}" alt="studentImg" width="85" class="rounded-circle img-thumbnail">
                            @else
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                            @endif
                        </span>
                    </h5>
                    <hr> --}}

                    <h5 class="card-title">
                        <span>{{'Student Name '}}:</span>
                        <span>
                            {{ $plan->student->name }}
                        </span>
                    </h5>
                    <hr>
                    <h5 class="card-title">
                        <span>{{'Aadhar Number'}} :</span>
                        <span>
                            {{ $plan->student->aadhar_number }}
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{'Email'}}  : </span>
                        <span>{{ $plan->student->email }}</span>
                    </h5>
                    <hr>
                    <h5 class="card-title">
                        <span>{{'Phone Number '}}: </span>
                        <span>{{ $plan->student->personal_number }}</span>
                    </h5>
                    <hr>

                </div>
            </div>
        </div>

    </div>

@endsection
