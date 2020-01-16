<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <style type="text/css">
    body
    {font: 14px sans-serif;}

    .wrapper
    {width: 350px; padding: 20px;}
  </style>
  <title>Output</title>
</head>
<body>

<nav class="navbar navbar-inverse">

  <div class="container-fluid">

    <ul class="nav navbar-nav">

      <li><a href="admin/index.php" class="glyphicon glyphicon-home">HOME</a> </li>

    </ul>

    <ul class="nav navbar-nav navbar-right">

      <li><a href="login/logout.php">Logout</a> </li>

    </ul>

  </div>

</nav>

<?php

require "config.php";

$emp_id = $search_item = '';
$emp_id_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST['emp_name']))) {
    $emp_id_err = "Please enter a name.";
  } else {
    $emp_id = trim($_POST['emp_name']);
  }

  $search_item = strtoupper($emp_id[0]);

  if (empty($emp_id_err)) {
    $sql = oci_parse($conn, "select EMP_ID,EMP_NAME,to_char(EMP_DOB,'dd-mon-yyyy') 
                                    from EMPLOYEE where EMP_NAME like upper('$search_item%')");

    if (!$sql) {
      echo "error";
    }
    $rs = oci_execute($sql);
    if (!$rs) {
      exit("Error in sql");
    }

    echo "<table border = 1><tr>";
    echo "<th>EMPLOYEE ID</th>";
    echo "<th>EMPLOYEE NAME</th>";
    echo "<th>DATE OF BIRTH</th>";
    while ($row = oci_fetch_array($sql, OCI_ASSOC + OCI_RETURN_NULLS)) {
      echo "<tr> \n";
      foreach ($row as $item) {
        print "<td>";
        print $item;
        print "</td>";
      }
      echo "</tr>\n";
    }
    oci_close($conn);
    echo "</table>";
  }
}

?>

</body>
</html>