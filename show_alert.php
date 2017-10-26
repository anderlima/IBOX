<?php
session_start();

function showAlert($type) {
	if(isset($_SESSION[$type])) {
?>
		<p align="center" style="width: 99.9%; text-align: center" class="alert-<?= $type ?>"><b><?= $_SESSION[$type]?></b></p>
<?php
		unset($_SESSION[$type]);
	}
}