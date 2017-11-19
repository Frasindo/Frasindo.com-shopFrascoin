<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Signature Campaign</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" style="overflow: auto;max-height: 500px;">
                  <thead>
                    <th>Created Date</th>
                    <th>Validated Date</th>
                    <th>Username</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php foreach ($list->result() as $key => $value): ?>
                      <tr>
                        <td style="width:10%;"><?= $value->created ?></td>
                        <td style="width:10%;"><?= $value->validated ?></td>
                        <td style="width:10%;"><?= $value->username ?></td>
                        <td style="width:10%;"><a href="<?= $value->link ?>"><?= $value->link ?></a></td>
                        <td style="width:10%;"><?= ($value->status == 1)?"<span class='label label-success'>Valid</span>":"<span class='label label-danger'>Invalid</span>" ?></td>
                        <td style="width:15%;"><?= ($value->status == 1)?"<button class='btn btn-warning reject' data-id='".$value->id_sc."' data-type='0'>Reject</button>":"<button class='btn btn-success accept' data-id='".$value->id_sc."' data-type='1'>Accept</button>" ?> <button class='btn btn-danger delete' data-id='<?= $value->id_sc ?>'>Delete</button</td>
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
    datapost = {id:a.attr("data-id")};
    bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
      if(d)
      {
        var dialog = bootbox.dialog({
            title: 'Please Wait . . .',
            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting  . . . .</p></center>'
        });
        dialog.init(function(){
            setTimeout(function(){
              $.post(base_url+"rest/deletesign/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/signature") ?>";},2000);
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
  datapost = {id:a.attr("data-id"),type:a.attr("data-type")};
  bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
    if(d)
    {
      var dialog = bootbox.dialog({
          title: 'Please Wait . . .',
          message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
      });
      dialog.init(function(){
          setTimeout(function(){
            $.post(base_url+"rest/updatesign/",datapost,function(a){
              if(a.status == 1)
              {
                dialog.find(".modal-title").html("Request Successfully");
                dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                setTimeout(function(){window.location = "<?= base_url("campaign/admin/signature") ?>";},2000);
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
  datapost = {id:a.attr("data-id"),type:a.attr("data-type")};
  bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
    if(d)
    {
      var dialog = bootbox.dialog({
          title: 'Please Wait . . .',
          message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
      });
      dialog.init(function(){
          setTimeout(function(){
            $.post(base_url+"rest/updatesign/",datapost,function(a){
              if(a.status == 1)
              {
                dialog.find(".modal-title").html("Request Successfully");
                dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                setTimeout(function(){window.location = "<?= base_url("campaign/admin/signature") ?>";},2000);
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
