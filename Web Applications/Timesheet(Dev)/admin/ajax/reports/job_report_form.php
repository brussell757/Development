<?php 
require '../../../php_scripts/session.php';
?>
<script type="text/javascript">
//FUNCTION THAT DOESNT ALLOW END DATE TO BE BEFORE START DATE
$(document).ready(function(){
	$("#start_report").datepicker({
		dateFormat: "yy-mm-dd",
		showAnim: "slide",
		onSelect: function(selected) {
		  $("#end_report").datepicker("option","minDate", selected)
		}
	});
	$("#end_report").datepicker({ 
		dateFormat: "yy-mm-dd",
		showAnim: "slide",
		onSelect: function(selected) {
		   $("#start_report").datepicker("option","maxDate", selected)
		}
	}); 
	$("#job_start_report").datepicker({ 
		dateFormat: "yy-mm-dd",
		showAnim: "slide",
		onSelect: function(selected) {
		   $("#job_start_report").datepicker("option","maxDate", selected)
		}
	}); 
	$("#job_end_report").datepicker({ 
		dateFormat: "yy-mm-dd",
		showAnim: "slide",
		onSelect: function(selected) {
		   $("#job_start_report").datepicker("option","maxDate", selected)
		}
	});  
});
</script>

<a id="job_report_link" href="#job_report_form" onclick="hide_job_report_form()">Hide Job Report Form</a>
<form class="job_form" action="../reports/jobs.php" method="post">              
    
    <select id="jobs_list" name="jobs_list">
        <option value="00">Select Job</option>
        <option value="*">All</option>
        <?php
        $query = "SELECT * FROM `jobs` ORDER BY `start_date`";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_array(MYSQLI_BOTH)) {
            $id = $row['id'];
            $job_code= $row['job_id'];
            $job_title = $row['job_title'];
            echo "<option value=" . $id .">" . $job_code . " - " . $job_title . "</option>"; 
        }
        ?>
    </select>
    
    <select id="ts_periods" name="ts_periods" onchange="selected_period()">
        <option value="00">Select Custom Dates/Timesheet</option>
        <option value="*">Custom Dates</option>
        <?php 
        $query = "SELECT * FROM `pay_periods` ORDER BY `start_date` DESC";
        $result = $mysqli->query($query);

        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $period_id = $row['id'];
            $period_sd = $row['start_date'];
            $period_sd = date('m/d/Y', strtotime($period_sd));
            $period_ed = date('m/d/Y', strtotime($period_sd. ' + 13 days'));
            $options = "<option value=" . $period_id .">" . $period_sd . ' - ' . $period_ed .  "</option>";
            echo $options; // DISPLAYS ALL PAY PERIODS
        }
        ?>
    </select>
    
    <div id="dates">
        <input title="Start Date" id="start_report" name="start_report" type="text" readonly='true'>
        ---
        <input title="End Date" id="end_report" name="end_report" type="text" readonly='true'>
    </div>
        <button id="generate_report" type="submit">Generate Report</button> 
</form>