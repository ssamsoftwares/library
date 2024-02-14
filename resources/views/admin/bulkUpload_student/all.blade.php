@extends('layouts.main')

@push('page-title')
    <title>All Bulk Uploaded Students</title>
@endpush

@push('heading')
    {{ 'Bulk Uploaded Students' }}
@endpush

@section('content')
    @push('style')
        <style>
            .ri-eye-line:before {
                content: "\ec95";
                position: absolute;
                left: 13px;
                top: 5px;
            }

            a.btn.btn-primary.waves-effect.waves-light.view {
                width: 41px;
                height: 32px;
            }

            .action-btns.text-center {
                display: flex;
                gap: 10px;
            }

            .ri-pencil-line:before {
                content: "\ef8c";
                position: absolute;
                left: 13px;
                top: 5px;
            }

            a.btn.btn-info.waves-effect.waves-light.edit {
                width: 41px;
                height: 32px;
            }


            table.dataTable>tbody>tr.child ul.dtr-details>li {
                white-space: nowrap !important;
            }
        </style>
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row m-2 mt-4 justify-content-end d-flex">
                    <div class="col-lg-4 mt-4">
                      <a href="{{route('students')}}" class="btn btn-success btn-sm">Students View</a>
                    </div>
                    <div class="col-lg-4 mt-4">
                    </div>
                    <div class="col-lg-4">
                        <x-search.table-search action="{{ route('student.bulkUploadStudents') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Name' }}</th>
                                <th>{{ 'Email' }}</th>
                                <th>{{ 'Phone' }}</th>
                                <th>{{ 'Course' }}</th>
                                <th>{{ 'Created By' }}</th>
                                <th>{{ 'Actions' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bulkUploadStudents as $stu)
                                <tr>
                                    <td>{{ $stu->name }}</td>
                                    <td>{{ $stu->email }}</td>
                                    <td>{{ $stu->phone_number }}</td>
                                    <td>{{ $stu->course }}</td>
                                    <td>{{ optional($stu->createbyStudent)->name }}</td>
                                    <td>
                                        <div class="action-btns text-center" role="group">
                                            @can('student-view')
                                                <a href="{{ route('student.bulkUploadStudentsView', ['bulkUploadStudent' => $stu->id]) }}"
                                                    class="btn btn-primary waves-effect waves-light view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            @endcan

                                            @can('student-edit')
                                            <a href="{{ route('student.bulkUploadStudentsUpdate', ['bulkUploadStudent' => $stu->id]) }}"
                                                class="btn btn-info waves-effect waves-light edit">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $bulkUploadStudents->appends(request()->query())->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')
@endpush
