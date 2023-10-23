@extends('layouts.main')

@push('page-title')
<title>All Plans</title>
@endpush

@push('heading')
{{ 'Plans' }}
@endpush

@section('content')
@push('style')

@endpush

<x-status-message />

<div class="row">
    <div class="col-12">
        <div class="card">
            <x-search.table-search action="{{ route('plans') }}" method="get" name="search"  value="{{isset($_REQUEST['search'])?$_REQUEST['search']:''}}"
            btnClass="search_btn"/>
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ 'Plan' }}</th>
                            <th>{{ 'Student Name' }}</th>
                            <th>{{ 'Student Email' }}</th>
                            <th>{{ 'Valid From Date ' }}</th>
                            <th>{{ 'valid Upto Date' }}</th>
                            <th>{{ 'Mode of Payment' }}</th>
                            <th>{{ 'Actions' }}</th>
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
                            <td>{{ $p->mode_of_payment }}</td>

                            <td>
                                <div class="action-btns text-center" role="group">

                                    {{-- <a href="#"
                                        class="btn btn-primary waves-effect waves-light view">
                                        <i class="ri-eye-line"></i>
                                    </a> --}}

                                    <a href="{{ route('plan.edit',['plan'=> $p->id ]) }}" class="btn btn-info waves-effect waves-light edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <a href="{{ route('plan.delete',['plan'=> $p->id ]) }}" class="btn btn-danger waves-effect waves-light del" onclick="return confirm('Are you sure delete this record !')">
                                        <i class="ri-delete-bin-line"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $plans->onEachSide(5)->links() }}
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@push('script')

@endpush
