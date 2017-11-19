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
       <?php $DataTiket = $data_page["dataTicket"]->result()[0]; ?>
       <div class="col-md-9">
         <div class="box box-primary">
           <div class="box-header with-border">
             <h3 class="box-title"><?= $DataTiket->masalah ?></h3>
           </div>
           <div class="box-body">
             <?= (isset($alert))?$alert:null ?>
              <div class="col-md-12">
                  <?= $DataTiket->isi ?>
              </div>
           </div>
           <div class="box-footer box-comments ">
              <?php foreach($data_page["dataReply"]->result() as $dataRep){ ?>
                <div class="box-comment">
                    <img class="img-circle img-sm" src="<?= ($dataRep->reply_by == "admin")?"https://d30y9cdsu7xlg0.cloudfront.net/png/17241-200.png":base_url($this->session->avatar) ?>" alt="User Image">
                    <div class="comment-text">
                        <span class="username"><?= ($dataRep->reply_by == "admin")?$dataRep->department_name:$this->session->nama ?><span class="text-muted pull-right"><?= $dataRep->reply_date ?></span>
                        </span>
                        <?= $dataRep->isi_reply ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php if($DataTiket->status < 3){  ?>
           <div class="box-footer">
             <?= (isset($alert_comments))?$alert_comments:null ?>
             <form class="form-horizontal" action="" method="post">
             <div class="col-md-12">
               <textarea id="reply" name="reply"></textarea>
             </div>
             <div style="padding-top:5px;" class="col-md-3">
             <button class="btn btn-primary" type="submit">Reply</button>
            </div>
           </form>

            <form class="form-horizontal" action="" method="post">
              <div style="padding-top:5px;" class="col-md-9">
              <button class="btn btn-danger pull-right" type="submit" name="close">Close</button>
             </div>
            </form>
            <?php } ?>
             <script>
                CKEDITOR.replace( 'reply' );
            </script>
           </div>
           </div>
         </div>
       </div>
     </div>
   </section>
 </div>
