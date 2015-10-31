<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

if(isset($id)) {
	$query = "SELECT * FROM `jobs` WHERE `id` = '$id' LIMIT 1";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);		
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

<div id='modify_job'>
  <input title='Save Job' type='button' class='save_icon' alt='Update Job' onclick="validate_modify_form('<?=$id;?>')">
  <table>
  <tr>             
      <td>Job Code: <br /><input class='job_code' type='text' id='mod_job_code' autocomplete='off' value="<?=$row['job_id'];?>"><br /></td>
      <td>Job Title: <br /><input class='job_title' type='text' id='mod_job_title' autocomplete='off' value="<?=$row['job_title'];?>"><br /></td>  
      <td>Company Name: <br /><input class='company_name' type='text' id='mod_company' autocomplete='off' value="<?=$row['company'];?>"><br /></td>
  </tr>   
  
  	  <td>Start Date: <br /><input title="Start Date" class="start_date datepicker" id="mod_start" type="text" value="<?=$row['start_date'];?>"></td>
      <td>End Date: <br /><input title="End Date" class="end_date datepicker" id="mod_end" type="text" value="<?=$row['end_date'];?>"></td>              
  
  <tr>     
      <td>Funding: <br /><input class='funding valid_numbers' type='text' id='mod_fund' onchange='add_mod_curr()' autocomplete='off' value='$<?=$row['funding'];?>'><br /></td>			   
      <td>Profit: <br /><input class='profit valid_numbers' type='text' id='mod_profit'  onchange='add_mod_perc()' autocomplete='off' value='<?=$row['profit'];?>%'><br /></td>
      <td>
      	  Delivery Order: <br />
          <select id='mod_order'>
              <option value='00'>None</option>
			  <?php //Populate drop down list w/ delivery orders
			  require '../../../php_scripts/db_connect.php';
			  
				  $query = "SELECT * FROM `delivery_orders`";
				  $result = $mysqli->query($query);

				  while($drow = $result->fetch_array(MYSQLI_ASSOC)) {
					  $id = $drow['id'];
					  $name = $drow['name']; 
			  ?>
                  <option value="<?=$id;?>"<?php if ($id == $row['delivery_order']) { echo " selected=\"selected\""; } ?>><?=$name;?></option>
              <?php
				  }
			  ?>
          </select><br />
      </td>
  </tr>
  </table>  
</div>
<?php
}
?>
