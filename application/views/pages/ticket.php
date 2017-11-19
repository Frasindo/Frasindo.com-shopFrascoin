<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
   <section class="content-header">
     <h1>
       Support Ticket
     </h1>
   </section>
   <section class="content">
     <div class="row">
       <div class="col-md-3">
         <a href="<?= base_url("page/ticket/create") ?>" class="btn btn-primary btn-block margin-bottom">Create Ticket</a>

         <div class="box box-solid">
           <div class="box-header with-border">
             <h3 class="box-title">Folders</h3>

             <div class="box-tools">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
               </button>
             </div>
           </div>
           <div class="box-body no-padding">
             <ul class="nav nav-pills nav-stacked">
               <li><a href="<?= base_url("page/ticket/") ?>"><i class="fa fa-inbox"></i> All Ticket</a></li>
             </ul>
           </div>
           <!-- /.box-body -->
         </div>

       </div>
       <div class="col-md-9">
         <div class="box box-primary">
           <div class="box-header with-border">
             <h3 class="box-title">List Ticket</h3>
             <div class="box-tools pull-right">
             <!-- /.box-tools -->
           </div>
           <!-- /.box-header -->
           <div class="box-body no-padding">
             <div class="col-md-12">
             <div class="table-responsive mailbox-messages">
                <?= (isset($alert))?$alert:null ?>
                 <table class="table table-hover table-striped" id="dynatable">
                   <thead>
                      <th>ID</th>
                      <th>Ticket</th>
                      <th>Department</th>
                      <th>Status</th>
                      <th>Created</th>
                      <th>Action</th>
                   </thead>
                   <tbody>
                     <?php foreach ($data_page->result() as $key) {?>
                     <tr>
                        <td><?= $key->id_tiket ?></td>
                        <td><a href="<?= base_url("page/ticket/detail/".$key->id_tiket) ?>"><?= $key->masalah ?></a></td>
                        <td><?= $key->department_name ?></td>
                        <td><?php if($key->status == 0)
                        {
                          echo "<label class='label label-warning'>Ticket Created</label>";
                        }elseif ($key->status == 1) {
                          echo "<label class='label label-success'>Answered By Admin</label>";
                        }elseif ($key->status == 2) {
                          echo "<label class='label label-success'>Answered by User</label>";
                        }else{
                          echo "<label class='label label-danger'>Closed</label>";
                        } ?></td>
                        <td><?= $key->date ?></td>
                        <td><a  href="<?= base_url("page/ticket/detail/".$key->id_tiket)?>" class="btn btn-success" <?= ($key->status > 2)?"style='pointer-events: none; cursor: default;' disabled":null ?>>Reply</a>
                     </tr>
                     <?php } ?>
                   </tbody>
                 </table>
               </div>
             </div>
             </div>
             <script>
              $('#dynatable').dynatable();
             </script>
           </div>
         </div>
       </div>
     </div>
   </section>
 </div>
