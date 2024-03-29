@extends('layouts.main')

@push('page-title')
    <title>{{'Dashboard'}}</title>
@endpush

@push('heading')
    {{ 'Dashboard'}}
@endpush

@section('content')


{{-- quick info --}}
<div class="row">
    <x-design.card heading="Total Student" value="{{$total['student']}}" icon="mdi-account-convert" desc="Student"/>
    {{-- <x-design.card heading="Total Plan" value="{{$total['totalActivePlans']}}"  desc="Activate student plans"/> --}}
</div>

<h4 class="card-title mt-4 mb-4">{{__('Plan Expired Students within 5 days')}}</h4>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="justify-content-end d-flex">
            <x-search.table-search action="{{ route('dashboard') }}" method="get" name="search"  value="{{isset($_REQUEST['search'])?$_REQUEST['search']:''}}"
            btnClass="search_btn"/>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{'#'}}</th>
                            <th>{{ 'Plan' }}</th>
                            <th>{{ 'Student Name' }}</th>
                            <th>{{ 'Student Email' }}</th>
                            <th>{{ 'Valid From Date ' }}</th>
                            <th>{{ 'Valid Upto Date' }}</th>
                            <th>{{ 'Actions' }}</th>
                            <th>{{ 'Mode of Payment' }}</th>
                            <th>{{ 'Library Branch' }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($plans as $p)
                        <tr>
                            <td>{{ $plans->perPage() * ($plans->currentPage() - 1) + $loop->index + 1 }}
                            </td>
                            <td>{{ $p->plan }}</td>
                            <td>{{ $p->student->name }}</td>
                            <td>{{ $p->student->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->valid_from_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->valid_upto_date)->format('d-m-Y') }}</td>


                            <td>
                                <div class="action-btns text-center" role="group">
                                    <a href="{{ route('plan.edit',['plan'=> $p->id ]) }}" class="btn btn-info waves-effect waves-light edit btn-sm">
                                       Update Plan
                                    </a>

                                </div>
                            </td>

                            <td>{{ $p->mode_of_payment }}</td>
                            <td>{{ isset($p->library_branch) ? Str::ucfirst($p->library_branch) : 'No Library Branch' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $plans->onEachSide(5)->appends(request()->query())->links() }}

            </div>
        </div>
    </div> <!-- end col -->
</div>

@endsection
