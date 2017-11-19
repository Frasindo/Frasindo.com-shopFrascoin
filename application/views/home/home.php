<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
        <section class="content">
          <div class="row">
            <a style="color: black;" target="_blank" href="<?= base_url("page/history/btc") ?>">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">Total Invested</span>
                          <span class="info-box-number"><?= $data["totalInvest"] ?> BTC</span>
                          <span class="info-box-text center">More Info</span>
                      </div>

                      <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
              </div>
            </a>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                      <div class="info-box-content">
                           <span class="info-box-text">Total Participants</span>
                          <span class="info-box-number"><?= $data["tp"] ?></span>
                      </div>
                  </div>
              </div>
              <div class="clearfix visible-sm-block"></div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-green"><i class="fa fa-shopping-bag"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">Bonus Stage</span>
                          <span class="info-box-number" id="bonusStage">0%</span>
                      </div>
                  </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">Time Remaining</span>
                          <span class="info-box-number" id="countdown">00:00:00</span>
                      </div>
                      <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
              </div>
              <!-- /.col -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                    <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage"><i id="dollar_class" class="fa fa-minus"></i></span>
                                        <h5 class="description-header" id="dollar_value">0</h5>
                                        <span class="description-text">BTC/USD</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage"><i id="idr_class" class="fa fa-minus"></i></span>
                                        <h5 class="description-header" id="idr_value">0</h5>
                                        <span class="description-text">BTC/IDR</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage"><i id="frs_class" class="fa fa-minus"></i></span>
                                        <h5 class="description-header" id="frs_value">0</h5>
                                        <span class="description-text"> FRAS CROWDSALE (BTC)</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                    </div>
              </div>
            </div>
         </div>
         <div class="row">
           <div class="col-md-4">
             <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">My Fras (Monthly)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="m_myfras" style="height: 250px; width: 100%;" width="auto" height="250"></canvas>
                  </div>
                </div>
              </div>
           </div>
           <div class="col-md-4">
              <div class="box box-info">
                 <div class="box-header with-border">
                   <h3 class="box-title">My Car (Monthly)</h3>
                   <div class="box-tools pull-right">
                     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>
                     <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                   </div>
                 </div>
                 <div class="box-body">
                   <div class="chart">
                     <canvas id="m_car" style="height: 250px; width: 100%;" width="auto" height="250"></canvas>
                   </div>
                 </div>
               </div>
           </div>
           <div class="col-md-4">
             <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">My Dividen (Monthly)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="m_dividend" style="height: 250px; width: 100%;" width="auto" height="250"></canvas>
                  </div>
                </div>
              </div>
           </div>
         </div>
         <div class="row">
           <div class="col-md-4" id="map">
               <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Live Visitor</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                   <script type="text/javascript" src="//rf.revolvermaps.com/0/0/8.js?i=5n32wiqohlj&amp;m=6&amp;c=ff0000&amp;cr1=ffffff&amp;f=arial&amp;l=33&amp;bv=100" async="async"></script>
               </div>
              </div>
           </div>
           <div class="col-md-8">
              <div class="chating">
              </div>
           </div>
         </div>
       </section>
     </div>
