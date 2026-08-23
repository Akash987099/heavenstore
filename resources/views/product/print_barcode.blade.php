<!DOCTYPE html>
<html>

<head>

    <title>Print Barcode</title>

    <style>
        body {
            text-align: center;
        }

        .barcode-box {
            display: inline-block;
            margin: 20px;
        }
    </style>

</head>

<body onload="window.print()">

    @foreach ($products as $item)
        <div class="barcode-box">

            <img src="{{$item->barcode_base}}">

        </div>
    @endforeach

</body>

</html>
