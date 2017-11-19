<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Manage ARDOR Account </h3>
                        </div>
                        <div class="box-body">
                          <?= (isset($alert))?$alert:null ?>
                          <a href="<?= base_url("page/account/ardr?add") ?>" class="btn btn-success">Add Account</a>
                            <table class="table">
                              <thead>
                                  <th>Account Address</th>
                                  <th>Account Type</th>
                                  <th>Action</th>
                              </thead>
                              <tbody>
                                <tr>
                                    <td><?= $this->session->nxt_address ?></td>
                                    <td>Primary</td>
                                    <td>-</td>
                                </tr>
                                  <?php foreach($this->db->get_where("setAcc",array("id_user"=>$data_page->id_users))->result() as $dataList){ ?>
                                    <tr>
                                        <td><?= $dataList->nxt_address ?></td>
                                        <td>Secondary</td>
                                        <td><div style="padding-bottom:2px;"><a href="<?= base_url("page/account/ardr?setPrimary=".$dataList->id_acc)?>" class="btn btn-primary">Set Primary</a></div><a href="<?= base_url("page/account/ardr?delete=".$dataList->id_acc)?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                  <?php }?>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>
