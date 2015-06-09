<?php
require '../../../php_scripts/session.php';
?>
<!-- START SCRIPTS ******************************************************************************************************** -->
<script src="../../../javascript/jquery.inputlimiter.1.3.1.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
    $(".datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		showAnim: "slide",
	});
});
</script>

<script>
// RUNS ISNUMBER FUNCION WHEN KEY PRESSED
$(document).ready(function() {
    $(".valid_numbers").keypress(function(event) { return isNumber(event) });
});

// THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)){
		 return false;
	}
 	return true;
}    
</script>

<script>
// FUNCTION THAT LIMITS AMOUNT OF CHARACTERS USER CAN ENTER
function inputlimiter() {
	$('#job_code').inputlimiter({
		limit: 30,
		limitText: '',
		remText: ''
	});
	$('#job_title').inputlimiter({
		limit: 150,
		limitText: '',
		remText: ''
	});
	$('#company').inputlimiter({
		limit: 50,
		limitText: '',
		remText: ''
	});
	$('#mod_start').inputlimiter({
		limit: 10,
		limitText: '',
		remText: ''
	});
	$('#mod_end').inputlimiter({
		limit: 10,
		limitText: '',
		remText: ''
	});
	$('#fund').inputlimiter({
		limit: 11,
		limitText: '',
		remText: ''
	});
	$('#profit').inputlimiter({
		limit: 5,
		limitText: '',
		remText: ''
	});
}
</script>
<!-- END SCRIPTS ******************************************************************************************************** -->

<div id="create_job">
	<div class="buttons">
		<input title="Create Job" type="button" class="add_icon" alt="Create"  onclick="validate_form()">
    	<input title="Cancel" type="button" class="cancel_icon" alt="Cancel" onclick="cancel_create_job()">
    </div>
	<table>
    <tr>  
    	<td>Job Code: <br /><input class="job_code" type="text" id="job_code" autocomplete="off"><br /></td>
    	<td>Job Title: <br /><input class="job_title" type="text" id="job_title" autocomplete="off"><br /></td>
    	<td>Company Name: <br /><input class="company_name" type="text" id="company" autocomplete="off"><br /></td>
    </tr>
    <tr>
    	<td>Start Date: <br /><input title="Start Date" class="start_date datepicker" id="start" type="text"></td>
      	<td>End Date: <br /><input title="End Date" class="end_date datepicker" id="end" type="text"></td>                  
    </tr>
    <tr>
    	<td>Funding: <br /><input class="funding valid_numbers" type="text" id="fund" onchange="add_curr()" autocomplete="off"><br /></td>			   
    	<td>Profit: <br /><input class="profit valid_numbers" type="text" id="profit" onchange="add_perc()" autocomplete="off"><br /></td>
    	<td>Delivery Order: <br />
                      	<select id="order">
                          	<option value="00">None</option>
                            <?php //Populate drop down list w/ delivery orders						
                            	$query = "SELECT * FROM `delivery_orders`";
								$result = $mysqli->query($query);

								while($row = $result->fetch_array(MYSQLI_ASSOC)) {
									$id = $row['id'];
									$name = $row['name'];
									$options = "<option value=" . $id .">" . $name . "</option>";
									echo $options; 
								}
							?>
                      	</select>
                    	<br />
        </td>
    </tr>
    </table>
</div>

<?php // SECTION DISPLAYS JOBS
	$query = "SELECT * FROM `jobs` WHERE `end_date` >= CURDATE() ORDER BY `id` DESC";
	$results = $mysqli->query($query);
	while ($row = $results->fetch_array(MYSQLI_BOTH)) {
		$description = $row['job_id'] . " - " . $row['job_title'];	
?>
   <div class="job" id="job_<?=$row['id'];?>">
      <span class="label" title="<?=$row['job_id'];?> - <?=$row['job_title'];?>"><?=$description;?></span>
    	<div class="dates">
        	<input title="Delete Job" type="image" class="icon"  src="../../images/delete.png" alt="Delete Job" onclick="delete_job('<?=$row['id'];?>')">
         	<input title="Edit Job" type="image" class="icon"  src="../../images/edit.png" alt="Edit Job" onclick="modify_section('<?=$row['id'];?>')">
      		<span title="Start Date"><?=$row['start_date'];?></span> --- <span title="End Date"><?=$row['end_date'];?></span>
    	</div>
  </div> 
<?php
	}	
?> 