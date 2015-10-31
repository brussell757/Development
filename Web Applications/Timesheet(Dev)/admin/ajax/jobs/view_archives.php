<?php 
require '../../../php_scripts/session.php';
?>

<a id="archives_link" href="#archives" onclick="hide_archives()">Hide Inactive Jobs</a>
<?php // SECTION DISPLAYS ARCHIVED JOBS

$query = "SELECT * FROM `jobs` WHERE `end_date` < CURDATE() ORDER BY `end_date`";
$results = $mysqli->query($query);
while ($row = $results->fetch_array(MYSQLI_BOTH)) {
	$description = $row['job_id'] . " - " . $row['job_title'];
?>
    <div class="archive_jobs">
    	<span class="label" title="<?=$row['job_id'];?> - <?=$row['job_title'];?>"><?=$description;?></span>
    	<div class="dates">
      		<span title="End Date"><?=$row['end_date'];?></span> <span title="Start Date"><?=$row['start_date'];?> --- </span>
    	</div>
  	</div>   
<?php
}
?>