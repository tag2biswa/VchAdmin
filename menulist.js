$(document).ready(function() {
  $("#id_category").change(function() {
    var category_id = $(this).val();
    if(category_id != "") {
      $.ajax({
        url:"get_menu_from_category.php",
        data:{id_category:category_id},
        type:'POST',
        success:function(response) {
          var resp = $.trim(response);
          $("#id_menu").html(resp);
        }
      });
    } else {
      $("#id_menu").html("<option selected="Selected" disabled="disabled">Select a menu type</option> -->");
    }
  });
});