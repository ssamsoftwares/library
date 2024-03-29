<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RECEIPT</title>

    <style>
        body {
            font-family: Georgia, Times, "Times New Roman", serif;
            font-size: 15px;
            margin: 0em 0em;
            padding: 0px;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            text-align: center;
        }

        .logo {
            width: 120px;
            text-align: center;
        }

        .receipt {
            text-align: center;
            margin: 20px;
        }

        .library-info {
            text-align: center;
            color: #800000;
        }

        .library-name {
            font-size: 24px;
            font-weight: bold;
            color: #800000;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .note h3,
        .rules h3 {
            font-size: 18px;
            text-align: center;
        }

        .signature {
            text-align: right;
            margin-top: 40px;
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
        }

        .rule-list {
            list-style-type: decimal;
            padding-left: 20px;
            margin: 5px 0;
        }

        .authorised-signature {
            text-align: right;
        }

        /* .bold-text {
            font-weight: bold;
        } */

        .address {
            text-align: left;
            font-size: 15px;
            font-weight: bold;

        }

        .amount {
            display: flex;
            margin: 20px 0px 15px 5px;
            font-size: 20px;
            font-weight: bold;
        }

        .box {
            border: 1px solid rgb(40, 39, 39);
            padding: 10px 100px;
            margin: 20px 0px 15px 5px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            align-content: center;
        }

        .photo-container {
            position: absolute;
            top: 5px;
        }

        .student-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;

        }
    </style>

</head>

<body>
    <div class="container">
        <div class="container">
            <div class="header">
                @if (!empty($plan->student->image))
                    <div class="photo-container">
                        <img src="https://manage.k3library.com/{{ $plan->student->image }}" alt="Student Photo"
                            class="student-photo">
                    </div>
                @else
                    <div class="photo-container">
                        <img src="https://png.pngtree.com/png-vector/20210604/ourmid/pngtree-gray-avatar-placeholder-png-image_3416697.jpg"
                            alt="Student Photo" class="student-photo">
                    </div>
                @endif

                <div class="logo-container">
                    {{-- <img src="https://i0.wp.com/www.k3library.com/wp-content/uploads/2023/03/k3library-for-self-study-indore-logo.webp?w=500&ssl=1"
                        alt="Logo" class="logo"> --}}
                    <img src="https://manage.k3library.com/assets/images/logo2.jpeg" alt="Logo" class="logo">
                </div>

            </div>

            <div class="receipt">
                <strong style="font-size: 20px; color:#800000; margin-bottom: 50px;">RECEIPT</strong>
            </div>
        </div>

        <div class="address">
            <span style="text-start"><strong style="font-size: 20px; color:#800000;">K3</strong> LIBRARY & STUDY
                ZONE</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>57- Sheetal Nagar, Behind BCM Heights, Indore (M.P.)</span>
        </div>


        <div class="info-row">
            <span>Name: <b
                    class="bold-text">{{ !empty($plan->student->name) ? $plan->student->name : '----------------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>Date: <?php echo date('d-m-Y'); ?></span>
        </div>


        <div class="contact-info">
            <span>Contact No: <b
                    class="bold-text">{{ !empty($plan->student->personal_number) ? $plan->student->personal_number : '------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;
            <span>Course: <b
                    class="bold-text">{{ !empty($plan->student->course) ? $plan->student->course : '----------------------------------------------------' }}</b></span>
        </div>

        <div class="info-row">
            <span>Validity Start: <b
                    class="bold-text">{{ !empty($formattedValidFromDate) ? $formattedValidFromDate : '--------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;
            <span>Validity End: <b
                    class="bold-text">{{ !empty($formattedValidUptoDate) ? $formattedValidUptoDate : '-----------------------------------------' }}
                </b></span>
        </div>


        {{-- <div class="info-row">
            <span>Validity Start: <b class="bold-text">{{ !empty($student->plan->valid_from_date) ? $student->plan->valid_from_date->format('d-m-Y') : '--------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;
            <span>Validity End: <b class="bold-text">{{ !empty($student->plan->valid_upto_date) ? $student->plan->valid_upto_date->format('d-m-Y') : '-----------------------------------------' }}
                </b></span>
        </div> --}}


        {{-- <div class="info-row">
            <span>Amount Paid:
                -------------------------------------------------------------------------------------------------------</span>
        </div> --}}

        <div class="info-row">
            <span>Library Branch:
                <b class="bold-text"> {{ !empty($plan->library_branch) ? $plan->library_branch : '----------------------------------------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;</span>
        </div>


        <div class="info-row">
            <span>Mode: <b class="bold-text">
                    {{ !empty($plan->mode_of_payment) ? $plan->mode_of_payment : '----------------------------------------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;
            {{-- <span>Last Date for Due Amount: ----------------------------------------------------</span> --}}
        </div>

        {{-- <div class="amount">
            RS. <span class="box"> {{!empty($student->payment) ? $student->payment : ''}} </span>
        </div> --}}


        <div class="info-row">
            <span><b>Call:</b> 8103144388, 6266447615</span><br>
            <span><b>Email:</b> k3iasindore@gmail.com</span>
        </div>


        <div class="authorised-signature">
            <p><b>AUTHORISED SIGNATURE</b></p>
        </div>


        <div class="note">
            <h3>Note</h3>
            <ul class="rule-list">
                <li>Fees is Not Refundable / Transferable / Adjustable in any case.</li>
                <li>Fees once paid is not Refundable in any case.</li>
                <li>Fees paid is not Transferable to another students.</li>
                <li>Fees paid for a particular course will be valid till the duration of that particular course.</li>
                <li>Fees paid is not Adjustable to another course.</li>
            </ul>
        </div>


        <div class="rules">
            <h3 class="text-center"><strong style="font-size: 25px; color:#800000;">K3</strong> LIBRARY RULES</h3>
            <ul class="rule-list">
                <li>Keep library Neat and Clean.</li>
                <li>Clean up before you Leave.</li>
                <li>Arrange the chair in table Systematically.</li>
                <li>Eating food not allowed inside the Library.</li>
                <li>Work quietly / No loud voice.</li>
                <li>Talking is strictly not allowed in the Library.</li>
            </ul>
        </div>


        <div class="signature">
            <p><b>STUDENT SIGNATURE</b></p>
            <p>NAME: <b
                    class="bold-text">{{ !empty($plan->student->name) ? $plan->student->name : ' --------------------' }}</b>
            </p>
        </div>
</body>

</html>
