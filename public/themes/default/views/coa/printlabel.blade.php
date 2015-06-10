<html>
<head>
    <title>Delivery Slip</title>

<style type="text/css">
    body{
        font-size: {{ $font_size }}pt;
        background-color:white;
        padding-top: {{ $top_offset}}px;
        padding-left: {{ $left_offset}}px;
    }
    .label{
        float: left;
        font-family: Arial, sans-serif;
        max-height: {{ $cell_height }}px;
        min-height: {{ $cell_height }}px;
        height: {{ $cell_height }}px;

        max-width: {{ $cell_width }}px;
        min-width: {{ $cell_width }}px;
        width: {{ $cell_width }}px;

        margin-right: {{ $margin_right }}px;
        margin-bottom: {{ $margin_bottom }}px;
        display: table-cell;

        border: thin ridge #ddd;
        padding: 0px;/* add padding offset = padding * column count */
    }

    @media print {
        .label{
            border: none;
        }
    }

    .label table{
        width: 100%;
        height: 100%;
        border: none;
        font-size: {{ $font_size; }}pt;
        padding: 0px;
        margin: 0px;
    }

    h3{
        margin: 4px 10px;
        font-size: 1.1em;
    }

    tr{
        padding:0px;
    }

    td{
        padding: 0px;
        font-size: .8em;
        word-wrap: break-word;
    }

    p{
        margin-bottom: 4px;
        margin-top: 4px;
    }

    p.shipping{
        word-wrap:break-word;
        @if($code_type == 'barcode')
            display: inline-block;
        @endif
        max-width: {{ $cell_width; }}px;
    }

    img.barcode{
        max-width: 98%;
        width: 98%;
        height:auto;
        margin: 0px;

    }

    img.qr{
        max-width: 80px;
        height:auto;
    }

    .code-container{
        display: inline-block;
        float: left;
    }

    img.logo{
        max-height:25px;
    }

    <?php
        $container = ($cell_width * $columns) + ($margin_right * $columns) + $margin_right + ( 4 * $columns ) + 20;
    ?>

    #container{
        width: {{ $container; }}px;
        max-width: {{ $container; }}px;
        display: block;
    }

</style>
</head>
<body>
<div id="container">

@foreach( $labels as $l )
    <?php $pd = $products[ $l['SKU'] ]; ?>
    <div class="label">
        <table>
            <tr>
                <td style="text-align:center">
                    @if($code_type == 'qr')
                        <img src="{{ URL::to('qr/'.urlencode(base64_encode($l['SKU'])) ) }}" class="barcode" alt="{{ $l['_id'] }}" />
                    @else
                        <img src="{{ URL::to('pdf417/'.urlencode(base64_encode($l['SKU'])) ) }}" class="barcode" alt="{{ $l['_id'] }}" />
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    {{ $pd['SKU']}}
                </td>
            </tr>
        </table>
    </div>
<?php endforeach; ?>

</div>

</body>
</html>
