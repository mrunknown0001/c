<!Doctype html>
<html>
	<head>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	</head>
	<body>
			<h2>CLLR Trading</h2>
			<p>Click the link to reset your password.</p>
			<hr>
			<p>{{ url('password/reset/token/' . $token) }}</p>
			<hr>
			
	</body>
</html>
