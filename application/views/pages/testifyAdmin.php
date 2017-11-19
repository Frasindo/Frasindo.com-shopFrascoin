<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
tbody {
    overflow-y: auto;    /* Trigger vertical scroll    */
    overflow-x: hidden;  /* Hide the horizontal scroll */
}
</style>
<script>
    var base_url = "<?= base_url() ?>";
</script>

    <div class="content-wrapper">
        <section class="content">
          <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">APPROVED TESTIMONY</span>
                          <span class="info-box-number"><?= $approve ?></span>
                      </div>
                  </div>
              </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-ban"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">UNAPROVED TESTIMONY</span>
                        <span class="info-box-number"><?= $unapprove ?></span>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Testify Manager</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-12">
                                  <center><form method="post"><button class="btn btn-<?= (isset($_POST["approve"]))?"danger":"success" ?>" type="submit" name="<?= (isset($_POST["approve"]))?"unapprove":"approve" ?>"><li class="fa fa-<?= (isset($_POST["approve"]))?"ban":"check" ?>"></li> <?= (isset($_POST["approve"]))?"Show Unapprove Testify":"Show Approved Testify" ?></button></center></form>
                                </div>
                              </div>
                                <div class="table-responsive">
                                  <table class="table" id="dynatable">
                                    <thead>
                                        <th>#</th>
                                        <th>Testify From</th>
                                        <th>Massage</th>
                                        <th>Job</th>
                                        <th>Company</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                      <?php $i =1; foreach ($list as $key => $value) { ?>
                                      <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $value->nama ?></td>
                                        <td><?= $value->isi ?></td>
                                        <td><?= $value->job ?></td>
                                        <td><?= $value->company ?></td>
                                        <td><button type="button" data-id="<?= $value->id_testi ?>" class="btn btn-<?=($value->status == 1)?"danger":"success" ?>" id="<?=($value->status == 1)?"banID":"checkID" ?>"><li class="fa fa-<?=($value->status == 1)?"ban":"check" ?>"></li></button> <button type="button" class="btn btn-danger" data-id="<?= $value->id_testi ?>" id="delID"><li class="fa fa-trash" ></li></button></td>
                                      </tr>
                                      <?php  } ?>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
    $(function() {
      $('#dynatable').dynatable();
      $("#banID").on("click",function() {
        var a = $(this);
        bootbox.confirm('<div class="row"><div class="col-md-12"><p>Really to Unapprove Testify ?</p></div></div>', function(result) {
          if(result)
          {
            var e = $(this);
            var amount = $(".amount").val();
            var fromAddr = $(".fromAddr").val();
            var dialog = bootbox.dialog({
                title: 'Please Wait . . .',
                message: '<center><p><i class="fa fa-spin fa-spinner"></i> Set to Unapprove Testify  . . . .</p></center>'
            });
            dialog.init(function(){
              setTimeout(function(){
                  $.post(base_url+"rest/testimoniStatus",{id:a.attr("data-id"),status:0},function(result){
                    if(result.status == 1)
                    {
                      dialog.find(".modal-title").html("Request Successfully");
                      dialog.find(".modal-body").html("<div class='alert alert-success'><center><p>"+result.msg+"</p></center></div>");
                      location.reload();
                    }else{
                      dialog.find(".modal-title").html("Request Rejected");
                      dialog.find(".modal-body").html("<div class='alert alert-danger'><center><p>"+result.msg+"</p></center></div>");
                    }
                  });
              }, 1000);
            });
          }
          });
      });
      $("#checkID").on("click",function() {
        var e = $(this);
        bootbox.confirm('<div class="row"><div class="col-md-12"><p>Really to Approve Testify ?</p></div></div>', function(result) {
          if(result)
          {
            var amount = $(".amount").val();
            var fromAddr = $(".fromAddr").val();
            var dialog = bootbox.dialog({
                title: 'Please Wait . . .',
                message: '<center><p><i class="fa fa-spin fa-spinner"></i> Set to Approved Testify  . . . .</p></center>'
            });
            dialog.init(function(){
                setTimeout(function(){
                    $.post(base_url+"rest/testimoniStatus",{id:e.attr("data-id"),status:1},function(result){
                      if(result.status == 1)
                      {
                        dialog.find(".modal-title").html("Request Successfully");
                        dialog.find(".modal-body").html("<div class='alert alert-success'><center><p>"+result.msg+"</p></center></div>");
                        location.reload();
                      }else{
                        dialog.find(".modal-title").html("Request Rejected");
                        dialog.find(".modal-body").html("<div class='alert alert-danger'><center><p>"+result.msg+"</p></center></div>");
                      }
                    });
                }, 1000);
            });
          }
          });
      });
      $("#delID").on("click",function() {
        var d = $(this);
        bootbox.confirm('<div class="row"><div class="col-md-12"><p>Really to Delete Testify ?</p></div></div>', function(result) {
          if(result)
          {
            var amount = $(".amount").val();
            var fromAddr = $(".fromAddr").val();
            var dialog = bootbox.dialog({
                title: 'Please Wait . . .',
                message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting Testify  . . . .</p></center>'
            });
            dialog.init(function(){
                setTimeout(function(){
                  $.get(base_url+"rest/testimoniDel/"+d.attr("data-id"),function(result){
                    if(result.status == 1)
                    {
                      dialog.find(".modal-title").html("Request Successfully");
                      dialog.find(".modal-body").html("<div class='alert alert-success'><center><p>"+result.msg+"</p></center></div>");
                      location.reload();
                    }else{
                      dialog.find(".modal-title").html("Request Rejected");
                      dialog.find(".modal-body").html("<div class='alert alert-danger'><center><p>"+result.msg+"</p></center></div>");
                    }
                  });
                }, 1000);
            });
          }
          });
      });
    });
    </script>
