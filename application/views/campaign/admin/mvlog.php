<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Vlog Campaign</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" style="overflow: auto;max-height: 500px;">
                  <thead>
                    <th>Hastag</th>
                    <th>Created Date</th>
                    <th>Validated Date</th>
                    <th>Username</th>
                    <th>Vid Desc</th>
                    <th>Vid Link</th>
                    <th>Status</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php foreach ($listCampaign as $key => $value): ?>
                      <tr>
                        <td style="width: 10% ;"><?= $value["unique_code"] ?></td>
                        <td style="width: 10% ;"><?= $value["created_date"] ?></td>
                        <td style="width: 10% ;"><?= $value["validated_date"] ?></td>
                        <td style="width: 10% ;"><?= $value["user"] ?></td>
                        <td style="width: 10% ;"><?= (count($value["data"]) > 0)?$value["data"]->description:"<span class='label label-danger'>Data not Found</span>" ?></td>
                        <td style="width: 10% ;"><?= (count($value["data"]) > 0)?"<a href='".$value["data"]->link."'>".$value["data"]->link."</a>":"<span class='label label-danger'>Data not Found</span>" ?></td>
                        <td style="width: 10% ;"><?= (count($value["data"]) > 0)?($value["validated"] == 1)?"<span class='label label-success'>Valid</span>":"<span class='label label-danger'>Invalid</span>":"<span class='label label-danger'>Data not Found</span>" ?></td>
                        <td style="width: 15% ;"><?= (count($value["data"]) > 0)?($value["validated"] == 1)?"<button class='btn btn-warning reject' data-uniq='".$value["unique_code"]."' data-type='reject'>Reject</button>":"<button data-uniq='".$value["unique_code"]."' data-type='accept' class='btn btn-success accept'>Accept</button>":"" ?> <button data-uniq='<?= $value["unique_code"] ?>' class='btn btn-danger delete'>Delete</button></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<script>
$(function() {
  $('.table').DataTable({});
  $(".table").on("click",".delete",function(){
    var a = $(this);
    var datapost;
    datapost = {uniqid:a.attr("data-uniq")};
    bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
      if(d)
      {
        var dialog = bootbox.dialog({
            title: 'Please Wait . . .',
            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting  . . . .</p></center>'
        });
        dialog.init(function(){
            setTimeout(function(){
              $.post(base_url+"rest/deleteyt/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/youtube") ?>";},2000);
                }else{
                  dialog.find(".modal-title").html("Request Rejected");
                  dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                }
              });
            }, 1000);
        });
      }
    });
  });
  $(".table").on("click",".reject",function(){
    var a = $(this);
    var datapost;
    datapost = {uniqid:a.attr("data-uniq"),type:a.attr("data-type")};
    bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
      if(d)
      {
        var dialog = bootbox.dialog({
            title: 'Please Wait . . .',
            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
        });
        dialog.init(function(){
            setTimeout(function(){
              $.post(base_url+"rest/updateyoutube/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/youtube") ?>";},2000);
                }else{
                  dialog.find(".modal-title").html("Request Rejected");
                  dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                }
              });
            }, 1000);
        });
      }
    });
  });
  $(".table").on("click",".accept",function(){
    var a = $(this);
    var datapost;
    datapost = {uniqid:a.attr("data-uniq"),type:a.attr("data-type")};
    bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
      if(d)
      {
        var dialog = bootbox.dialog({
            title: 'Please Wait . . .',
            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
        });
        dialog.init(function(){
            setTimeout(function(){
              $.post(base_url+"rest/updateyoutube/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/youtube") ?>";},2000);
                }else{
                  dialog.find(".modal-title").html("Request Rejected");
                  dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                }
              });
            }, 1000);
        });
      }
    });
  });
});
</script>
