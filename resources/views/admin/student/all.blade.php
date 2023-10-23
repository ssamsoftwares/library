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
            <x-search.table-search action="{{ route('students') }}" method="get" name="search"  value="{{isset($_REQUEST['search'])?$_REQUEST['search']:''}}"
            btnClass="search_btn"/>
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ 'Photo' }}</th>
                            <th>{{ 'Name' }}</th>
                            <th>{{ 'Email' }}</th>
                            <th>{{ 'Phone' }}</th>
                            <th>{{ 'Actions' }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($students as $stu)
                        <tr>
                            <td>
                                @if (!empty($stu->image))
                                <img src="{{asset($stu->image)}}" alt="studentImg" width="85">
                                @else
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ799fyQRixe5xOmxYZc3kAy6wgXGO-GHpHSA&usqp=CAU" alt="studentImg" width="85">
                                @endif
                            </td>
                            <td>{{ $stu->name }}</td>
                            <td>{{ $stu->email }}</td>
                            <td>{{ $stu->personal_number }}</td>

                            <td>
                                <div class="action-btns text-center" role="group">

                                    <a href="{{ route('student.view', ['student' => $stu->id]) }}"
                                        class="btn btn-primary waves-effect waves-light view">
                                        <i class="ri-eye-line"></i>
                                    </a>

                                    <a href="{{ route('student.edit',['student'=> $stu->id ]) }}" class="btn btn-info waves-effect waves-light edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
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
