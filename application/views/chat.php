<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Aplikasi Chat Sederhana</title>

	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 m-auto">
				<div id="pesan">
				<?php foreach ($chat as $list): ?>
					<p>
						<span><b><?php echo $list->name ?></b> : </span>
						<span><?php echo $list->message ?></span>
					</p>
				<?php endforeach ?>
				</div>
				<div class="form-group">
					<input type="text" name="name" id="name" class="form-control" placeholder="your name...">
				</div>
				<div class="form-group">
					<input type="text" name="message" id="message" class="form-control" placeholder="your message...">
				</div>
				<div class="form-group">
					<input type="button" value="Send" class="btn btn-primary btn-block" onclick="store()">
				</div>
			</div>
		</div>
	</div>
	<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
	<script>

	    // Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('a5eea230e0177f693063', {
	      cluster: 'ap1',
	      forceTLS: true
	    });

	    var channel = pusher.subscribe('my-channel');
	    channel.bind('my-event', function(data) {
	    	var str = '';
	    	for (var i in data) {
	    		str += `
					<p>
						<span><b><${data[i].name}</b> : </span>
						<span>${data[i].message}</span>
					</p>
	    		`
	    	}

	    	$('#pesan').html(str)
	    });
	</script>
	<script type="text/JavaScript">
		function store() {
			var data = {
				name: $('#name').val(),
				message: $('#message').val(),
			}

			$.ajax({
				url: 'chat/store',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			
		}
	</script>
</body>
</html>