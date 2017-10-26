<?php 
require_once("db_ci.php");

	$string =  implode(",", $_POST);
	$tool = substr($string, 0, strpos($string, ','));
	$ciid = substr($string, strpos($string, ",") + 1);

	$compids = getComponentsIds($db, $ciid);
	$compstring = "";
	foreach ($compids as $compid) {
		$compstring = $compstring.",".$compid['components_id'];
	}

	if($tool != ""){
	$components = getComponents($db, $tool);
?>
                  
                      <?php
                      foreach($components as $component) :
                      if(in_array($component['id'], explode(',', $compstring))){
                      	$checked = "checked";
                      }else{
                      	$checked = "";
                      }
                      ?>
                  	  <div class="col-md-2">
                      <div class="checkbox">
                      <label>
                      <input name="component[]" type="checkbox" value="<?=$component['id']?>" <?=$checked?>><?=$component['component']?>
                      </label>
                      </div>
                      </div>
                      <?php endforeach; } 

#$thisIstheCustomer = $customer_code == $customer['code'];
#			$selectcust =  $thisIstheCustomer ? "selected='selected'" : "";
                      ?>

