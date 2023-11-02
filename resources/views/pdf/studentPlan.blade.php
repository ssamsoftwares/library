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
    </style>

</head>

<body>
    <div class="container">


        <div class="logo-container">
            <img src="https://i0.wp.com/www.k3library.com/wp-content/uploads/2023/03/k3library-for-self-study-indore-logo.webp?w=500&ssl=1"
                alt="Logo" class="logo">
        </div>
        <div class="receipt">
            <strong style="font-size: 20px; color:#800000; margin-bottom: 50px;">RECEIPT</strong>
        </div>


        <div class="address">
            <span style="text-start"><strong style="font-size: 20px; color:#800000;">K3</strong> LIBRARY & STUDY
                ZONE</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>57- Sheetal Nagar, Behind BCM Heights, Indore (M.P.)</span>
        </div>


        <div class="info-row">
            <span>Name: <b
                    class="bold-text">{{ !empty($student->name) ? $student->name : '----------------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>Date: <?php echo date('Y-m-d'); ?></span>
        </div>


        <div class="contact-info">
            <span>Contact No: <b
                    class="bold-text">{{ !empty($student->personal_number) ? $student->personal_number : '------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;
            <span>Course: <b
                    class="bold-text">{{ !empty($student->course) ? $student->course : '----------------------------------------------------' }}</b></span>
        </div>


        <div class="info-row">
            <span>Validity Start: <b
                    class="bold-text">{{ !empty($student->plan->valid_from_date) ? $student->plan->valid_from_date : '--------------------------------------------' }}</b></span>&nbsp;&nbsp;&nbsp;
            <span>Validity End: <b
                    class="bold-text">{{ !empty($student->plan->valid_upto_date) ? $student->plan->valid_upto_date : '-----------------------------------------' }}
                </b></span>
        </div>


        {{-- <div class="info-row">
            <span>Amount Paid:
                -------------------------------------------------------------------------------------------------------</span>
        </div> --}}
        <div class="info-row">
            <span>Mode: <b
                class="bold-text"> {{ !empty($student->plan->mode_of_payment) ?$student->plan->mode_of_payment : '----------------------------------------------------------------------------'}}</b></span>&nbsp;&nbsp;&nbsp;
            {{-- <span>Last Date for Due Amount: ----------------------------------------------------</span> --}}
        </div>



        <div class="amount">
            RS. <span class="box"> {{!empty($student->payment) ? $student->payment : ''}} </span>
        </div>


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
                <li>Keep our library Neat and Clean.</li>
                <li>Clean up before you Leave.</li>
                <li>Arrange the chair in table Systematically.</li>
                <li>Eating food not allowed inside the Library.</li>
                <li>Work quietly / No loud voice.</li>
                <li>Talking is strictly not allowed in the Library.</li>
            </ul>
        </div>


        <div class="signature">
            <p><b>STUDENT SIGNATURE</b></p>
            <p>NAME: <b class="bold-text">{{ !empty($student->name) ? $student->name : ' --------------------' }}</b>
            </p>
        </div>
</body>

</html>
