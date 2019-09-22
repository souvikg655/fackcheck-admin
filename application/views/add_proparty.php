<?php include 'include/header.php' ?>


<main class="app-content">

  <div class="app-title">
    <div>
      <h1> Add Now</h1>
    </div>
  </div>

  <div class="row">

    <div class="col-md-6">
      <div class="tile">
        <div class="tile-title-w-btn">
          <h3 class="title">Add Proparty</h3>
        </div>
        <div class="tile-body">
          <div class="form-group row">
            <label class="control-label col-md-3">Proparty: </label>
            <div class="col-md-8">
              <input class="form-control" type="text" id="proparty_value" placeholder="Enter name">
            </div>
          </div>
          <div class="tile-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary" id="add_proparty" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save Property </button>
                <input type="hidden" id="demoNotify">
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="tile">
        <div class="tile-title-w-btn">
          <h3 class="title">Add Area</h3>
        </div>
        <div class="tile-body">
          <div class="form-group row">
            <label class="control-label col-md-3">Area: </label>
            <div class="col-md-8">
              <input class="form-control" type="text" id="area_value" placeholder="Enter area">
            </div>
          </div>

          <div class="tile-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary" id="add_area" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save Area </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Propartys</h3>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Sl. No.</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <input type="hidden" class="btn btn-primary modal_button" data-toggle="modal" data-target="#exampleModalCenter">

            <?php for ($i = 0; $i<sizeof($proparty_value); $i++){ ?>
              <tr id="tbl_proparty_<?php echo $proparty_value[$i]->id; ?>">
                <td><?php echo $i+1; ?></td>
                <td><?php echo $proparty_value[$i]->name; ?></td>
                <td>
                  <i  class="fa fa-pencil-square-o edit_proparty" proparty-id="<?php echo $proparty_value[$i]->id; ?>" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                  <i class="fa fa-trash-o delete_proparty" proparty-id="<?php echo $proparty_value[$i]->id; ?>" aria-hidden="true"></i>
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>

    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Areas</h3>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Sl. No.</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i<sizeof($area); $i++){ ?>
              <tr id="tbl_area_<?php echo $area[$i]->id; ?>">
                <td><?php echo $i+1; ?></td>
                <td><?php echo $area[$i]->value; ?></td>
                <td>
                  <i class="fa fa-pencil-square-o edit_area" area-id="<?php echo $area[$i]->id; ?>" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                  <i class="fa fa-trash-o delete_area" area-id="<?php echo $area[$i]->id; ?>"  aria-hidden="true"></i>
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>

  </div>

</main>

<?php include 'include/footer.php' ?>

</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){

    $("#add_proparty").click(function(){
      var value = $("#proparty_value").val();

      if(value == ''){
          $('#demoNotify').click();
          return false;
      }

      var formdata = new FormData();
      formdata.append("property", value);

      var ajaxReq = $.ajax({
        url: '<?php echo base_url()?>user/add_propertys',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function (xhr) {
        },
        success: function (data) {
          if(data){
            toastr["success"]("Add Successfull");
          }else{
            toastr["error"]("Failed");
          }
        },
      });
    });

    $("#add_area").click(function(){
      var value = $("#area_value").val();

      if(value == ''){
          $('#demoNotify').click();
          return false;
      }

      var formdata = new FormData();
      formdata.append("area", value);

      var ajaxReq = $.ajax({
        url: '<?php echo base_url()?>user/add_area',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function (xhr) {
        },
        success: function (data) {
          console.log(data);
          if(data){
            toastr["success"]("Add Successfull");
          }else{
            toastr["error"]("Failed");
          }
        },
      });
    });

    $(".edit_proparty").click(function(){
      var id =  $(this).attr("proparty-id");

      var formdata = new FormData();
      formdata.append("proparty_id", id);

      var ajaxReq = $.ajax({
        url: '<?php echo base_url()?>user/fetch_proparty_by_id',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function (xhr) {
        },
        success: function (data) {
          var data = JSON.parse(data);
          $('.modal_button').click();
          var id = data[0]['id'];
          var name = data[0]['name'];
          var identity = "Proparty";

          $("#click_identity").val(identity);

          $("#edit_id").val(id);
          $("#edit_value").val(name);
        },
      });
    });

    $(".delete_proparty").click(function(){
      var id =  $(this).attr("proparty-id");

      var formdata = new FormData();
      formdata.append("proparty_id", id);

      var ajaxReq = $.ajax({
        url: '<?php echo base_url()?>user/delete_proparty_by_id',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function (xhr) {
        },
        success: function (data) {
          var obj = JSON.parse(data);

          if(obj.status == true){
            $('#tbl_proparty_'+id).remove();
            toastr["success"]("Delete Successful");
          }else{
            toastr["error"]("Delete Failed");
          }
        },
      });
    });

    $(".edit_area").click(function(){
      var id =  $(this).attr("area-id");

      var formdata = new FormData();
      formdata.append("area_id", id);

      var ajaxReq = $.ajax({
        url: '<?php echo base_url()?>user/fetch_area_by_id',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function (xhr) {
        },
        success: function (data) {
          var data = JSON.parse(data);
          $('.modal_button').click();
          var id = data[0]['id'];
          var value = data[0]['value'];
          var identity = "Area";

          $("#click_identity").val(identity);
          $("#edit_id").val(id);
          $("#edit_value").val(value);
        },
      });
    });

    $(".delete_area").click(function(){
      var id =  $(this).attr("area-id");

      var formdata = new FormData();
      formdata.append("area_id", id);

      var ajaxReq = $.ajax({
        url: '<?php echo base_url()?>user/delete_area_by_id',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function (xhr) {
        },
        success: function (data) {
          var obj = JSON.parse(data);

          if(obj.status == true){
            $('#tbl_area_'+id).remove();
            toastr["success"]("Delete Successful");
          }else{
            toastr["error"]("Delete Failed");
          }
        },
      });
    });

    $(".update_proparty").click(function(){
      var identity = $("#click_identity").val();

      if(identity == 'Proparty'){

        var id = $("#edit_id").val();
        var value = $("#edit_value").val();

        var formdata = new FormData();
        formdata.append("proparty_id", id);
        formdata.append("proparty_edit_value", value);

        var ajaxReq = $.ajax({
          url: '<?php echo base_url()?>user/edit_proparty_by_id',
          type: 'POST',
          processData: false,
          contentType: false,
          data: formdata,
          beforeSend: function (xhr) {
          },
          success: function (data) {
            var obj = JSON.parse(data);

            if(obj.status == true){
              $('.close').click();

              toastr.success('Update Successful', '', {
                onHidden: function() {
                  window.location='<?php echo base_url()?>add-property';
                }
              });

            }else{
              toastr["error"]("Update Failed");
            }
          },
        });

      }else{
        var id = $("#edit_id").val();
          var value = $("#edit_value").val();

          var formdata = new FormData();
          formdata.append("area_id", id);
          formdata.append("area_edit_value", value);

          var ajaxReq = $.ajax({
            url: '<?php echo base_url()?>user/edit_area_by_id',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function (xhr) {
            },
            success: function (data) {
              var obj = JSON.parse(data);
              
              if(obj.status == true){
                $('.close').click();

                toastr.success('Update Successful', '', {
                    onHidden: function() {
                        window.location='<?php echo base_url()?>add-property';
                    }
                });

              }else{
                toastr["error"]("Update Failed");
              }
            },
          });
      }



    });

  });
</script>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label class="control-label col-md-3">Proparty: </label>
          <label id="test_id"></label>
          <div class="col-md-8">
            <input type="hidden" id="click_identity">
            <input type="hidden" id="edit_id">
            <input class="form-control" type="text" id="edit_value" placeholder="Enter area">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_proparty">Save changes</button>
      </div>
    </div>
  </div>
</div>