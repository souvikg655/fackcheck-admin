<?php include 'include/header.php' ?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-home"></i> Homes</h1>
      <p>View all homes</p>
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
                    <th>Title</th>
                    <th>Realtor Name</th>
                    <th>Home Details</th>
                    <th>Province</th>
                    <th>Postal Code</th>
                    <th>Address</th>
                    <th>Municipality Paper</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  for ($i = 0; $i<sizeof($data); $i++){
                    ?>
                    <tr>
                      <td><?php echo $data[$i]->title; ?></td>
                      <td><?php echo $data[$i]->name; ?></td>
                      <td>
                        <a class="btn btn-outline-primary" href="javascript:void(0);" target="_blank">Details</a>
                      </td>
                      <td><?php echo $data[$i]->province; ?></td>
                      <td><?php echo $data[$i]->postal; ?></td>
                      <td><?php echo $data[$i]->address; ?></td>
                      <td>
                        <a class="btn btn-outline-primary" href="http://localhost/factcheck/municipality_papers/<?php echo $data[$i]->municipality_paper; ?>" target="_blank"><i class="fa fa-eye"></i> View</a>
                      </td>
                      <?php
                      $status_value = $data[$i]->status;
                      if($status_value == "PENDING"){
                        $check = "primary";
                        $value = "Pending";
                      }elseif ($status_value == "APPROVED") {
                        $check = "success";
                        $value = "Approved";
                      }else{
                        $check = "danger";
                        $value = "Regected";
                      }
                      ?>
                      <td>
                        <div class="btn-group " role="group" aria-label="Button group with nested dropdown">
                          <button class="btn btn-<?php echo $check ?>" type="button"><?php echo $value ?></button>
                          <?php 
                          if($value != "Approved" && $value != "Regected"){
                            ?>
                            <div class="btn-group" role="group">
                              <button class="btn btn-<?php echo $check ?> dropdown-toggle" id="btnGroupDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <?php
                                if($value == "Pending"){
                                  ?>
                                  <a type="button" class="dropdown-item" id="home_accept" realtor_id="<?php echo $data[$i]->realtor_id; ?>" user_id="<?php echo $data[$i]->id; ?>" href="javascript:void(0);">Accepted</a>

                                  <a type="button" user_id="<?php echo $data[$i]->id; ?>" class="dropdown-item" href="javascript:void(0);" id="home_reject" >Regected</a>
                                <?php } ?>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      </td>

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

    <div class="modal fade" id="myModal" role="dialog"></div>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#home_accept").click(function(){
          var id =  $(this).attr("user_id");
          var realtor_id =  $(this).attr("realtor_id");
          
          var formdata = new FormData();
          formdata.append("home_id", id);
          formdata.append("realtor_id", realtor_id);
          formdata.append("type", "APPROVED");

          var ajaxReq = $.ajax({
            url: '<?php echo base_url()?>homes/home_accept',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function (xhr) {
            },
            success: function (data) {
              var obj = JSON.parse(data);
              if(obj.status){
                window.location='<?php echo base_url()?>user/homes';
              }else{
                toastr["error"]("Failed");
              }
            },

          });

        });
      });

      $(document).ready(function(){
        $("#home_reject").click(function(){
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
          formdata.append("home_id", user_reject_id);
          formdata.append("type", "REJECTED");

          var ajaxReq = $.ajax({
            url: '<?php echo base_url()?>homes/home_reject',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function (xhr) {
            },
            success: function (data) {
              var obj = JSON.parse(data);
              if(obj.status){
                window.location='<?php echo base_url()?>user/homes';
              }else{
                toastr["error"]("Failed");
              }
            },
          });


        });
      });
    </script>

    <?php include 'include/footer.php' ?>