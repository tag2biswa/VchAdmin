<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="script/bootbox.min.js"></script>
<script type="text/javascript" src="script/deleteRecords.js"></script>
</head>
<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Sl No.</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM `category`";
    $res = mysqli_query($con, $sql);
      $i = 0;
      while($row = mysqli_fetch_assoc($res)) {
        $catid = $row["cat_id"];
        ?>
        <tr>
          <td><?php echo $row["cat_name"]; ?></td>
          <td>
            <a class="delete_record" data-rec-id="<?php echo $row["cat_id"]; ?>" href="javascript:void(0)">
              <i class="glyphicon glyphicon-trash"></i>
            </a></td>
          </tr>
          <?php
        
      }
      ?>
    </tbody>
  </table>