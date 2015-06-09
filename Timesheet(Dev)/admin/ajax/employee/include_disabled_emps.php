<?php
require '../../../php_scripts/session.php';
?>
    <select id="emp_list" onchange="emp_content_update()">
        <option value="00" selected>Select Employee</option>
    <?php
    require '../../../php_scripts/db_connect.php';
    
    $query = "SELECT `id`,`last_name`, `first_name` FROM `employees` ORDER BY `last_name`, `first_name`";
    $result = $mysqli->query($query);
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $id = $row['id'];
        $last_name = $row['last_name'];
        $first_name = $row['first_name'];
        $options = "<option value=" . $id .">" . $last_name . ", " . $first_name . "</option>";
         echo $options; 
    }
    ?>
    </select>