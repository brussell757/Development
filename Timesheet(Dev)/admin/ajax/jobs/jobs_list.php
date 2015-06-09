<?php // SECTION DISPLAYS JOBS
require '../../../php_scripts/session.php';

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
        <span title="Start Date"> <?=$row['start_date'];?> </span> --- <span title="End Date"><?=$row['end_date'];?></span>
      </div>
  </div> 
<?php
}
?> 
  <div id="inactive_jobs"><!-- START INACTIVE JOBS DIV-->
      <a id="archives_link" href="#archives" onclick="view_archives()">Show Inactive Jobs</a>
  </div><!-- END INACTIVE JOBS DIV-->
