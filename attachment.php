<?php 
require_once("db_ci.php");
$ciid = 74;
$rows = getAttachments($db, $ciid);
					foreach ($rows as $row) {
					?>
					<a href="download.php?id=<?=$row['id']?>"><?=$row['name']?> </a> <?php echo '<input readonly type="text" class="form-control" value="http://localhost/ibox/download.php?id='.$row['id'].'">'?><br>
<?php
}
?>