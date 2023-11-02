@extends('layouts.main')

@push('page-title')
    <title>{{ __('Add Asign Plan') }}</title>
@endpush

@push('heading')
    {{ __('Asign Plan') }}
@endpush

@section('content')
    <x-status-message />

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
                                        placeholder="Search Student ...... Email, Phone & Aadhar Number"
                                        value="{{ isset($_REQUEST['student_search']) ? $_REQUEST['student_search'] : (old('student_search') ? old('student_search') : '') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Search</button>
                                    </div>
                                    @error('student_search')
                                        <div class="text-danger form-text">{{ $message }}</div>
                                    @enderror
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
                                    min="<?php echo date('Y-m-d'); ?>" />
                            </div>
                        </div>

                        <div>
                            <button type="button" id="downloadPdf" class="btn btn-info"
                                {{ session()->has('pdfDownloadBtn') ? session()->get('pdfDownloadBtn') : $pdfDownloadBtn }}>Download
                                PDF</button>

                            <button class="btn btn-primary" id="assignBtn" type="submit"
                                {{ session()->has('assignButton') ? session()->get('assignButton') : $assignButton }}>{{ __('Asign Plan') }}</button>
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
            let assignBtn = $('#assignBtn')

            $('#downloadPdf').on('click', function() {
                let btn = $(this)
                let studentId = $('input[name="student_id"]').val();

                if (!studentId) {
                    alert("Please search for a student first.");
                    return;
                }

                btn.attr("disabled", true);
                btn.html("Please wait...");
                $.ajax({
                    type: "get",
                    url: '/download-pdf/' + studentId,

                    success: function(response) {
                        // assignBtn.attr('disabled', false)
                        window.open('/download-pdf/' + studentId);
                        // btn.attr("disabled",false);
                        btn.html("Download PDF");
                    }
                });
            })

        });
    </script>
@endpush
