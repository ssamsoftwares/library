@extends('layouts.main')

@push('page-title')
    <title>{{ __('Add Asign Plan') }}</title>
@endpush

@push('heading')
    {{ __('Asign Plan') }}
@endpush

@section('content')
    <x-status-message />

    {{-- {{
        print_r(session()->all());
    }} --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-3">{{ __('Fill the Details') }}</h4>

                    <div class="row">
                        <form action="{{ route('plan.add') }}" method="get">
                            {{-- @csrf --}}
                            <div class="col-lg-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="student_search"
                                        placeholder="Search Student ...... Aadhar Number"
                                        value="{{ isset($_REQUEST['student_search']) ? $_REQUEST['student_search'] : '' }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Search</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        @if (!empty($student))
                            <hr>
                            <div class="col-md-12">
                                <div class="selected_student d-flex justify-content-evenly bd-highlight">
                                    <p><b>Name :</b> {{ $student->name }}</p>
                                    <p><b>Email :</b> {{ $student->email }}</p>
                                    <p><b>Phone : </b> {{ $student->personal_number }}</p>
                                    <p><b>Aadhar Number : </b> {{ $student->aadhar_number }}</p>
                                </div>
                            </div>
                            <hr>
                        @endif
                    </div>
                    <form method="post" action="{{ route('plan.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ !empty($student) ? $student->id : '' }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.select name="plan" label="Plan" chooseFileComment="--Select Plan--"
                                    :options="[
                                        'plan1' => 'Plan1',
                                        'plan2' => 'Plan2',
                                        'plan3' => 'Plan3',
                                    ]" />

                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="mode_of_payment" label="Mode of Payment" type="text" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="valid_from_date" label="Valid From Date" type="date"
                                    value="<?php echo date('Y-m-d'); ?>" />
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="valid_upto_date" label="Valid Upto Date" type="date"
                                    value="<?php echo date('Y-m-d'); ?>" />
                            </div>
                        </div>

                        <div>
                            <a href="javascript:void(0)" id="downloadPdf" class="btn btn-info">Download PDF</a>
                            @if (session()->get('pdfDownload') == 'downloaded')
                                <button class="btn btn-primary" type="submit"
                                    @if ($fieldDisable == 'true') disabled @endif>{{ __('Asign Plan') }}</button>
                            @endif

                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#downloadPdf').on('click', function() {

                window.location.href = "{{ route('plan.downloadPdf') }}";

                setTimeout(() => {
                    location.reload()
                }, 1000);
                // $.ajax({
                //     type: "get",
                //     url: "{{ route('plan.downloadPdf') }}",
                //     success: function(response) {
                //         console.log(response);
                //     }
                // });
            })
        });
    </script>
@endpush
