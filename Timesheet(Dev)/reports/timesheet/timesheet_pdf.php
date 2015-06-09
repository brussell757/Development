<?php
date_default_timezone_set('UTC');
/////////////////// DUMMY SEED DATA FOR TESTING ////////////////////
require ("../../php_scripts/db_connect.php");
$employee_id = $_GET['a'];
$pay_period_id = $_GET['b'];

$query = "SELECT `start_date` FROM `pay_periods` WHERE `id` = $pay_period_id";
$results = $mysqli->query($query);
$row = $results->fetch_array(MYSQLI_BOTH);


$timesheet_start_date = $row['start_date'];


////////////////////////////////////
require ("../../fpdf/fpdf.php");

$startDate = new DateTime($timesheet_start_date);
$endDate = new DateTime($timesheet_start_date);
$endDate->modify('+13 day');

// this function will create the individual rows of the timesheet
$fillcolor['dark'] = array(215,215,255);
$fillcolor['light'] = array(235,235,255);
function timesheet_row($emp_job_id,$start_date,$fill,$pdf,$fillcolor,$mysqli,$emp_id,$job_type) {
	$totalHours = 0;
	if ($job_type == "employee") {		
	  $query = "SELECT * FROM `employee_jobs` WHERE `id` = '$emp_job_id' LIMIT 1";
	  $employee_job = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);
	  $job_id = $employee_job['job_id'];
	  $query = "SELECT * FROM `jobs` WHERE `id` = '$job_id' LIMIT 1";
	  $job = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);	
	
	} elseif ($job_type == "fixed") {
	  $query = "SELECT * FROM `fixed_jobs` WHERE `id` = '$emp_job_id' LIMIT 1";
	  $job = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);
	  
	} elseif ($job_type == "holiday") {
	  $query = "SELECT * FROM `fixed_jobs` WHERE `id` = '$emp_job_id' LIMIT 1";
	  $job = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);
	}


	$contract_number = $job['job_id'];	
	$contract_number_width = $pdf->GetStringWidth($contract_number);	
	while ($contract_number_width > 120) {
		$contract_number_len = strlen($contract_number);
		$contract_number_len = $contract_number_len - 4;
		$contract_number = substr($contract_number,0,$contract_number_len);
		$contract_number = $contract_number . "...";
		$contract_number_width = $pdf->GetStringWidth($contract_number);
	}
	$contract_title = $job['job_title'];
	$contract_title_width = $pdf->GetStringWidth($contract_title);	
	while ($contract_title_width > 140) {
		$contract_title_len = strlen($contract_title);
		$contract_title_len = $contract_title_len - 4;
		$contract_title = substr($contract_title,0,$contract_title_len);
		$contract_title = $contract_title . "...";
		$contract_title_width = $pdf->GetStringWidth($contract_title);
	}
	$date = new DateTime($start_date);
	// get hours
	if ($job_type == "employee") {	
		$query = "SELECT * FROM `hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$emp_job_id'";
	} elseif ($job_type == "fixed") {
		$query = "SELECT * FROM `fixed_hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$emp_job_id'";
	} elseif ($job_type == "holiday") {
		$query = "SELECT * FROM `fixed_hours` WHERE (`emp_id` IS NULL OR `emp_id` = '$emp_id') AND `job_id` = '3'";	
	}
	//$query = "SELECT * FROM `hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$emp_job_id'";
	$result = $mysqli->query($query);
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$hours[$row['date']] = $row['hours'] + 0;
	}
	
	if ($job_type == "employee") {	
		$pdf->Cell(125,15,$contract_number,1,0,'C',$fill);
		$pdf->Cell(145,15,$contract_title,1,0,'C',$fill);
	} elseif ($job_type == "fixed") {
		$pdf->Cell(270,15,$contract_title,1,0,'C',$fill);
	} elseif ($job_type == "holiday") {
		$pdf->Cell(270,15,$contract_title,1,0,'C',$fill);
	}
	
	
	//$pdf->Cell(270,15,"OH B & P",1,0,'C',$fill);
	
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	if ($fill === true) {
		$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
	} else {
		$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
	}
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',true); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',true); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
		$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
	
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',$fill); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	if ($fill === true) {
		$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
	} else {
		$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
	}
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',true); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->Cell(30,15,$hours[$date->format('Y-m-d')],1,0,'C',true); $totalHours = $totalHours + $hours[$date->format('Y-m-d')]; $date->modify('+1 day');
	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
	if ($totalHours != 0) {
		$th = $totalHours; 
	} else {
		$th = "";
	}
	$pdf->Cell(66,15,$th,1,1,'C',$fill);
	
	if ($fill === true) {
		$fill = false;
	} else {
		$fill = true;
	}
	
return array($pdf,$fill,$totalHours);
	
}

class PDF extends FPDF
{ // START PDF CLASS EXTENSION
	function Header() {
		//$this->Image('background.jpg', 0, 0, $this->w, $this->h);
		$this->Image('cha-logo.png');
		$this->SetY('105');
	} // END FUNCTION HEADER()
	
	function Footer() {
		$this->SetY(-65);
		$this->Cell(225,15,"Employee Signature",'T',0,'C',false);
		$this->Cell(35,15,"",'0',0,'C',false);
		$this->Cell(100,15,"Date",'T',0,'C',false);
		$this->Cell(36,0,"",'0',0,'C',false);
		$this->Cell(225,15,"Management Signature",'T',0,'C',false);
		$this->Cell(35,15,"",'0',0,'C',false);
		$this->Cell(100,15,"Date",'T',1,'C',false);
		$note = "Note: Cape Henry Associates' timesheet begins at 12:00 a.m. Monday and closes at 11:59 p.m. on Sunday. Completed timesheets should be printed & signed by employee and management and submitted to administration on the Monday after the end of the pay period.";
		$this->MultiCell(0,15,$note,1,'C',true);
		
	}
	
} // END PDF CLASS EXTENSION

