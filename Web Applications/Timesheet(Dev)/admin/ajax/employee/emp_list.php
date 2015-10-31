<?php
require '../../../php_scripts/session.php';
?>
    <select id="emp_list" onchange="emp_content_update()">
        <option value="00">Select Employee</option>
    <?php
    
	$emp_id = $_POST['emp_id'];
    $query = "SELECT `id`,`last_name`, `first_name` FROM `employees` WHERE `active` = 1 ORDER BY `last_name`, `first_name`";
    $result = $mysqli->query($query);
    
    while($row = $result->fetch_array(MYSQLI_BOTH)) {
        $id = $row['id'];
        $last_name = $row['last_name'];
        $first_name = $row['first_name'];
		
		if($id == $emp_id) {
        	echo "<option value=" . $id ." selected>" . $last_name . ", " . $first_name . "</option>";
		} else {
			
			echo "<option value=" . $id .">" . $last_name . ", " . $first_name . "</option>"; 
		}
    }
    ?>
    </select>
