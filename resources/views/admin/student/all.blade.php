@extends('layouts.main')

@push('page-title')
    <title>All Students</title>
@endpush

@push('heading')
    {{ 'Students' }}
@endpush

@section('content')
    @push('style')
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="justify-content-end d-flex">
                    <x-search.table-search action="{{ route('students') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Student Photo' }}</th>
                                <th>{{ 'Name' }}</th>
                                <th>{{ 'Email' }}</th>
                                @hasrole('admin')
                                    <th>{{ 'Password' }}</th>
                                @endhasrole
                                <th>{{ 'Phone' }}</th>
                                <th>{{ 'Created By' }}</th>
                                <th>{{ 'Status' }}</th>
                                <th>{{ 'Actions' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($students as $stu)
                                <tr>
                                    <td>
                                        @if (!empty($stu->image))
                                            <img src="{{ asset($stu->image) }}" alt="studentImg" width="85">
                                        @else
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU"
                                                alt="studentImg" width="85">
                                        @endif
                                    </td>
                                    <td>{{ $stu->name }}</td>
                                    <td>{{ $stu->email }}</td>
                                    @hasrole('admin')
                                        <td>{{ $stu->password }}</td>
                                    @endhasrole
                                    <td>{{ $stu->personal_number }}</td>
                                    <td>{{ optional($stu->createby)->name }}</td>

                                    <td>
                                        @php
                                            $statusAction = $stu->status == 'active' ? 'block' : 'active';
                                            $roleBasedUrl = auth()
                                                ->user()
                                                ->hasRole('admin')
                                                ? route('student.statusUpdate', ['id' => $stu->id, 'action' => $statusAction])
                                                : '#';
                                        @endphp

                                        <a href="{{ $roleBasedUrl }}"
                                            onclick="{{ auth()->user()->hasRole('admin')? "return confirm('Are You Sure " . ($stu->status == 'active' ? 'Block' : 'Active') . " This student.')": '' }}">
                                            <span
                                                class="btn btn-{{ $stu->status == 'active' ? 'success' : 'danger' }} btn-sm">
                                                {{ $stu->status == 'active' ? 'Active' : 'Block' }}
                                            </span>
                                        </a>
                                    </td>

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
                    {{ $students->onEachSide(5)->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('script')
@endpush
