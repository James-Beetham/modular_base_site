<?php
/**
 *
 */


session_start();
ob_start();

// Sets rank to unauth if not logged in
if (!isset($_SESSION['rank']) || empty($_SESSION['rank'])) {
	$_SESSION['rank'] = 'unauth';
}


// Connects to database specified 
function connect($def_database = 'default') {
	require('site.conf');
	if (!mysql_connect($databases['mysql_host'], $databases['mysql_user'], $databases['mysql_pass']) || !mysql_select_db($databases['mysql_db_default'])) {
		die('Could not connect to database.');
	}
}

function login($username, $password, $def_database = null) {
	connect($def_database);
	$query = "SELECT `id`, `rank` FROM `users` WHERE `username`='$username' AND `password`='$password'";
	$query_run = mysql_query($query);
	if (mysql_num_rows($query_run)) {
		$query_results = mysql_fetch_assoc($query_run);
		$_SESSION['rank'] = $query_results['rank'];
		$_SESSION['username'] = $username;
		$_SESSION['id'] = $query_results['id'];
		require('site.conf');
		header('Location: ' . $site_home . 'profile.php');
	}
}

function create_account() {

}

function headerlink_darken($page) {
	$output = 'style="background-color:';
	$page = $page . '.php';
	if ($page == basename($_SERVER['PHP_SELF'])) {
		echo 'style="background-color:#27323D" ';
	}
}

function page_header($page = 'default') {
	switch($page) {
		case 'default':
			echo '
				<div class="header">
					<a id="logoname_link" href="index.php"><h1 id="logoname_text" style="text-align:left;margin-top:0px;display:inline;">Perplexed</h1></a>
					<ul style="display:inline;">
			';
			if($_SESSION['rank'] != 'unauth') {
				echo '<li style="float:right;"><a id="headerlink" href="logout.php">Log Out</a></li>';
			} else {
				echo '<li style="float:right;"><a id="headerlink" ';
				headerlink_darken('login');
				echo 'href="login.php">Log In</a></li>';
			}
			echo '
						<li style="float:right;"><a id="headerlink" ';
						headerlink_darken('profile');
						echo 'href="profile.php">Profile</a></li>
						<li style="float:right;"><a id="headerlink" ';
						headerlink_darken('info');
						echo 'href="info.php">Info</a></li>';
			if ($_SESSION['rank'] == 'admin' || $_SESSION['rank'] == 'mod') {
				echo '<li style="float:right;"><a id="headerlink" ';
				headerlink_darken('users');
				echo 'href="users.php">Users</a></li>';
			}
			echo '
					</ul>
				</div>
			';
		break;
		case 'home':

		break;
	}
}

function css($page = 'default') {
	echo '<link rel="stylesheet" type="text/css" href="css/default.css"/>';
	switch($page) {
		case 'default':

		break;
		case 'home':
			echo '<link rel="stylesheet" type="text/css" href="css/home.css"/>';
		break;
	}
}