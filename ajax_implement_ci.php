<?php 
require_once("db_ci.php");
$customers = getInfoAll($db, 'customers');
?>

    <div class="col-md-12 well">
        <div class="row">
            <form  action="implement_ci.php" method="post">
              <input type="hidden" name="ciid" value="<?=$_POST['ciid']?>">
                <div class="col-md-3">
                <label>Customer</label>
                <select required class="form-control" name="customer">
                    <option>Select an account</option>
                    <?php foreach($customers as $customer) :?>
                    <option value="<?=$customer['code']?>"><?=$customer['name']?></option>
                    <?php endforeach; ?>
                </select>
               </div>
                <div class="col-md-2">
                 <label>Saving (FTE)</label>
                 <input required class="form-control" type="number" step="0.1" min='0' name="saving">
                </div>
                <div class="col-md-5">
                 <label>Comment</label>
                 <input required type="text" name="comment" class="form-control">
                </div>
                <div class="col-md-1" style="color: white;">
                    <label>_</label>
                    <button type="submit" class="btn btn-warning">Implement</button>
                </div>
            </form>
        </div>
    </div>
