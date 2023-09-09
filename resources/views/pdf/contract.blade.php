<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;500&display=swap" rel="stylesheet">
    <title>Contract</title>

    <style>
        @font-face {
            font-family: 'Dancing Script';
            font-style: normal;
            font-weight: 400;
            src: url('{{storage_path('fonts/DancingScript-VariableFont_wght.ttf')}}') format('truetype');
        }

        .roboto{
            font-family: 'Roboto', sans-serif; /*100,300,500*/
        }

        .spanBold{
            font-weight: 500;font-size: 14px
        }

        @page {
            margin:0;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            padding: 0;
            border: 0
        }
        *, body, html {
            font-family: Raleway, sans-serif
        }
        body {
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-after: always;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            line-height: 1.5rem;
            width: 100%;
            z-index: -1;
        }

        .footer .left-line{
            position: fixed;
            left: 10px;
            bottom: 10px;
            width: 50%;
            height: 45px;
            background-color: #00482C;
            margin-left: 10px;
        }
        .footer .right-line{
            position: fixed;
            right: 10px;
            bottom: 10px;
            width: 50%;
            height: 45px;
            background-color: #00FAFF;
            margin-right: 10px;
        }

        .footer .center-line{
            position: fixed;
            left: 30%;
            bottom: 10px;
            right: 30%;
            width: 40%;
            height: 45px;
            background-color: #009C23;
            transform: skewX(45deg);
            border-left: 1px;
            border-bottom: 1px;
            transform-origin: top left;
            box-sizing:border-box;
        }

        .footer .dot{
            position: fixed;
            right: 30px;
            bottom: 20px;
            background-color: #00FAFF;
            height: 70px;
            width: 70px;
            border-radius: 50%;
            display: inline-block;
            z-index: 3;
        }


        .page{
            padding: 10px 10px 0;
        }


        #Page1 .line-header{
            width: 100%;
            height: 40px;
            background-color: #007f15;
        }

        #Page1 .logo-table{
            width: 90%;
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body style="margin: 0">
    <div class="footer">
        <span class="dot">

        </span>
        <div class="left-line"></div>
        <div class="right-line"></div>
        <div class="center-line"></div>
    </div>

    <div class="page page-break" id="Page1">
        <div class="line-header"> </div>
        <br>
        <table class="logo-table">
            <tr>
                <td style="text-align: left">
                    <img src="https://img.freepik.com/free-vector/bird-colorful-logo-gradient-vector_343694-1365.jpg?w=740&t=st=1692625306~exp=1692625906~hmac=9224578c736d50aacf074162c207cf0b4527069b39b5c90cc997e3ef7e7b1e01" style="width: 150px; height: 150px">
                </td>
                <td style="text-align: right">
                    <img src="https://img.freepik.com/free-vector/bird-colorful-logo-gradient-vector_343694-1365.jpg?w=740&t=st=1692625306~exp=1692625906~hmac=9224578c736d50aacf074162c207cf0b4527069b39b5c90cc997e3ef7e7b1e01" style="width: 150px; height: 150px">
                </td>
            </tr>
        </table>
        <br>
        <p style="color: red; font-size: 18px; font-weight: bold; text-align: center" >يعتبر هذا العقد عقًدا موثًقا وسنًدا تنفيذًيا بموجب قرار مجلس الوزراء رقم(١٣١) و تاريخ ١٤٣٥/٤/٣ هـ</p>
        <table class="">

        </table>
    </div>

    <div class="page page-break" id="Page2">
        <div class="a7a">zoka </div>

    </div>
    <div class="page page-break" id="Page3">
        <div class="a7a">zoka </div>

    </div>
    <div class="page page-break" id="Page4">
        <div class="a7a">zoka </div>
    </div>
</body>
</html>
