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
             <h3 class="box-title">Create Ticket</h3>
             <div class="box-tools pull-right">
             <!-- /.box-tools -->
           </div>
           <!-- /.box-header -->
           <div class="box-body">
             <?= (isset($alert))?$alert:null ?>
             <form class="form-horizontal" action="" method="post">
             <div class="form-group">
               <select class="form-control" name="department_id" required>
                   <option value="" disabled selected hidden>Please Choose Department...</option>
                   <?php
                        foreach ($data_page->result() as $key => $value) {
                          echo '<option value="'.$value->id_department.'">'.$value->department_name.'</option>';
                        }
                   ?>
               </select>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Title" name="masalah" required>
              </div>
              <div class="form-group">
                    <textarea id="compose-textarea" name="isi" class="form-control" style="height: 300px" required></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Send Ticket</button>
              </div>
            </form>
            </div>
              <script>
                 CKEDITOR.replace( 'compose-textarea' );
             </script>
           </div>
         </div>
       </div>
     </div>
   </section>
 </div>