// Get general employee info
$query = "SELECT * FROM `employees` WHERE `id` = '$employee_id' LIMIT 1";
$employee = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);

// Create Timesheet Page
$pdf = new PDF('L','pt','Letter');
$pdf->SetMargins(18,18);
$pdf->SetAutoPageBreak('auto',100);
$pdf->AddPage();

$pdf->SetFont('Arial','',10);
$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
// Contents Below Here
// Header Row
$pdf->SetFont('Arial','B',10);
$pdf->Cell(65,15,"Employee #: ",'TBL');
$pdf->SetFont('Arial','',10);
$pdf->Cell(60,15,$employee['emp_num'],'TBR');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(89,15,"Employee Name:",'TBL');
$pdf->SetFont('Arial','',10);
$pdf->Cell(341,15,$employee['first_name'] . " " . $employee['last_name'],'TBR');
$date = new DateTime($startDate->format('Y-m-d'));

$sd = $startDate->format('n/j/Y');
$date->modify('+13 day');
$ed = $date->format('n/j/Y');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,15,"Period:",'TBL');
$pdf->SetFont('Arial','',10);
$pdf->Cell(161,15,$sd . " - " . $ed,'TBR',1);
$pdf->Cell(756,15,"",0,1);
// 2nd Header Row
$pdf->SetFont('Arial','B',10);
$pdf->Cell(125,15,"Contract Number",1,0,'C','true');
$pdf->Cell(145,15,"Contract Title",1,0,'C','true');
$date = new DateTime($startDate->format('Y-m-d'));
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');

$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true'); $date->modify('+1 day');
$pdf->Cell(30,15,$date->format('n/j'),1,0,'C','true');


$pdf->Cell(66,15,"Totals",1,1,'C','true');
$pdf->SetFont('Arial','',10);

//Actual Timesheet Rows
$sd = $startDate->format('Y-m-d');
$ed = $endDate->format('Y-m-d');
$query = "SELECT * FROM `employee_jobs`  
	WHERE `emp_id` = '$employee_id' 
	AND (`start_date` <= '$ed' 
	AND `end_date` >= '$sd')";
$pdfa['0'] = $pdf;
$pdfa['1'] = false;
$totalHours = 0;
$result = $mysqli->query($query);
while ($row = $result->fetch_array(MYSQLI_BOTH)){
	$pdfa = timesheet_row($row['id'],$sd,$pdfa['1'],$pdfa['0'],$fillcolor,$mysqli,$employee_id,"employee");
	$totalHours = $totalHours + $pdfa['2'];	
}
$pdfa = timesheet_row("1",$sd,$pdfa['1'],$pdfa['0'],$fillcolor,$mysqli,$employee_id,"fixed");
$totalHours = $totalHours + $pdfa['2'];
$pdfa = timesheet_row("2",$sd,$pdfa['1'],$pdfa['0'],$fillcolor,$mysqli,$employee_id,"fixed");
$totalHours = $totalHours + $pdfa['2'];
$pdfa = timesheet_row("3",$sd,$pdfa['1'],$pdfa['0'],$fillcolor,$mysqli,$employee_id,"holiday");
$totalHours = $totalHours + $pdfa['2'];
$pdfa = timesheet_row("4",$sd,$pdfa['1'],$pdfa['0'],$fillcolor,$mysqli,$employee_id,"fixed");
$totalHours = $totalHours + $pdfa['2'];


////$pdfa = timesheet_row('0','0',$pdfa['1'],$pdfa['0'],$fillcolor);
//
//$pdf = $pdfa['0'];
//$fill = $pdfa['1'];
//
////Permanant Rows
//// OH B&P
//$pdf->Cell(270,15,"OH B & P",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(66,15,"88",1,1,'C',$fill);
//if ($fill === true) {
//	$fill = false;
//} else {
//	$fill = true;
//}
//// OH
//$pdf->Cell(270,15,"OH",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(66,15,"88",1,1,'C',$fill);
//if ($fill === true) {
//	$fill = false;
//} else {
//	$fill = true;
//}
////Holiday
//$pdf->Cell(270,15,"Holiday",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(66,15,"88",1,1,'C',$fill);
//if ($fill === true) {
//	$fill = false;
//} else {
//	$fill = true;
//}
//// Personal
//$pdf->Cell(270,15,"Personal",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//$pdf->Cell(30,15,"8",1,0,'C',$fill);
//if ($fill === true) {
//	$pdf->SetFillColor($fillcolor['dark']['0'],$fillcolor['dark']['1'],$fillcolor['dark']['2']);
//} else {
//	$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);
//}
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->Cell(30,15,"8",1,0,'C',true);
//$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
//$pdf->Cell(66,15,"88",1,1,'C',$fill);
//if ($fill === true) {
//	$fill = false;
//} else {
//	$fill = true;
//}

// Total Hours
$pdf->Cell(690,15,"Bi-Weekly Total Hours",1,0,'R',false);
$pdf->SetFillColor($fillcolor['light']['0'],$fillcolor['light']['1'],$fillcolor['light']['2']);	
	if ($totalHours != 0) {
		$th = $totalHours; 
	} else {
		$th = "";
	}
$pdf->Cell(66,15,$th,1,1,'C',false);

// Output PDF
if(isset($_GET['c'])) {
$pdf->Output($timesheet_start_date.' Timesheet.pdf', 'D');
} else {
$pdf->Output();	
}
?>
<link href="../../images/cha.ico" rel="shortcut icon">
