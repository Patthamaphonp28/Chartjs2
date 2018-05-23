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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO products (id, product_id, product_name) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['product_id'], "int"),
                       GetSQLValueString($_POST['product_name'], "text"));

  mysql_select_db($database_chartjs, $chartjs);
  $Result1 = mysql_query($insertSQL, $chartjs) or die(mysql_error());

  $insertGoTo = "phppage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_chartjs = 10;
$pageNum_chartjs = 0;
if (isset($_GET['pageNum_chartjs'])) {
  $pageNum_chartjs = $_GET['pageNum_chartjs'];
}
$startRow_chartjs = $pageNum_chartjs * $maxRows_chartjs;

mysql_select_db($database_chartjs, $chartjs);
$query_chartjs = "SELECT * FROM products";
$query_limit_chartjs = sprintf("%s LIMIT %d, %d", $query_chartjs, $startRow_chartjs, $maxRows_chartjs);
$chartjs = mysql_query($query_limit_chartjs, $chartjs) or die(mysql_error());
$row_chartjs = mysql_fetch_assoc($chartjs);

if (isset($_GET['totalRows_chartjs'])) {
  $totalRows_chartjs = $_GET['totalRows_chartjs'];
} else {
  $all_chartjs = mysql_query($query_chartjs);
  $totalRows_chartjs = mysql_num_rows($all_chartjs);
}
$totalPages_chartjs = ceil($totalRows_chartjs/$maxRows_chartjs)-1;
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
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id:</td>
      <td><input type="text" name="id" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Product_id:</td>
      <td><input type="text" name="product_id" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Product_name:</td>
      <td><input type="text" name="product_name" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<div class="container">
  <table class="table table-bordered" align="center">
    <thead>
      <tr class="success">
    <td>id</td>
    <td>product_id</td>
    <td>product_name</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_chartjs['id']; ?></td>
      <td><?php echo $row_chartjs['product_id']; ?></td>
      <td><?php echo $row_chartjs['product_name']; ?></td>
    </tr>
    <?php } while ($row_chartjs = mysql_fetch_assoc($chartjs)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($chartjs);
?>
