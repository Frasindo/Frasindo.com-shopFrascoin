<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Setting Account</h3>
                        </div>
                        <div class="box-body">
                                <div class="row">
                                <!-- left column -->
                                <div class="col-md-3">
                                    <div class="text-center">
                                    <img src="<?= $user_info["picture"] ?>" class="avatar img-circle img-responsive" alt="avatar">
                                    <a href="<?= base_url("page/account/?reset") ?>" class="btn btn-success">Upload</a>
                                    </div>
                                </div>
                                <!-- edit form column -->
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
                                        <input class="form-control" id="bd" name="birth" value="<?= $data_page->birth ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Username:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control"  value="<?= $this->session->username ?>" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Line ID:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control" name="lineid" value="<?= $data_page->lineid ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">WA:</label>
                                        <div class="col-lg-8">
                                        <input class="form-control" name="wa" value="<?= $data_page->wa ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Two Factor Auth:</label>
                                        <div class="col-lg-8">
                                        <div class="ui-select">
                                            <select id="user_time_zone" name="twofactor" class="form-control">
                                            <?php if($data_page->twofactor == 0){ ?>
                                                <option value="0" selected>Turn Off</option>
                                                <option value="1">Turn On</option>
                                            <?php }else{ ?>
                                                <option value="0">Turn Off</option>
                                                <option value="1"selected>Turn On</option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
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
            </div>
        </section>
</div>