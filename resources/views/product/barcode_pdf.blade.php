<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
            margin-left: 12px;
        }

        .label {
            width: 28%;
            padding: 2px;
            box-sizing: border-box;
            text-align: center;
            font-size: 12px;
            
        }

        .barcode {
            margin-top: 7px;
        }

        

        @media print {
            @page {
                margin: 0;
                height: 50px;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    @php
        $totalLabels = ceil($data['quantity'] / 3) * 3;
    @endphp

    @for ($i = 0; $i < $totalLabels; $i += 3)
        <div class="label-row">
            @for ($j = 0; $j < 3; $j++)
                @if ($i + $j < $data['quantity'])
                    <div class="label" style="margin-right: 10px;">
                        <div class="title" style="margin-right: 10px; font-size:10px; font-weight:500;">
                            <strong>{{ $data['product']->name }}</strong>
                        </div>
                        <div class="barcode" style="margin-right: 20px;">
                            {!! DNS1D::getBarcodeHTML($data['product']->code, 'C128', 1, 15) !!}
                        </div>
                        <div class="label-code" style="font-size: 1opx;">
                            <span>{{ $data['product']->code }}</span>
                        </div>
                        {{-- <div style="" style="font-size: 7px;">
                            <span>{{ number_format($data['product']->retail_price) }} MMK</span>
                        </div> --}}
                        <div style="margin-top:100px;"></div>
                    </div>
                @else
                    <div class="label"></div>
                @endif
            @endfor
        </div>
    @endfor

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000); // 1-second delay to ensure full rendering
        };
    </script>
</body>

</html>

