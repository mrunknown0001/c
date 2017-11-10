<!Doctype html>
<html>
	<head>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	</head>
	<body>
			<h2>Welcome To CLLR Trading</h2>
			<p>Please confirm your registration to the link below.</p>
			<hr>
			<p>{{ url('/confirm/' . $code) }}</p>
			<hr>
			
	</body>
</html>
