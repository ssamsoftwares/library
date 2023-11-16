@extends('layouts.main')

@push('page-title')
    <title>{{'Dashboard'}}</title>
@endpush

@push('heading')
    {{ 'Hello'}} - {{ Str::ucfirst($student->name) }}
@endpush

@section('content')

<h4 class="card-title mt-4 mb-4">{{__('Your Activate Plan Details')}}</h4>
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
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($activePlans as $p)
                        <tr>
                            <td>{{ $p->plan }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->valid_from_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->valid_upto_date)->format('d-m-Y') }}</td>
                            <td>{{ $p->mode_of_payment }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div>



<h4 class="card-title mt-4 mb-4">{{__('Your Expired Plan Details')}}</h4>
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
