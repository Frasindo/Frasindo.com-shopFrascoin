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
                        </div>
                        <div class="box-body">
                          <table class="table usr">
                                        <thead>
                                          <th>#</th>
                                          <th>Name</th>
                                          <th>Username</th>
                                          <th>Email</th>
                                          <th>ARDOR Address</th>
                                          <th>Fras Balance</th>
                                          <th>ICO Address</th>
                                          <th>Actions</th>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($listUser as $key => $value) {?>
                                          <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $value["nama"] ?></td>
                                            <td><?= $value["username"] ?></td>
                                            <td><?= $value["email"] ?></td>
                                            <td><?= ($value["fiilingAddr"] != false)?$value["nxt_address"]:"<span class='label label-danger'>Account Not Have Address</span>" ?></td>
                                            <td><?= $value["frasBalance"] ?></td>
                                            <td><?= ($value["fiilingAddr"] != false)?$value["btc_address"]:"<span class='label label-danger'>Account Not Have Address</span>" ?></td>
                                            <td><button class="btn btn-danger deleteAkun" data-email="<?= $value["email"] ?>"><li class="fa fa-trash"></li></button></td>
                                          </tr>
                                        <?php } ?>
                                          <?php ?>
                                        </tbody>
                                      </table>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <script>
              $('.table').DataTable({
                 "scrollX": true
             });
             $(function(){

               $(".addUserakun").click(function() {
                   bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control nama" placeholder="Name" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control user" placeholder="Username" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control pass" placeholder="Password" type="password" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control email" placeholder="Email" /></div></div></div>', function(result) {
                     if(result)
                     {
                       var nama = $(".nama").val();
                       var user = $(".user").val();
                       var pass = $(".pass").val();
                       var email = $(".email").val();
                       if(nama.length > 3 && user.length > 3 && pass.length > 3 && email.length > 5 )
                       {
                         var datapost = {email:email,nama:nama,user:user,pass:pass};
                         var dialog = bootbox.dialog({
                             title: 'Please Wait . . .',
                             message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
                         });
                         dialog.init(function(){
                             setTimeout(function(){
                               $.post(base_url+"rest/adduser",datapost,function(a){
                                 if(a.status == 1)
                                 {
                                   dialog.find(".modal-title").html("Request Successfully");
                                   dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                                   location.reload(true);
                                 }else{
                                   dialog.find(".modal-title").html("Request Rejected");
                                   dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                                 }
                               });
                             }, 1000);
                         });
                       }else{
                         bootbox.alert("Opps Something Error Check All Field. Name,Username,Password must be more than 3 and email more than 5 words");
                       }
                     }
                 });
               });
               $(".table").on("click",".deleteAkun", function() {
                 var e = $(this);
                 var email = e.attr("data-email");
                 bootbox.confirm('<div class="row"><center><h2>Are You Sure ?</h2></center></div>', function(a) {
                   if(a)
                   {
                     var dialog = bootbox.dialog({
                       title: 'Please Wait . . .',
                       message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting  . . . .</p></center>'
                     });
                     dialog.init(function(){
                       setTimeout(function(){
                         $.post(base_url+"rest/deleteadmin",{email:email},function(a){
                           if(a.status == 1)
                           {
                             dialog.find(".modal-title").html("Request Successfully");
                             dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
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
