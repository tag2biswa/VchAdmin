
<head>
	<script src="jquery-1.9.1.min.js"></script> <!-- CHANGE THE JQUERY FILE DEPENDING ON THE VERSION YOU HAVE DOWNLOADED -->
<script type="text/javascript">
  $(document).ready(function(){ /* PREPARE THE SCRIPT */
    $("#allbooks").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
      var allbooks = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
      var dataString = "allbooks="+allbooks; /* STORE THAT TO A DATA STRING */

      $.ajax({ /* THEN THE AJAX CALL */
        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
        url: "get-data.php", /* PAGE WHERE WE WILL PASS THE DATA */
        data: dataString, /* THE DATA WE WILL BE PASSING */
        success: function(result){ /* GET THE TO BE RETURNED DATA */
          $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
        }
      });

    });
  });
</script>
</head>
<body>
<select name="allbooks" id="allbooks">
  <option value="none" ></option>
  <option value="allbooks" >All Books</option>
</select>
<div id="show">
  <!-- ITEMS TO BE DISPLAYED HERE -->
</div>
</body>