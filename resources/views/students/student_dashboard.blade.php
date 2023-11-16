@extends('layouts.main')

@push('page-title')
    <title>{{'Dashboard'}}</title>
@endpush

@push('heading')
    {{ 'Hello'}}  {{ Str::ucfirst($checkStudent->name) }}
@endpush

@section('content')

<div class="row">

    <x-design.card heading="Total Student"  value="{{$total['activePlansCount']}}" icon="mdi-account-convert" desc="Activate student plans" />
    <x-design.card heading="Total Plan" value="{{$total['expiredPlansCount']}}"  desc="Expired student plans"/>
</div>

<h4 class="card-title mt-4 mb-4">{{__('Your Plan Expired within 5 days')}}</h4>
<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <div class="justify-content-end d-flex">
            <x-search.table-search action="#" method="get" name="search"  value="{{isset($_REQUEST['search'])?$_REQUEST['search']:''}}"
            btnClass="search_btn"/>
            </div> --}}
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ 'Plan' }}</th>
                            <th>{{ 'Student Name' }}</th>
                            <th>{{ 'Student Email' }}</th>
                            <th>{{ 'Valid From Date ' }}</th>
                            <th>{{ 'Valid Upto Date' }}</th>
                            {{-- <th>{{ 'Actions' }}</th> --}}
                            <th>{{ 'Mode of Payment' }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($plans as $p)
                        <tr>
                            <td>{{ $p->plan }}</td>
                            <td>{{ $p->student->name }}</td>
                            <td>{{ $p->student->email }}</td>
                            <td>{{ $p->valid_from_date }}</td>
                            <td>{{ $p->valid_upto_date }}</td>

                            {{-- <td>
                                <div class="action-btns text-center" role="group">
                                    <a href="{{ route('plan.edit',['plan'=> $p->id ]) }}" class="btn btn-info waves-effect waves-light edit">
                                       Renew Plan
                                    </a>

                                </div>
                            </td> --}}
                            <td>{{ $p->mode_of_payment }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $plans->onEachSide(5)->links() }}
            </div>
        </div>
    </div> <!-- end col -->
</div>

@endsection
