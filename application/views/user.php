<?php include 'include/header.php' ?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-users"></i> Users</h1>
      <p>View all users</p>
    </div>
        <!-- <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul> -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th> 
                    <th>Company</th>
                    <th>Identity Image</th>
                    <th>Approval</th>
                    <th>Points</th>
                    <th>Date & Time</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  for ($i = 0; $i<sizeof($data); $i++){
                    ?>
                    <tr>
                      <td><?php echo $data[$i]->name; ?></td>
                      <td><?php echo $data[$i]->email; ?></td>
                      <td><?php echo $data[$i]->company; ?></td>
                      <td>
                        <a href="http://localhost/factcheck/uploads/<?php echo $data[$i]->image; ?>">View Image</a>
                      </td>

                      <?php
                      $approval = $data[$i]->approval;
                      if($approval == "PENDING"){
                        $value = "Pending";
                        $button = "primary";
                      }elseif($approval == "REGECTED"){
                        $value = "Regected";
                        $button = "danger";
                      }else{
                        $value = "Accepted";
                        $button = "success";
                      }

                      ?>
                      <td>
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                          <button class="btn btn-<?php echo $button ?>" type="button"><?php echo $value ?></button>
                          <?php
                          if($value != "Accepted"){
                            ?>
                            <div class="btn-group" role="group">
                              <button class="btn btn-<?php echo $button ?> dropdown-toggle btn-sm" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                              <div class="dropdown-menu dropdown-menu-right">

                                <?php if($value == "Pending"){  ?>
                                  <a type="button" class="dropdown-item user_accept" user_id="<?php echo $data[$i]->id; ?>" href="javascript:void(0);">Accepted</a>
                                  
                                  <a type="button" user_id="<?php echo $data[$i]->id; ?>" class="dropdown-item user_reject" href="javascript:void(0);"  >Regected</a>
                                <?php } ?>
                                <?php if($value == "Regected"){  ?>
                                  <a type="button" class="dropdown-item user_accept" user_id="<?php echo $data[$i]->id; ?>" href="javascript:void(0);">Accepted</a>
                                <?php } ?>

                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      </td>
                      <td><?php echo $data[$i]->points; ?></td>
                      <?php
                      $dt = new DateTime($data[$i]->created);
                      $date = $dt->format('d-m-Y');
                      ?>
                      <td><?php echo $date ?></td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div class="modal fade" id="myModal" role="dialog">

    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".user_accept").click(function(){
          var id =  $(this).attr("user_id");
          
          var formdata = new FormData();
          formdata.append("user_id", id);
          formdata.append("type", "ACCEPTED");

          var ajaxReq = $.ajax({
            url: '<?php echo base_url()?>user/user_accept',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function (xhr) {
            },
            success: function (data) {
              window.location='<?php echo base_url()?>user/users';
            },

          });

        });
      });

      $(document).ready(function(){
        $(".user_reject").click(function(){
          var id =  $(this).attr("user_id");
          var st = '';
          st = st + '<div class="modal" style="position: relative; top: auto; right: auto; left: auto; bottom: auto; z-index: 1; display: block;"> <div class="modal-dialog" role="document"> <div class="modal-content">  <div class="modal-header"> <h5 class="modal-title">Rejected message </h5> <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> </div> <div class="modal-body form-group"> <input type="hidden" id="user_reject_id" value="'+id+'"> <textarea class="form-control" rows="5" id="comment" name="message" placeholder="Enter message here..."></textarea> </div> <div class="modal-footer"> <button type="button" class="btn btn-primary btn_reject" >Done</button> </div>  </div> </div> </div> </div>';


          $("#myModal").html(st).modal('show');
        });
        
        $(document).on('click', '.btn_reject', function(){
          var message = $.trim($("#comment").val());
          var user_reject_id = $.trim($("#user_reject_id").val());

          var formdata = new FormData();
          formdata.append("message", message);
          formdata.append("user_id", user_reject_id);
          formdata.append("type", "REGECTED");

          var ajaxReq = $.ajax({
            url: '<?php echo base_url()?>user/user_reject',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function (xhr) {
            },
            success: function (data) {
              var obj = JSON.parse(data);
              if(obj.status){
                window.location='<?php echo base_url()?>user/users';
              }else{
                toastr["error"]("Failed");
              }

            },
          });


        });
      });


      
    </script>

    <?php include 'include/footer.php' ?>