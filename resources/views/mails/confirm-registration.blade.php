<!Doctype html>
<html>
	<head>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	</head>
	<body>
			<h2>Welcome To CLLR Trading</h2>
			<p>Please confirm your registration to the link below.</p>
			<p>{{ url('/confirm/' . $code) }}</p>
			<hr>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum veniam, praesentium et eos porro maxime cumque, omnis aliquid cupiditate impedit modi consequuntur repudiandae necessitatibus animi vel culpa ab tenetur deserunt.</p>
	</body>
</html>
