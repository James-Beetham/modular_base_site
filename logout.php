<?php
ob_start();
session_start();
session_destroy();
require('site.conf');
header('Location: ' . $site_home . 'index.php');
?>