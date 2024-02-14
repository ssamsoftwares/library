@extends('layouts.main')

@push('page-title')
    <title>All Students</title>
@endpush

@push('heading')
    {{ 'Students' }}
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
                        <a href="{{ route('student.bulkUploadStudents') }}" class="btn btn-info btn-sm"> Bulk Upload Students
                            View</a>
                        <a href="{{ route('students') }}" class="btn btn-success btn-sm">Students View</a>
                    </div>

                    <div class="col-lg-3 mt-4">
                    </div>

                    <div class="col-lg-5">
                        <x-search.table-search action="{{ route('students') }}" method="get" name="search"
                            value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ '#' }}</th>
                                <th>{{ 'Student Photo' }}</th>
                                <th>{{ 'Name' }}</th>
                                <th>{{ 'Phone' }}</th>
                                <th>{{ 'Email' }}</th>
                                @hasrole('superadmin')
                                    <th>{{ 'Password' }}</th>
                                    <th>{{ 'Created By' }}</th>
                                @endhasrole
                                <th>{{ 'Library Branch' }}</th>
                                {{-- <th>{{ 'Status' }}</th> --}}
                                <th>{{ 'Actions' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($students as $stu)
                                <tr>
                                    <td>{{ $students->perPage() * ($students->currentPage() - 1) + $loop->index + 1 }}
                                    </td>
                                    <td>
                                        @if (!empty($stu->image))
                                            <img src="{{ asset($stu->image) }}" alt="studentImg" width="85">
                                        @else
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU"
                                                alt="studentImg" width="85">
                                        @endif
                                    </td>
                                    <td>{{ $stu->name }}</td>
                                    <td>{{ $stu->personal_number }}</td>
                                    <td>{{ $stu->email }}</td>
                                    @hasrole('superadmin')
                                        <td>{{ $stu->password }}</td>
                                        <td>{{ optional($stu->createby)->name }}</td>
                                    @endhasrole

                                    <td>{{ isset($stu->plan->library_branch) ? Str::ucfirst($stu->plan->library_branch) : 'No Library Branch' }}
                                    </td>


                                    {{-- <td>
                                        @php
                                            $statusAction = $stu->status == 'active' ? 'block' : 'active';
                                            $roleBasedUrl = auth()->user()->hasRole('superadmin') ? route('student.statusUpdate', ['id' => $stu->id, 'action' => $statusAction]) : '#';
                                        @endphp

                                        <a href="{{ $roleBasedUrl }}"
                                            onclick="{{ auth()->user()->hasRole('superadmin') ? "return confirm('Are You Sure " . ($stu->status == 'active' ? 'Block' : 'Active') . " This student.')" : '' }}">
                                            <span
                                                class="btn btn-{{ $stu->status == 'active' ? 'success' : 'danger' }} btn-sm">
                                                {{ $stu->status == 'active' ? 'Active' : 'Block' }}
                                            </span>
                                        </a>
                                    </td> --}}



                                    <td>
                                        <div class="action-btns text-center" role="group">
                                            @can('student-view')
                                                <a href="{{ route('student.view', ['student' => $stu->id]) }}"
                                                    class="btn btn-primary waves-effect waves-light view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            @endcan

                                            @can('student-edit')
                                                <a href="{{ route('student.edit', ['student' => $stu->id]) }}"
                                                    class="btn btn-info waves-effect waves-light edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            @endcan
                                            {{-- <a href="{{ route('student.delete',['student'=> $stu->id ]) }}" class="btn btn-danger waves-effect waves-light del" onclick="return confirm('Are you sure delete this record !')">
                                        <i class="ri-delete-bin-line"></i>
                                        </a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $students->onEachSide(5)->links() }} --}}
                    {{ $students->onEachSide(5)->appends(request()->query())->links() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')
@endpush
