<?php

require_once("db_ci.php");
require_once("headcharts.php");
require_once("user_logic.php");
checkUser();

$topcolaborators = getTopColaborators($db);
$topcolaborators = json_encode($topcolaborators, JSON_NUMERIC_CHECK);

?>

<div class="col-md-5">
<label>Top Colaborators</label>
<div id="topcolab-donut"></div>
</div>

<script>
Morris.Donut({
  element: 'topcolab-donut',
  data: <?php echo $topcolaborators; ?>,
    xkey: 'label',
    ykeys: ['value'],
    labels: ['CIs'],
});
</script>

<?php
require_once("foot.php");
?>
     
