<?php
require('core.inc.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		login($username, $password);
		echo 'Incorrect username or password.';
	} else {
		echo 'Please enter username and password.';
	}
}
?>
<head>
	<title>PP | Home</title>
	<?php
		css('login');
	?>
</head>
<body>
	<?php
		page_header();
	?>
	<div class="content">
		<form action="login.php" method="POST">
			<table>
			<input type="text" name="username" placeholder="username">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" value="Log In">
			</table>
		</form>
	</div>
</body>