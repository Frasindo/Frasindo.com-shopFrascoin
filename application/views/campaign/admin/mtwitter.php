<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Twitter Campaign</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" style="overflow: auto;max-height: 500px;">
                  <thead>
                    <th>Hastag</th>
                    <th>Created Date</th>
                    <th>Validated Date</th>
                    <th>User</th>
                    <th>Twitter Screen Name</th>
                    <th>Post Text</th>
                    <th>Post Link</th>
                    <th>Status</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php foreach ($listCampaign as $key => $value): ?>
                      <tr>
                        <td style="width: 10% ;"><?= $value["hastag"] ?></td>
                        <td style="width: 10% ;"><?= $value["created_date"] ?></td>
                        <td style="width: 10% ;"><?= $value["validated_date"] ?></td>
                        <td style="width: 10% ;"><?= $value["user"] ?></td>
                        <td style="width: 10% ;"><?= (count($value["data"]) > 0)?$value["data"]->statuses[0]->user->screen_name:"<span class='label label-danger'>Data Not Found</span>" ?></td>
                        <td style="width: 10% ;"><?= (count($value["data"]) > 0)?$value["data"]->statuses[0]->text:"<span class='label label-danger'>Data Not Found</span>" ?></td>
                        <td style="width: 10% ;"><?= (count($value["data"]) > 0)?"<a href='https://www.twitter.com/".$value["data"]->statuses[0]->user->screen_name."/status/".$value["data"]->statuses[0]->id_str."'>https://www.twitter.com/".$value["data"]->statuses[0]->user->screen_name."/status/".$value["data"]->statuses[0]->id_str."</a>":"<span class='label label-danger'>Data Not Found</span>" ?></td>
                      <td style="width: 10% ;"><?= ($value["status"] == 1)?"<span class='label label-success'>Valid</span>":"<span class='label label-danger'>Invalid</span>" ?></td>
                      <td style="width: 14% ;"><?= ($value["status"] == 1)?"<button class='btn btn-warning reject' data-uniq='".$value["hastag"]."' data-type='reject'>Reject</button> ":"<button class='btn btn-success accept' data-type='accept' data-uniq='".$value["hastag"]."'>Accept</button> " ?> <button class='btn btn-danger delete' data-uniq='<?= $value["hastag"] ?>'>Delete</button></td>
                      </tr>
                    <?php endforeach; //var_dump($value); ?>
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
              $.post(base_url+"rest/deletetwitter/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/twitter") ?>";},2000);
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
              $.post(base_url+"rest/updatetwitter/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/twitter") ?>";},2000);
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
              $.post(base_url+"rest/updatetwitter/",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/admin/twitter") ?>";},2000);
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
