@extends('layouts.main')
@push('page-title')
    <title>{{ 'Bulk Student - ' }} {{ $bulkUploadStudent->name }}</title>
@endpush

@push('heading')
    {{ 'Bulk Student Detail' }}
@endpush

@push('heading-right')
@endpush

@section('content')

    {{-- BULK Student details --}}
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <h5 class="card-header">{{ 'Student Details' }}</h5>
                <div class="card-body">
                    <h5 class="card-title">
                        <span>Student Name :</span>
                        <span>
                            {{ $bulkUploadStudent->name }}
                        </span>
                    </h5>
                    <hr>
                    <h5 class="card-title">
                        <span>Email  : </span>
                        <span>{{ $bulkUploadStudent->email }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Phone Number : </span>
                        <span>{{ $bulkUploadStudent->phone_number }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Course : </span>
                        <span> {{ $bulkUploadStudent->course }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Graduation : </span>
                        <span> {{ $bulkUploadStudent->graduation }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Address : </span>
                        <span> {{ $bulkUploadStudent->address }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Remark : </span>
                        <span> {{ $bulkUploadStudent->remark }}</span>
                    </h5>
                    <hr />

                    <h5 class="card-title">
                        <span>Create By: </span>
                        <span>{{ optional($bulkUploadStudent->createbyStudent)->name }}</span>
                    </h5>
                    <hr />


                    <h5 class="card-title">
                        <span>Created_at : </span>
                        <span>{{ \Carbon\Carbon::parse($bulkUploadStudent->created_at)->format('d-M-Y') }}</span>

                    </h5>
                    <hr />

                </div>
            </div>
        </div>
    </div>



@endsection
