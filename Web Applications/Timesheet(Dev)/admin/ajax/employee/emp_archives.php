<a id="view_disabled_emps" href="#show_archives" onclick="hide_archives()">Hide Inactive Jobs</a>
<?php // SECTION DISPLAYS ARCHIVED JOBS
require '../../../php_scripts/session.php';

$emp_id = $_POST['emp_id'];
if(isset($emp_id)) {
	$query = "SELECT * FROM `employee_jobs` WHERE `emp_id` = '$emp_id' AND `end_date` < CURDATE() ORDER BY `end_date`";
	$results = $mysqli->query($query);
	while ($row = $results->fetch_array(MYSQLI_BOTH)) {
		$query = "SELECT * FROM `jobs` WHERE `id` = '$row[job_id]' LIMIT 1";
		$res = $mysqli->query($query);
		$array = $res->fetch_array(MYSQLI_BOTH);
		
		$description = $array['job_id'] . " - " . $array['job_title'];	
?>
    <div class="archive_jobs">
    	<span class="label" title="<?=$array['job_id'];?> - <?=$array['job_title'];?>"><?=$description;?></span>
    	<div class="dates">
      		<span title="End Date"><?=$row['end_date'];?></span> <span title="Start Date"><?=$row['start_date'];?> --- </span>
    	</div>
  	</div>
<?php
	}
}
?>