<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Earning</span>
                            <span class="info-box-number"><?= $earning ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Completed Campaign</span>
                            <span class="info-box-number"><?= $totalComplete ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="clearfix visible-sm-block"></div>
                <div class="col-md-4 col-sm-6 col-xs-12">
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
              <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Campaign Status</h3>
                </div>
                <div class="box-body">
                  <div class="col-md-12">
                    <table class="table">
                    <thead>
                      <th>#</th>
                      <th>Created</th>
                      <th>Twitter</th>
                      <th>Translate</th>
                      <th>Vlog</th>
                      <th>Blog</th>
                      <th>Signature</th>
                    </thead>
                    <tbody>
                      <?php $no= 1; foreach ($campaignStatus as $key => $value): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $value["date"] ?></td>
                        <td><?= ($value["data"]["twitter"] != 0)?$value["data"]["twitter"]:"<span class='label label-danger'>Failed</span>" ?></td>
                        <td><?= ($value["data"]["trans"] != 0)?$value["data"]["trans"]:"<span class='label label-danger'>Failed</span>" ?></td>
                        <td><?= ($value["data"]["yt"] != 0)?$value["data"]["yt"]:"<span class='label label-danger'>Failed</span>" ?></td>

                        <td><?= ($value["data"]["blog"] != 0)?$value["data"]["blog"]:"<span class='label label-danger'>Failed</span>" ?></td>
                        <td><?= ($value["data"]["sign"] != 0)?$value["data"]["sign"]:"<span class='label label-danger'>Failed</span>" ?></td>
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
