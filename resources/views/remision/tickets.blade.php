<!DOCTYPE html>
<html>
	<head>
		<style>
			body {
				font-size: 16px;
				font-family: 'Helvetica', Arial, sans-serif;
				margin: 0;
			}
			.container {
				width: 602px;
				height: 200px;
				margin: 0 auto;
				border-radius: 4px;

                border: 2px solid black;
                border-radius: 10px;
                margin-top: 15px;
                margin-bottom: 15px;
			}
			.column-1 {
				float: left;
				width: 400px;
				height: 200px;
				border-right: 2px dashed black;
			}
			.column-2 {
				float: right;
				width: 200px;
				height: 200px;
			}
			.text-frame {
				padding: 40px;
				height: 120px;
			}
			.qr-holder {
				position: relative;
				width: 160px;
				height: 160px;
				margin: auto;
                margin-top: 10%;
				background-color: #fff;
				text-align: center;
				line-height: 30px;
				z-index: 1;
			}
			.qr-holder > img {
				margin-top: 20px;
			}
			.event {
				font-size: 24px;
				color: black;
				letter-spacing: 1px;
			}
			.date {
				font-size: 18px;
				line-height: 30px;
				color: black;
			}
			.name,
			.ticket-id {
				font-size: 16px;
				line-height: 22px;
				color: black;
			}
		</style>
	</head>
	<body>

        @foreach ($pallet as $item)
		<div class="container">
			<div class="column-1">
				<div class="text-frame">
					<div class="event">{{ $item->producto }}</div>
					<div class="date">{{ date('d M, Y', strtotime($item->fecha_recibido)) }}</div>
					<br />
					<div class="name">{{ $item->chofer }}</div>
					<div class="ticket-id">#{{ $item->id }}</div>
				</div>
			</div>

			<div class="column-2">
				<div class="qr-holder">
                    <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::format('svg')->size(120)->generate($item->id)); !!}">
                {{--     <img src="data:image/png;base64, {!! base64_encode(QrCode::size(120)->generate($item->id)) !!} ">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate('http://google.com')) !!} ">
 --}}
{{--  <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) }} "> --}}
				</div>
			</div>
		</div>
        @endforeach
	</body>
</html>