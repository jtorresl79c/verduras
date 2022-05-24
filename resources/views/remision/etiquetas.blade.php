<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ETIQUETA</title>
  <link href="labels.css" rel="stylesheet" type="text/css">
  <style>
    .print {visibility:visible;}
    @media print {
        #header, #navbar, #navbar, #toolbar, #footer, .title {
        display:none !important;
        } 
    }
    .imagen-qr {
    background: #dadada;
    height: 50px;
    width: 50px;
    padding-right: 10px;
    }
    .informacion {
    margin-top: 0;
    }
    .peso{
        index:1;
        margin-top:-30px;
    }
  </style>
</head>
<body onload="printFunction();">
    @foreach ($pallet as $item)
        <div style="clear: both;">
          <div style="float: left;">
            <img class="imagen-qr" src="data:image/svg+xml;base64, {!! base64_encode(QrCode::format('svg')->size(80)->generate($item->id)); !!}">
        </div>
            <p class="informacion">
                {{ $item->producto }} 
            </p> 
        </div>
    @endforeach 
</body>
<script type="text/javascript">
	window.onload = function() { window.print(); }
</script>
</html>