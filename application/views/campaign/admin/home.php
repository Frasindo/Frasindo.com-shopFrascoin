<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-ban"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Unverify Campaign</span>
                            <span class="info-box-number"><?= $unverifed ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Participants</span>
                            <span class="info-box-number"><?= $totalPartisipan ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="clearfix visible-sm-block"></div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Verify Campaign</span>
                            <span class="info-box-number"><?= $verifed ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Time Remaining</span>
                            <span class="info-box-number" id="countdown">00:00:00</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Twitter Campaign</h3>
                  </div>
                  <div class="box-body">
                    <ul class="products-list product-list-in-box">
                      <?php foreach ($twitter->result() as $key => $value): ?>
                      <li class="item">
                        <div class="product-img">
                          <img src="<?= $this->campaign_model->getAvatar($value->users_id) ?>" class="img-responsive">
                        </div>
                        <div class="product-info">
                          <a href="javascript:void(0)" class="product-title"><?= $value->username ?>
                            <span class="label label-primary pull-right"><?= $value->date_created ?></span></a>
                          <span class="product-description">
                            <span class="label label-info"><i class="fa fa-twitter"></i></span>
                            <span class="label label-<?= ($value->id_tweet != null)?($value->status_code == 1)?"success":"warning":"danger" ?>"><i class="fa fa-<?= ($value->id_tweet != null)?($value->status_code == 1)?"check":"hourglass-half":"ban" ?>"></i></span>
                          </span>
                        </div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Vlog Campaign</h3>
                  </div>
                  <div class="box-body">
                    <ul class="products-list product-list-in-box">
                      <?php foreach ($twitter->result() as $key => $value): ?>
                      <li class="item">
                        <div class="product-img">
                          <img src="<?= $this->campaign_model->getAvatar($value->users_id) ?>" class="img-responsive">
                        </div>
                        <div class="product-info">
                          <a href="javascript:void(0)" class="product-title"><?= $value->username ?>
                            <span class="label label-primary pull-right"><?= $value->date_created ?></span></a>
                          <span class="product-description">
                            <span class="label label-danger"><i class="fa fa-youtube"></i></span>
                            <span class="label label-<?= ($value->status_code != 0)?"success":"danger" ?>"><i class="fa fa-<?= ($value->status_code != 0)?"check":"ban" ?>"></i></span>
                          </span>
                        </div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Blog Campaign</h3>
                  </div>
                  <div class="box-body">
                    <ul class="products-list product-list-in-box">
                      <?php foreach ($blog->result() as $key => $value): ?>
                      <li class="item">
                        <div class="product-img">
                          <img src="<?= $this->campaign_model->getAvatar($value->users_id) ?>" class="img-responsive">
                        </div>
                        <div class="product-info">
                          <a href="javascript:void(0)" class="product-title"><?= $value->username ?>
                            <span class="label label-primary pull-right"><?= $value->created ?></span></a>
                          <span class="product-description">
                            <span class="label label-danger"><i class="fa fa-rss"></i></span>
                            <span class="label label-<?= ($value->status != 0)?"success":"danger" ?>"><i class="fa fa-<?= ($value->status != 0)?"check":"ban" ?>"></i></span>
                          </span>
                        </div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Signature Campaign</h3>
                  </div>
                  <div class="box-body">
                    <ul class="products-list product-list-in-box">
                      <?php foreach ($sign->result() as $key => $value): ?>
                      <li class="item">
                        <div class="product-img">
                          <img src="<?= $this->campaign_model->getAvatar($value->users_id) ?>" class="img-responsive">
                        </div>
                        <div class="product-info">
                          <a href="javascript:void(0)" class="product-title"><?= $value->username ?>
                            <span class="label label-primary pull-right"><?= $value->created ?></span></a>
                          <span class="product-description">
                            <span class="label label-danger"><i class="fa fa-comments"></i></span>
                            <span class="label label-<?= ($value->status != 0)?"success":"danger" ?>"><i class="fa fa-<?= ($value->status != 0)?"check":"ban" ?>"></i></span>
                          </span>
                        </div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Translate Campaign</h3>
                  </div>
                  <div class="box-body">
                    <ul class="products-list product-list-in-box">
                      <?php foreach ($trans->result() as $key => $value): ?>
                      <li class="item">
                        <div class="product-img">
                          <img src="<?= $this->campaign_model->getAvatar($value->users_id) ?>" class="img-responsive">
                        </div>
                        <div class="product-info">
                          <a href="javascript:void(0)" class="product-title"><?= $value->username ?>
                            <span class="label label-primary pull-right"><?= $value->created ?></span></a>
                          <span class="product-description">
                            <span class="label label-danger"><i class="fa fa-language"></i></span>
                            <span class="label label-<?= ($value->status != 0)?"success":"danger" ?>"><i class="fa fa-<?= ($value->status != 0)?"check":"ban" ?>"></i></span>
                          </span>
                        </div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Completed Campaign</h3>
                  </div>
                  <div class="box-body">
                    <ul class="products-list product-list-in-box">
                      <?php foreach ($latestComplete->result() as $key => $value): ?>
                      <li class="item">
                        <div class="product-img">
                          <img src="<?= $this->campaign_model->getAvatar($value->users_id) ?>" class="img-responsive">
                        </div>
                        <div class="product-info">
                          <a href="javascript:void(0)" class="product-title"><?= $value->username ?>
                            <span class="label label-primary pull-right"><?= $value->date ?></span></a>
                          <span class="product-description">
                            <?= ($value->twitter == "Completed")?'<span class="label label-success">Twitter Completed</span>':'<span class="label label-danger">Twitter Failed</span>' ?>
                            <?= ($value->youtube == "Completed")?'<span class="label label-success">Vlog Completed</span>':'<span class="label label-danger">Vlog Failed</span>' ?><br>
                            <?= ($value->sign == "Completed")?'<span class="label label-success">Signature Completed</span>':'<span class="label label-danger">Signature Failed</span>' ?>
                            <?= ($value->blog == "Completed")?'<span class="label label-success">Blog Completed</span>':'<span class="label label-danger">Blog Failed</span>' ?><br>
                            <?= ($value->trans == "Completed")?'<span class="label label-success">Translate Completed</span>':'<span class="label label-danger">Translate Failed</span>' ?>
                          </span>
                        </div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <script>
            $(function() {
                var target_date = new Date("<?= $targetDate ?>").getTime();
                var cu_date = new Date("<?= date("Y-m-d H:i:s") ?>").getTime();
                if(target_date <= cu_date)
                {
                  var ht = document.getElementById('countdown');
                  ht.innerHTML = "END TIMER";
                }else{
                  var days, hours, minutes, seconds;
                  var countdown = document.getElementById('countdown');
                  var interval = setInterval(function () {
                    var current_date = new Date().getTime();
                    var seconds_left = (target_date - current_date) / 1000;
                    days = parseInt(seconds_left / 86400);
                    seconds_left = seconds_left % 86400;
                    hours = parseInt(seconds_left / 3600);
                    seconds_left = seconds_left % 3600;
                    minutes = parseInt(seconds_left / 60);
                    seconds = parseInt(seconds_left % 60);
                    countdown.innerHTML = days + ':' + hours + ':'
                    + minutes + ':' + seconds;
                    }, 1000);
                }
              });
            </script>
