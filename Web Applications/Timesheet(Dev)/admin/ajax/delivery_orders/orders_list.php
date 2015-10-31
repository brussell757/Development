<?php // SECTION DISPLAYS ORDERS
require '../../../php_scripts/session.php';

$query = "SELECT * FROM `delivery_orders` ORDER BY `id`";
$results = $mysqli->query($query);
while ($row = $results->fetch_array(MYSQLI_BOTH)) {
?>
   <div class="delivery_orders" id="orders_<?=$row['id'];?>">
      <span class="label" title="<?=$row['name'];?>"><?=$row['name'];?></span>
      <input title="Delete Order" type="image" class="icon"  src="../../images/delete.png" alt="Delete Order" onclick="delete_order('<?=$row['id'];?>')">
      <div class="dates">
        <span title="Date"><?=$row['date'];?></span>
      </div>
  </div> 
<?php
}
?> 