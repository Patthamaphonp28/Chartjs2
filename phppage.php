<?php require_once('Connections/chartjs.php'); ?>
<?php require_once('Connections/chartjs.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_chartjs, $chartjs);
$query_Recordset1 = "SELECT month(purchase_date) as month, COUNT(product_id) as amount FROM purchase_history group BY month(purchase_date)";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $chartjs) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$maxRows_pro = 10;
$pageNum_pro = 0;
if (isset($_GET['pageNum_pro'])) {
  $pageNum_pro = $_GET['pageNum_pro'];
}
$startRow_pro = $pageNum_pro * $maxRows_pro;

mysql_select_db($database_chartjs, $chartjs);
$query_pro = "SELECT * FROM products";
$query_limit_pro = sprintf("%s LIMIT %d, %d", $query_pro, $startRow_pro, $maxRows_pro);
$pro = mysql_query($query_limit_pro, $chartjs) or die(mysql_error());
$row_pro = mysql_fetch_assoc($pro);

if (isset($_GET['totalRows_pro'])) {
  $totalRows_pro = $_GET['totalRows_pro'];
} else {
  $all_pro = mysql_query($query_pro);
  $totalRows_pro = mysql_num_rows($all_pro);
}
$totalPages_pro = ceil($totalRows_pro/$maxRows_pro)-1;

$maxRows_pur = 10;
$pageNum_pur = 0;
if (isset($_GET['pageNum_pur'])) {
  $pageNum_pur = $_GET['pageNum_pur'];
}
$startRow_pur = $pageNum_pur * $maxRows_pur;

mysql_select_db($database_chartjs, $chartjs);
$query_pur = "SELECT * FROM purchase_history";
$query_limit_pur = sprintf("%s LIMIT %d, %d", $query_pur, $startRow_pur, $maxRows_pur);
$pur = mysql_query($query_limit_pur, $chartjs) or die(mysql_error());
$row_pur = mysql_fetch_assoc($pur);

if (isset($_GET['totalRows_pur'])) {
  $totalRows_pur = $_GET['totalRows_pur'];
} else {
  $all_pur = mysql_query($query_pur);
  $totalRows_pur = mysql_num_rows($all_pur);
}
$totalPages_pur = ceil($totalRows_pur/$maxRows_pur)-1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Chartjs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<h1 align="center">ข้อมูลแสดงถึง จำนวนการสั่งซื้อ(amount)ในแต่ละเดือน(month)</h1>
<div class="container">
  <table class="table table-bordered" align="center">
    <thead>
      <tr class="success">
    <td>month</td>
    <td>amount</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['month']; ?></td>
      <td><?php echo $row_Recordset1['amount']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</div>
<div class="container">
<h3>ข้อมูลของสินค้า </h3>
  <table class="table table-bordered" align="left">
    <tr class="info">
    <td>id</td>
    <td>product_id</td>
    <td>product_name</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_pro['id']; ?></td>
      <td><?php echo $row_pro['product_id']; ?></td>
      <td><?php echo $row_pro['product_name']; ?></td>
    </tr>
    <?php } while ($row_pro = mysql_fetch_assoc($pro)); ?>
</table>
<p><a href="InsertPro.php">เพิ่มข้อมูลของสินค้า</a></p>
<p>&nbsp;</p></div>
<div class="container">
<h3>ประวัติการซื้อ</h3>
  <table class="table table-bordered" align="left">
    <tr class="info">
    <td>id</td>
    <td>product_id</td>
    <td>purchase_date</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_pur['id']; ?></td>
      <td><?php echo $row_pur['product_id']; ?></td>
      <td><?php echo $row_pur['purchase_date']; ?></td>
    </tr>
    <?php } while ($row_pur = mysql_fetch_assoc($pur)); ?>
</table>
<p><a href="InsertPur.php">เพิ่มข้อมูลการซื้อ</a></p></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($pro);

mysql_free_result($pur);
?>
