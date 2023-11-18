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
    <div class="row mt-2">
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
                        <span>{{ \Carbon\Carbon::parse($plan['valid_from_date'])->format('d-m-Y') }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{ 'Valid Upto Date' }} :</span>
                        <span> {{ \Carbon\Carbon::parse($plan['valid_upto_date'])->format('d-m-Y') }}</span>
                    </h5>
                    <hr>


                </div>
            </div>
        </div>



        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">{{ 'Student Details' }}</h5>
                <div class="card-body">

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



    <h4 class="card-title mt-4 mb-4">{{__('Activate Plan Details')}}</h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Plan' }}</th>
                                <th>{{ 'Valid From Date ' }}</th>
                                <th>{{ 'Valid Upto Date' }}</th>
                                <th>{{ 'Mode of Payment' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($activePlans as $p)
                            <tr>
                                <td>{{ $p->plan }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->valid_from_date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->valid_upto_date)->format('d-m-Y') }}</td>
                                <td>{{ $p->mode_of_payment }}</td>
                                <td>
                                    <div class="action-btns text-center" role="group">
                                        <a href="{{ route('plan.edit',['plan'=> $p->id ]) }}" class="btn btn-info waves-effect waves-light edit">
                                           Update Plan
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>



    <h4 class="card-title mt-4 mb-4">{{__('Expired Plan Details')}}</h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Plan' }}</th>
                                <th>{{ 'Valid From Date ' }}</th>
                                <th>{{ 'Valid Upto Date' }}</th>
                                <th>{{ 'Mode of Payment' }}</th>
                                <th>{{ 'Action' }}</th>

                            </tr>
                        </thead>

                        <tbody>
                            @if (count($expiredPlans)>0)
                            @foreach ($expiredPlans as $exp)
                            <tr>
                                <td>{{ $exp->plan }}</td>
                                <td>{{ \Carbon\Carbon::parse($exp->valid_from_date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($exp->valid_upto_date)->format('d-m-Y') }}</td>
                                <td>{{ $exp->mode_of_payment }}</td>

                                <td>
                                    <div class="action-btns text-center" role="group">
                                        <a href="{{route('plan.add')}}" class="btn btn-info waves-effect waves-light edit">
                                           New Plan
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <td colspan="4" class="text-center">No data available in table</td>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
