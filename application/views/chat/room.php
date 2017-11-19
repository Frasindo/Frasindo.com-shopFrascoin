<!DOCTYPE html>
<html>
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Title -->
		<title><?= $judul ?></title>

		<!-- CSS -->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- Emoji Data -->
		<link href="//onesignal.github.io/emoji-picker/lib/css/emoji.css" rel="stylesheet">
		<!-- chat_realtime -->
		<link href="<?= base_url("assets/chat/chat_realtime.css") ?>" rel="stylesheet">

	</head>
	<body>
		<div class="container">
			<div id="chat-realtime">
				<div class="row">
					<div class="col-md-8 col-md-offset-2" id="login">
						<div class="login">
							<form id="loginform">
								<div class="input-group">
									<span class="input-group-addon">@</span>
									<input class="form-control border no-shadow no-rounded" id="username" placeholder="username" required>
								</div>
								<div class="input-group">
									<span class="input-group-addon">Avatar</span>
									<input class="form-control border no-shadow no-rounded" id="avatar" placeholder="http://img.com/anu.jpg" value="http://3.bp.blogspot.com/-c8O1QI1Ty24/UikpRn-WYLI/AAAAAAAAJ0Y/hCd3SVMejGQ/s1600/1cc767a412f68bc6ff6f26b526c4ecfd.jpeg" required>
									<span class="input-group-btn">
									<button class="btn btn-primary no-rounded" type="submit">Login</button>
									</span>
								</div>
							</form>
							<div id="status">
							</div>
						</div>
					</div>
					<!-- selected chat -->
					<div class="col-md-12" id="main">
						<h3><img id="avatarlogin" src=""/> <span id="userlogin"></span><a href="#" style="float: right" id="logout" class="btn btn-danger no-rounded">Logout</a></h3>
						<div class="col-md-4 bg-white">
							<h4>Users</h4>
							<!-- users list -->
							<ul class="users-list">
							</ul>
							<h4>Rooms</h4>
							<ul class="public-list">
								<li id="public" class="user bounceInDown active" data-tipe="rooms">
								<a href="#" class="clearfix">
								<img src="" alt="" class="img-circle">
								<div class="public-name">
									<strong></strong>
								</div>
								<div class="last-message msg">
									Write something..
								</div>
								<small class="time text-muted">Just now</small>
								<small class="chat-alert label label-primary">0</small>
								</a>
								</li>
							</ul>
						</div>
						<!-- rooms list -->
						<div class="col-md-8">
							<ul class="chat">
							</ul>
							<div class="chat-box">
								<form>
									<div class="input-group">
										<input id="message" type="text" data-emojiable="true" class="form-control border no-shadow no-rounded" placeholder="Type your message here">
										<span class="input-group-btn">
											<button class="btn btn-success no-rounded" id="send" type="submit">Send</button>
										</span>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<p align="center">
							© <a href="http://bachors.com">Bachors.com</a> 2016-2017. Made with <span class="fa fa-heartbeat" style="color:#f66767"></span> in Garut, Indonesia.
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Firebase -->
		<script src="//www.gstatic.com/firebasejs/3.9.0/firebase.js"></script>
		<script src="//www.gstatic.com/firebasejs/3.9.0/firebase-app.js"></script>
		<script src="//www.gstatic.com/firebasejs/3.9.0/firebase-database.js"></script>
		<!-- jQuerya -->
		<script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.min.js"></script>
		<!-- emoji-picker -->
		<script type="text/javascript" src="//onesignal.github.io/emoji-picker/lib/js/config.js"></script>
		<script type="text/javascript" src="//onesignal.github.io/emoji-picker/lib/js/util.js"></script>
		<script type="text/javascript" src="//onesignal.github.io/emoji-picker/lib/js/jquery.emojiarea.js"></script>
		<script type="text/javascript" src="//onesignal.github.io/emoji-picker/lib/js/emoji-picker.js"></script>
		<!-- chat_realtime -->
		<script type="text/javascript" src="<?= base_url("assets/chat/config.js") ?>"></script>
		<script type="text/javascript" src="<?= base_url("assets/chat/chat_realtime.js") ?>"></script>
		<script>
		$(function(){

			var userlogin = false;

			// cek user	session
			$.ajax({
				url: apis,
				data: {
					data: 'cek'
				},
				type: "post",
				crossDomain: true,
				dataType: 'json',
				success: function(a) {
					if (a.status == 'success') {
							var x = new Date(),
								b = x.getDate(),
								c = (x.getMonth() + 1),
								d = x.getFullYear(),
								e = x.getHours(),
								f = x.getMinutes(),
								g = x.getSeconds(),
								date = d + '-' + (c < 10 ? '0' + c : c) + '-' + (b < 10 ? '0' + b : b) + ' ' + (e < 10 ? '0' + e : e) + ':' + (f < 10 ? '0' + f : f) + ':' + (g < 10 ? '0' + g : g);
							var h = {
								name: a.user,
								avatar: a.avatar,
								login: date,
								tipe: 'login'
							};
							userRef.push(h);
						$('#login').hide();
						$('#main').show();
						document.querySelector('#avatarlogin').src = a.avatar;
						userlogin = a.user;
						$('#userlogin').html(a.user);
						document.querySelector('#public strong').innerHTML = a.user;
						document.querySelector('#public img').src = a.avatar;
						chat_realtime(userRef, messageRef, apis, a.user, a.avatar)
					}
				}
			});

			// user login
			$('#loginform').submit(function(e) {
				e.preventDefault();
				$('#status').html('<center>Wait...</center>');
				var i = $('#username').val(),
					avatar = $('#avatar').val();
				if (i != '' && avatar != '') {
					$.ajax({
						url: apis,
						data: {
							data: 'login',
							name: i,
							avatar: avatar
						},
						type: "post",
						crossDomain: true,
						dataType: 'json',
						success: function(a) {
							if (a.status == 'success') {
								var x = new Date(),
									b = x.getDate(),
									c = (x.getMonth() + 1),
									d = x.getFullYear(),
									e = x.getHours(),
									f = x.getMinutes(),
									g = x.getSeconds(),
									date = d + '-' + (c < 10 ? '0' + c : c) + '-' + (b < 10 ? '0' + b : b) + ' ' + (e < 10 ? '0' + e : e) + ':' + (f < 10 ? '0' + f : f) + ':' + (g < 10 ? '0' + g : g);
								var h = {
									name: i,
									avatar: avatar,
									login: date,
									tipe: 'login'
								};
								userRef.push(h);
								window.location.reload()
							} else {
								$('#status').html("<div class='alert alert-danger'>Username sudah di pakai.</div>")
							}
						}
					})
				} else {
					alert('Form input ada yang belum di isi')
				}
			});

			// user logout
			$('#logout').on('click', function(e) {
				e.preventDefault();
				$.ajax({
					url: apis,
					data: {
						data: 'logout'
					},
					type: "post",
					crossDomain: true,
					dataType: 'json',
					success: function(a) {
						if (a.status == 'success') {
							var b = {
								name: userlogin,
								tipe: 'logout'
							};
							userRef.push(b);
							setTimeout( function() {
								window.location.reload();
							}, 1500 );
						}
					}
				})
			});

			// emojiPicker
			window.emojiPicker = new EmojiPicker({
				emojiable_selector: '[data-emojiable=true]',
				assetsPath: '//onesignal.github.io/emoji-picker/lib/img/',
				popupButtonClasses: 'fa fa-smile-o'
			});
			window.emojiPicker.discover();

		});
		</script>
	</body>
</html>
