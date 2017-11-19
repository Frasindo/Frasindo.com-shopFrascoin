<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Setting Account</h3>
                        </div>
                        <div class="box-body">
                                <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                    <div class="text-center">
                                    <img src="<?= $this->gravatar->get($this->session->email) ?>" style="padding-left:15px;padding-bottom:15px;" class="avatar  img-responsive" alt="avatar">
                                    <a target="_blank" href="https://en.gravatar.com" class="btn btn-success">Change <br>Gravatar</a>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-9 personal-info">
                                    <h3>Personal info</h3>
                                    <?= (isset($alert))?$alert:null ?>
                                    <form class="form-horizontal" action="" method="post" role="form">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Full Name:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control" name="nama" value="<?= $data_page->nama ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Birthday:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control" id="bd" name="birth" placeholder="[OPTIONAL]Birthday offer" value="<?= $data_page->birth ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Username:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control"  value="<?= $this->session->username ?>" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">ARDOR Account:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control"  value="<?= $this->session->nxt_address ?>" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Line ID:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control" name="lineid" placeholder="[OPTIONAL]easy VIDEO CALL" value="<?= $data_page->lineid ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">WhatsApp:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control" name="wa" placeholder="[OPTIONAL]easy VIDEO CALL" value="<?= $data_page->wa ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Two Factor Auth:</label>
                                        <div class="col-lg-8">
                                        <input id="twofa" <?= ($data_page->twofactor == 1)?"checked":null ?> data-toggle="toggle" type="checkbox">
                                        </div>
                                        <div id="showIT" class="col-lg-12 hidden">
                                         <div class="text-center">
                                             <p>Scan Barcode 2FA</p>
                                            <img id="faimg" src="" width="30%" heigth="auto" class="avatar img-responive" alt="Google Auth">
                                         </div>
                                        </div>
                                        <?php if($data_page->twofactor == 1){?>
                                        <div class="col-lg-12">
                                         <div class="text-center">
                                             <p>Scan Barcode 2FA</p>
                                            <img src="<?= (isset($authy))?$authy:null ?>" width="30%" heigth="auto" class="avatar img-responive" alt="Google Auth">
                                         </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-8">
                                        <input class="btn btn-primary" value="Save Changes" type="submit">
                                        <span></span>
                                        <input class="btn btn-default" value="Cancel" type="reset">
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Manage ARDOR Address </h3>
                        </div>
                        <div class="box-body">
                          <?= (isset($alert_m))?$alert_m:null ?>
                          <a href="<?= base_url("page/account?add") ?>" class="btn btn-success">Add Account</a>
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                  <th>Account Address</th>
                                  <th>Account Type</th>
                                  <th>FRAS</th>
                                  <th>CAR</th>
                                  <th>Notes</th>
                                  <th>Action</th>
                              </thead>
                              <?php $dataS = $this->acc->checksaldo(trim($this->session->nxt_address," "),"asemcoin"); ?>
                              <tbody>
                                <tr>
                                    <td><?= $this->session->nxt_address ?></td>
                                    <td>Primary</td>
                                    <td><?= $this->str->add_comma((isset($dataS->quantityQNT))?$dataS->quantityQNT:"",8) ?></td>
                                    <td><?= $this->bill->carBalance($this->session->nxt_address) ?></td>
                                    <td><?= $this->db->get_where("user_info",array("nxt_address"=>$this->session->nxt_address))->result()[0]->notes ?></td>
                                </tr>
                                  <?php foreach($this->db->get_where("setAcc",array("id_user"=>$data_page->id_users))->result() as $dataList){ ?>
                                    <tr>
                                        <td><?= $dataList->nxt_address ?></td>
                                        <td>Secondary</td>
                                        <td><?= $this->str->add_comma((isset($this->acc->checksaldo(trim($dataList->nxt_address," "),"asemcoin")->quantityQNT))?$this->acc->checksaldo(trim($dataList->nxt_address," "),"asemcoin")->quantityQNT:"",8) ?></td>
                                        <td><?= $this->bill->carBalance(trim($dataList->nxt_address," ")) ?></td>
                                        <td><?= $dataList->notes ?></td>
                                        <td><div style="padding-bottom:2px;"><a href="<?= base_url("page/account?setPrimary=".$dataList->id_acc)?>" class="btn btn-primary">Set Primary</a></div><?= ($this->session->authy != 0)?'<a href="'.base_url('page/account?delete='.$dataList->id_acc).'" class="btn btn-danger">Delete</a>':null ?></td>
                                    </tr>
                                  <?php }?>
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

    $( "#twofa" ).change(function() {
      var param = $("#twofa").is(':checked');
      $.get(base_url + "rest/twofa/"+param, function(data) {
          if(param == true)
          {
            $("#faimg").removeAttr("class");
            $("#faimg").attr("src",data.msg);
            $("#showIT").removeAttr("class");
            $("#showIT").attr("class","col-lg-12");
          }else{
            $("#showIT").addClass("hidden");
            alert(data.msg);
          }
      });
    });
});
</script>
