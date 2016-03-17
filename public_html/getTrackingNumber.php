<?php
require_once 'functions.php';

$id;

function setTN() {
	global $id;
	$id = getTrackingNum();
}

function shareTN() {
	global $id;
	return $id;
}
?>

