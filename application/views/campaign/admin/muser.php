<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Users Manager</h3>
                             <div class="pull-right">
                                <button class="btn btn-success addUser"><li class="fa fa-plus"></li></button>
                             </div>
                        </div>
                        <div class="box-body">
                          <div class="col-md-12">
                          <table class="table table-striped">
                              <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Twitter</th>
                                <th>ARDOR</th>
                                <th>BTC</th>
                                <th>YT Channel ID</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                              <?php $n = 1; foreach ($listUsers as $key => $value): ?>
                                <tr>
                                <td><?= $n++ ?></td>
                                <td><?= $value["data_users"]["detail"]["nama"] ?></td>
                                <td><?= $value["data_users"]["username"] ?></td>
                                <td><?= $value["data_users"]["detail"]["email"] ?></td>
                                <td><?= $value["data_users"]["detail"]["twitter"] ?></td>
                                <td><?= $value["data_users"]["detail"]["ardor_addr"] ?></td>
                                <td><?= $value["data_users"]["detail"]["btc_addr"] ?></td>
                                <td><?= $value["data_users"]["detail"]["youtube"] ?></td>
                                <td><button class="btn btn-warning edit" data-id="<?= $value["data_users"]["id_users"] ?>"><li class="fa fa-edit"></li></button> <button data-id="<?= $value["data_users"]["id_users"] ?>" class="btn btn-danger delete"><li class="fa fa-trash"></li></button></td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <script>
              $(function() {
                $('.table').DataTable({});
                $(".table").on("click",".edit",function () {
                  var a = $(this);
                  $.get(base_url+"rest/fetchUsersCampaign/"+a.attr("data-id"),function(a) {
                    bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control nama" type="text" value="'+a.data[0].data_users.detail.nama+'" placeholder="Name"  /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control email" value="'+a.data[0].data_users.detail.email+'" type="email" placeholder="Email"  /></div></div><div class="col-md-12"><div class="form-group"><input value="'+a.data[0].data_users.username+'" class="form-control username" type="text" placeholder="Username" disabled /></div></div><div class="col-md-12"><div class="form-group"><input  class="form-control password" type="password" placeholder="Leave Blank If not Want to Change"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control twitter" value="'+a.data[0].data_users.detail.twitter+'" type="text" placeholder="Twitter Screen name"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control ardor" value="'+a.data[0].data_users.detail.ardor_addr+'" type="text" placeholder="ARDOR Address"/></div></div><div class="col-md-12"><div class="form-group"><input value="'+a.data[0].data_users.detail.btc_addr+'" class="form-control btc" type="text" placeholder="BTC Address"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control youtube" type="text" value="'+a.data[0].data_users.detail.youtube+'" placeholder="Youtube Channel ID"/></div></div></div>',function(d){
                      if(d)
                      {
                        datapost = {id_users:a.data[0].data_users.id_users,nama:$(".nama").val(),password:$(".password").val(),email:$(".email").val(),twitter:$(".twitter").val(),ardor_addr:$(".ardor").val(),btc_addr:$(".btc").val(),youtube:$(".youtube").val()};
                        var dialog = bootbox.dialog({
                          title: 'Please Wait . . .',
                          message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
                        });
                        dialog.init(function(){
                          setTimeout(function(){
                            $.post(base_url+"rest/editUsersCampaign",datapost,function(a){
                              if(a.status == 1)
                              {
                                dialog.find(".modal-title").html("Request Successfully");
                                dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                                setTimeout(function(){window.location = "<?= base_url("campaign/admin/musers") ?>";},2000);
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
                $(".addUser").on("click",function () {
                  bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control nama" type="text" placeholder="Name"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control email" type="email" placeholder="Email"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control username" type="text" placeholder="Username"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control password" type="password" placeholder="Password"  /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control twitter" type="text" placeholder="Twitter Screen name"  /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control ardor" type="text" placeholder="ARDOR Address"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control btc" type="text" placeholder="BTC Address"/></div></div><div class="col-md-12"><div class="form-group"><input class="form-control youtube" type="text" placeholder="Youtube Channel ID"/></div></div></div>',function(d){
                    if(d)
                    {
                      datapost = {nama:$(".nama").val(),username:$(".username").val(),password:$(".password").val(),email:$(".email").val(),twitter:$(".twitter").val(),ardor_addr:$(".ardor").val(),btc_addr:$(".btc").val(),youtube:$(".youtube").val()};
                      var dialog = bootbox.dialog({
                          title: 'Please Wait . . .',
                          message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
                      });
                      dialog.init(function(){
                          setTimeout(function(){
                            $.post(base_url+"rest/addUserCampaign",datapost,function(a){
                              if(a.status == 1)
                              {
                                dialog.find(".modal-title").html("Request Successfully");
                                dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                                setTimeout(function(){window.location = "<?= base_url("campaign/admin/musers") ?>";},2000);
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
                $(".table").on("click",".delete",function () {
                  var a = $(this);
                  bootbox.confirm('<div class="row"><div class="col-md-12"><center><h4>Are You Sure ? </h4></center></div></div>',function(d){
                    if(d)
                    {
                      var dialog = bootbox.dialog({
                          title: 'Please Wait . . .',
                          message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting . . . .</p></center>'
                      });
                      dialog.init(function(){
                          setTimeout(function(){
                            $.get(base_url+"rest/deleteUsersCampaign/"+a.attr("data-id"),function(a){
                              if(a.status == 1)
                              {
                                dialog.find(".modal-title").html("Request Successfully");
                                dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                                setTimeout(function(){window.location = "<?= base_url("campaign/admin/musers") ?>";},2000);
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
