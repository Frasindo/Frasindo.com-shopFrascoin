<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Invested</span>
                            <span class="info-box-number"><?= $data["totalInvest"] ?></span>
                            <span class="info-box-text">BTC</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                             <span class="info-box-text">Total Participants</span>
                            <span class="info-box-number"><?= $data["tp"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-shopping-bag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Bonus Stage</span>
                            <span class="info-box-number">760</span>
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
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
            <div class="col-md-12">
                  <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Dashboard</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <canvas id="frascoinMarket" width="auto" height="100"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="myIncome" width="auto" height="100"></canvas>
                            </div>
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
                                        <span class="description-text">FRASCOIN</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Member</h3>
                </div>
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="product-img">
                        <img src="https://adminlte.io/themes/AdminLTE/dist/img/default-50x50.gif" alt="Avatar">
                      </div>
                      <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Member
                          <span class="label label-success pull-right fa fa-user-plus"></span></a>
                          <span class="product-description">Bergabung</span>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>    
            </div>
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#dash" data-toggle="tab">My Account</a></li>
                        <li><a href="#myaccount" class = "myaccount" data-toggle="tab">Fund History</a></li>
                        <li><a href="#wp" data-toggle="tab">Whitepapper</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dash">
                            <div class="row">
                            <div class="col-md-6">
                                <h3>Your NXT Account</h3>
                                <h4><?= $data["nxt_address"] ?></h4>                                                                         
                                <h3>Your Share</h3>
                                <h4 id="vot_pow"><?= $data["votingPower"] ?>% Voting power</h4>
                                <h3>Frascoin</h3>
                                <h4 id="fras"><?= $data["myFras"] ?></h4>
                            </div>
                            <div class="col-md-6">
                                <h3>Your ICO Address</h3>
                                <figure class="figure">
                                    <center>
                                        <img src="data:image/png;base64,<?= $data["qr_code"] ?>" class="figure-img img-fluid rounded" alt="<?= $data["btc_address"] ?>"></center>
                                    <figcaption class="figure-caption text-center">
                                        <h4><?= $data["btc_address"] ?></h4></figcaption>
                                    <figcaption class="figure-caption text-center"><a href="" class="btn btn-info">Copy Address</a></figcaption>
                                </figure>
                                <h3>Fund with</h3>
                                <div class="col-md-4">
                                    <a href="" class="btn btn-info btn-large">BTC</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="" class="btn btn-success btn-large">Shapesift</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="" class="btn btn-danger btn-large">Changelly</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="myaccount">
                            <p>Frascoin requires at least three confirmations on the bitcoin blockchain before your transaction is visible in this Account tab. For this reason, it may take time to process your transaction, depending on resources available on the bitcoin blockchain</p>
                            <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Timestamp</th>
                                        <th>Contribution (BTC)</th>
                                        <th>Voting Bonus</th>
                                        <th>Transaction</th>
                                    </tr>
                                </thead>
                                <tbody id="trx">
                                    <tr>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total BTC</th>
                                        <th colspan="2" id="btctotal">000000 BTC</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                                </div>
                        </div>
                            
                        <div class="tab-pane" id="wp"><p>Contoh White Papper</p></div>
                </div>
            </div>
            </div>
            <div class="col-md-4">
                 <!-- Map box -->
                  <div class="box box-solid bg-light-blue-gradient">
                    <div class="box-header">
                      <!-- tools box -->
                      <div class="pull-right box-tools">
                        <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                                title="Date range">
                          <i class="fa fa-calendar"></i></button>
                        <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                          <i class="fa fa-minus"></i></button>
                      </div>
                      <!-- /. tools -->

                      <i class="fa fa-map-marker"></i>

                      <h3 class="box-title">
                        Visitors
                      </h3>
                    </div>
                    <div class="box-body">
                      <div id="world-map" style="height: 250px; width: 100%;"></div>
                    </div>
                  </div>
        <!-- /.box -->
            </div>
            <div class="col-md-4">
                  <div class="box box-info">
                    <div class="box-header">
                      <i class="fa fa-envelope"></i>
                      <h3 class="box-title">Quick Chat</h3>
                      <div class="pull-right box-tools">
                        <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                          <i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <div class="box-body">
                      <form action="#" method="post">
                        <div class="form-group">
                          <input type="email" class="form-control" name="emailto" placeholder="Massage To :">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control" name="subject" placeholder="Subject">
                        </div>
                        <div>
                          <textarea class="textarea" placeholder="Message"
                                    style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                      </form>
                    </div>
                    <div class="box-footer clearfix">
                      <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                        <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header">
                      <i class="ion ion-clipboard"></i>

                      <h3 class="box-title">To Do List</h3>

                      <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                          <li><a href="#">&laquo;</a></li>
                          <li><a href="#">1</a></li>
                          <li><a href="#">2</a></li>
                          <li><a href="#">3</a></li>
                          <li><a href="#">&raquo;</a></li>
                        </ul>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                      <ul class="todo-list">
                        <li>
                          <!-- drag handle -->
                          <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <!-- checkbox -->
                          <input type="checkbox" value="">
                          <!-- todo text -->
                          <span class="text">Design a nice theme</span>
                          <!-- Emphasis label -->
                          <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                          <!-- General tools such as edit or delete-->
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Make the theme responsive</span>
                          <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Let theme shine like a star</span>
                          <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Let theme shine like a star</span>
                          <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Check your messages and notifications</span>
                          <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Let theme shine like a star</span>
                          <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="box-footer clearfix no-border">
                      <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                    </div>
                  </div>
            </div>
            <div class="col-md-12">
                <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-red">
                        10 Feb. 2014
                    </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-envelope bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                        <h3 class="timeline-header"><a href="#">Support Team</a> ...</h3>

                        <div class="timeline-body">
                            Ini Contoh Timeline nya
                        </div>

                        <div class="timeline-footer">
                            <a class="btn btn-primary btn-xs">...</a>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
              </ul>
            </div>
        </section>
         </div>
