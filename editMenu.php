    <?php
    require_once __DIR__ . '/db_config.php';
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
    $menuid = $_GET['menuid'];

    if (isset($_POST['submit'])) {
        $m_id = $_POST['_id'];
        $menu_name = $_POST['menu_name'];
        $id_categoryy = $_POST['id_categoryy'];
        $res = mysqli_query($con, "UPDATE `menu` SET `menu_name` = '$menu_name',`cat_id`= $id_categoryy WHERE `menu_id`= $m_id");
        
        header("location:menulist.php");
    }

    $members = mysqli_query($con, "SELECT * FROM `menu` WHERE `menu_id`='$menuid'");
    $mem = mysqli_fetch_assoc($members);
    mysqli_close($con);
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Victoria Club Hotel</title>
        <script type="text/javascript">
            function Category() {
                $('#id_categoryy').empty();
                $('#id_categoryy').append("<option>Loading.....</option>");
                $('#id_menu').append("<option>Select Menu</option>");
                $.ajax({
                    type: "POST",
                    url: "category_dropdown.php",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        $('#id_categoryy').empty();
                        $('#id_categoryy').append("<option>Select Category</option>");
                        $.each(data, function(i, item) {
                            $('#id_categoryy').append('<option value="' + data[i].cat_id + '">' + data[i].cat_name + '</option>');
                        });
                    }
                });
            }
            $(document).ready(function() {
                Category();
            });
        </script>
        <!-- Bootstrap Core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <form method="post" action="editMenu.php" role="form">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="menu_id">Menu ID</label>
                        <input type="text" class="form-control" id="_id" name="_id" value="<?php echo $mem['menu_id'];?>" readonly="true"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?php echo $mem['menu_name'];?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="n/nv">Category</label>
                        <select class="form-control" id="id_categoryy" name='id_categoryy' required="required">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
             <input type="submit" class="btn btn-primary" name="submit" value="Update" />&nbsp;
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
     </form>
 </body>
 </html>