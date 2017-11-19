<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Blogger Campaign</h3>
              <div class="pull-right">
                  <button class="btn btn-success submitLink">Submit Link</button>
              </div>
            </div>
            <div class="box-body">
              <center>Your Blogger Unique Hastag is : <b><?= $this->session->blog_unique ?></b></center>
              <div class="table-responsive">
                <table class="table" style="overflow: auto;max-height: 500px;">
                  <thead>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Submited</th>
                  </thead>
                  <tbody>
                    <?php foreach ($listSubmited->result() as $key => $value) {?>
                    <tr>
                      <td><?= $value->link ?></td>
                      <td><?= ($value->status != 0)?"<span class='label label-success'>Valid</span>":"<span class='label label-danger'>Invalid / Pending</span>" ?></td>
                      <td><?= $value->created ?></td>
                    </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Guides</h3>
            </div>
            <div class="box-body">
              <ol>
                <li>Submit Link Article in Your Blog</li>
                <li>Post Your Unique Hastag in Your Blog</li>
                <li>One post put one Unique Hastag</li>
                <li>Min 450 Character and must have minimal 1 picture</li>
                <li>In example "This end your post #yourhastag"</li>
              </ol>
            </div>
          </div>
        </div>
    </div>
  </section>
</div>
<script>
$(function() {
  $(".submitLink").click(function() {
    bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control link" type="text" placeholder="Put Your Link use http://domain.com"  /></div><div class="col-md-12"><div class="generated"></div></div></div></div>', function(result) {
      if(result)
      {
        var link = $(".link").val();
        datapost = {link:link};
        var dialog = bootbox.dialog({
            title: 'Please Wait . . .',
            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
        });
        dialog.init(function(){
            setTimeout(function(){
              $.post(base_url+"rest/savelink",datapost,function(a){
                if(a.status == 1)
                {
                  dialog.find(".modal-title").html("Request Successfully");
                  dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  setTimeout(function(){window.location = "<?= base_url("campaign/page/blogger") ?>";},2000);
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
