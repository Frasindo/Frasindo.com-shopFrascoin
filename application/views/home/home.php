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
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#dash" data-toggle="tab">Dashboard</a></li>
                                            <li><a href="#myaccount" class = "myaccount" data-toggle="tab">Fund History</a></li>
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
                                </div>

                            </div>
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
        </section>
    </div>
