@extends('layouts.main')

@push('page-title')
    <title>{{ __('Edit Asign Plan') }}</title>
@endpush

@push('heading')
    {{ __('Asign Plan') }} : {{ $plan->plan }}
@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('plan.update', ['plan' => $plan->id]) }}">
                        @csrf

                        {{-- Plan Details --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <h5 class="card-header">{{ 'Student Personal Details' }}</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="card-title">
                                                    <span>Photo :</span>
                                                    <span>
                                                        @if (!empty($plan->student->image))
                                                            <img src="{{ asset($plan->student->image) }}" alt="studentImg"
                                                                width="50" height="50"
                                                                class="rounded-circle img-thumbnail">
                                                        @else
                                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU"
                                                                alt="studentImg" width="85">
                                                        @endif
                                                    </span>
                                                </h5>
                                                <hr>

                                                <h5 class="card-title">
                                                    <span>Student Name :</span>
                                                    <span>
                                                        {{ $plan->student->name }}
                                                    </span>
                                                </h5>
                                                <hr>
                                                <h5 class="card-title">
                                                    <span>Email : </span>
                                                    <span>{{ $plan->student->email }}</span>
                                                </h5>
                                                <hr/>
                                                <h5 class="card-title">
                                                    <span>Date Of Birth : </span>
                                                    <span>{{ \Carbon\Carbon::parse($plan->student->dob)->format('d-M-Y') }}</span>
                                                </h5>
                                            </div>

                                            <div class="col-lg-6">

                                                <h5 class="card-title mt-4">
                                                    <span>Aadhar Number : </span>
                                                    <span>{{ $plan->student->aadhar_number  }}</span>
                                                </h5>

                                                <hr>
                                                <h5 class="card-title">
                                                    <span>Personal Number : </span>
                                                    <span>{{ $plan->student->personal_number }}</span>
                                                </h5>

                                                <hr>
                                                <h5 class="card-title">
                                                    <span>Emergency Number : </span>
                                                    <span>{{ $plan->student->emergency_number }}</span>
                                                </h5>

                                                <hr>
                                                <h5 class="card-title">
                                                    <span>Current Address : </span>
                                                    <span>{{ $plan->student->current_address }}</span>
                                                </h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Plan Details End --}}

                        <h4 class="card-title mb-3">{{ __('Edit the Plan Details') }}</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.select name="plan" label="Plan" chooseFileComment="--Select Plan--"
                                    :options="[
                                        'plan1' => 'Plan1',
                                        'plan2' => 'Plan2',
                                        'plan3' => 'Plan3',
                                    ]" :selected="$plan->plan" />

                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="mode_of_payment" label="Mode of Payment" type="text"
                                    :value="$plan->mode_of_payment" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="valid_from_date" label="Valid From Date" type="date"
                                    :value="$plan->valid_from_date" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="valid_upto_date" label="Valid Upto Date" type="date"
                                    :value="$plan->valid_upto_date" />
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">{{ __('Asign Plan Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
