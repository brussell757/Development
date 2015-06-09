<?php
require '../../../php_scripts/session.php';
?>
  <div id="create_order">
      <div class="buttons">
          <input title="Create Order" type="button" class="add_icon" alt="Create"  onclick="validate_form()">
          <input title="Cancel" type="button" class="cancel_icon" alt="Cancel" onclick="cancel_create_order()">
      </div>
      <table>
      <tr>  
          <td>Delivery Order Name: <br /><input type="text" id="order_name" autocomplete="off"><br /></td>
      </tr>
      </table>
  </div>
  
<?php // SECTION DISPLAYS ORDERS
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