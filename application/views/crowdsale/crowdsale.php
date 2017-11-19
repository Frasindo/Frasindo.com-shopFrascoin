<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
              <a style="color: black;" target="_blank" href="<?= base_url("page/history/btc") ?>">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-btc"></i></span>
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
                <a style="color: black;" target="_blank" href="<?= base_url("page/history/btc") ?>">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Participants</span>
                            <span class="info-box-number"><?= $data["tp"] ?></span>
                            <span class="info-box-text center">More Info</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                </a>
                <div class="clearfix visible-sm-block"></div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-shopping-bag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Bonus Stage</span>
                            <span class="info-box-number" id="bonusStage">0%</span>
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
            <div class="col-md-8">
                  <div class="box " >
                        <div class="box-footer ">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage"><i id="dollar_class" class="fa fa-minus"></i></span>
                                            <h5 class="description-header" id="dollar_value">0</h5>
                                            <span class="description-text">BTC/USD</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage"><i id="idr_class" class="fa fa-minus"></i></span>
                                            <h5 class="description-header" id="idr_value">0</h5>
                                            <span class="description-text">BTC/IDR</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="description-block">
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
            <div class="col-md-4">
              <div class="info-box" style="background-color:#fff;">
                  <span class="info-box-icon" style="background-color:#99265A;"><img src="https://www.frasindo.com/GRAFIK%20SIMPAN/Coin%20TAXI%20Design%20-%20FRAS.png" class="img-responsive"></span>
                  <div class="info-box-content">
                      <span class="info-box-text">Fras Remaining </span>
                      <span class="info-box-number" id="remainFras">0 Fras</span>
                  </div>
            </div>
            </div>
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#dash" data-toggle="tab">My Account</a></li>
                        <li><a href="#myaccount" class = "myaccount" data-toggle="tab">Purchase History</a></li>
                       <!-- <li><a href="#allacc" class = "allacc" data-toggle="tab">All Fund History</a></li> -->
                        <li><a href="#wp" data-toggle="tab">Instruction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dash">
                            <div class="row">
                            <div class="col-md-6">
                                <h3><li title=" This ARDOR Account will be used to send monthly dividend, you can change this Account Address at the (( Account Setting )), set the Account Address you choose to (( Primary ))" class="fa fa-info-circle"></li> Current ARDOR Account</h3>
                                <h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?= $data["nxt_address"] ?></h4>
                                <h3><li title="Your Shares & Voting Power are accumulated from all Accounts Address that are listed at the (( Account Setting )) section." class="fa fa-info-circle"></li> My Shares</h3>
                                <h4 id="vot_pow">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?= $data["votingPower"] ?>% Voting power</h4>
                                <h3><li title="This is the accumulation of all your FRAS COINS from all the accounts that are listed at the (( Account Setting )) section." class="fa fa-info-circle"></li> All Purchased FRAS Coin (+ Bonus)</h3>
                                <h4 title="FRAS coin, will be sent to your IGNIS account, max.2 weeks after the end of crowdsale." id="fras">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?= $data["myFras"] ?></h4>
                            </div>
                            <div class="col-md-6">
                              <h3>FRAS Crowdsale Converter</h3>
                              <div class="row">
                                  <div class="col-md-3">
                                    <label>USD</label>
                                    <input id="cUSD" type="text" class="form-control" placeholder="">
                                  </div>
                                  <div class="col-md-3">
                                    <label>BTC</label>
                                    <input id="cBTC"   type="text" class="form-control" placeholder="">
                                  </div>
                                  <div class="col-md-3">
                                    <label>FRAS</label>
                                    <input id="cFRAS"  type="text" class="form-control" placeholder="">
                                  </div>
                              </div>
                              <script>
                              $(function() {
                                  $( "#cUSD" ).change(function() {
                                    var param = $("#cUSD").val();
                                    if($.isNumeric(param))
                                    {
                                      $.get(base_url + "rest/converter/"+param, function(data) {
                                          $("#cFRAS").val(data.fras);
                                          $("#cBTC").val(data.usdbtc);
                                      });
                                    }else{
                                      alert("Please Insert Valid Numbers");
                                    }
                                  });
                                  $( "#cFRAS" ).change(function() {
                                    var param = $("#cFRAS").val();
                                    if($.isNumeric(param))
                                    {
                                      $.get(base_url + "rest/converter/"+param+"/fras", function(data) {
                                          $("#cBTC").val(data.frasbtc);
                                          $("#cUSD").val(data.usdfras);
                                      });
                                    }else{
                                      alert("Please Insert Valid Numbers");
                                    }
                                  });
                                  $( "#cBTC" ).change(function() {
                                    var param = $("#cBTC").val();
                                    if($.isNumeric(param))
                                    {
                                      $.get(base_url + "rest/converter/"+param+"/btc", function(data) {
                                          $("#cFRAS").val(data.fras);
                                          $("#cUSD").val(data.btcusd);
                                      });
                                    }else{
                                      alert("Please Insert Valid Numbers");
                                    }
                                  });
                              });
                              </script>
                              <p>Easy calculation, on how much fras you will get</p>
                              <p>(this calculation is not include bonus)</p>
                                <figure class="figure" style="border-style: solid; border-spacing: 5px;">
                                    <div class="row">
                                      <div class="col-xs-3"><img width="100%" height="auto" src="data:image/png;base64,<?= $data["qr_code"] ?>" class="figure-img img-fluid rounded" alt="<?= $data["btc_address"] ?>"></div>
                                      <div class="col-xs-8">
                                        <center>
                                            <h3>Your BTC Crowdsale Address : </h3>
                                            <p style=" word-wrap: break-word"  title="To make purchase, please send your btc only to this address.
You can see your payment status at Purchase History."><?= $data["btc_address"] ?></p>
                                      </center>
                                        <figcaption class="figure-caption text-center"><a href="" class="btn btn-info">Copy Address</a></figcaption></div>

                                    </div>
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
                            <p>Frascoin requires at least three confirmations on the bitcoin blockchain before your transaction is accepted in this Account tab. For this reason, it may take time to process, depending on resources available on the bitcoin blockchain, or the fee you pay for sending this transaction. If the fee is to low, the transaction might be rejected.</p>
                            <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Contribution (BTC)</th>
                                        <th>USD</th>
                                        <th>Fras (Acquired)</th>
                                        <th>Bonus Fras (Acquired)</th>
                                        <th>Transaction</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="trx">
                                    <tr>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th id="btctotal">000000 BTC</th>
                                        <th></th>
                                        <th id="frasC">000000 FRAS</th>
                                        <th id="frasBonus">000000 FRAS</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Total FRAS + Bonus</th>
                                        <th></th>
                                        <th></th>
                                        <th id="totalFras" colspan="2">0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="allacc">
                            <p>Frascoin requires at least three confirmations on the bitcoin blockchain before your transaction is visible in this Account tab. For this reason, it may take time to process your transaction, depending on resources available on the bitcoin blockchain</p>
                            <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NXT Address</th>
                                        <th>Contribution (BTC)</th>
                                        <th>Type</th>
                                        <th>Timestamp</th>
                                        <th>Transaction</th>
                                    </tr>
                                </thead>
                                <tbody id="trxAll">
                                    <tr>
                                        <td>0</td>
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
                                        <th colspan="2" id="btctotalAll">000000 BTC</th>
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
        </section>
         </div>
