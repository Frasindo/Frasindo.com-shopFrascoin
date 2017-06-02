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
                            <span class="info-box-number">441.696033</span>
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
                            <span class="info-box-number">619</span>
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
                                            <li><a href="#myaccount" data-toggle="tab">My Account</a></li>
                                            <li><a href="#whitepapper" data-toggle="tab">Whitepapper</a></li>
                                            <li><a href="#instructions" data-toggle="tab">Instructions</a></li>
                                            <li><a href="#escrow" data-toggle="tab">Escrow Details</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="dash">
                                                <div class="row">
                                                <div class="col-md-6">
                                                    <h3>Your NXT Account</h3>
                                                    <h4><?= $data["nxt_address"] ?></h4>
                                                    <form action="" method="post">
                                                    <p><button type="submit" class="btn btn-info" name="changeNXT">Change</button></p>
                                                    </form>
                                                    <h3>Your Share</h3>
                                                    <h4 id="vot_pow">0.000% Voting power</h4>
                                                    <h3>Frascoin</h3>
                                                    <h4 id="fras">0.000</h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>Your ICO Address</h3>
                                                    <figure class="figure">
                                                        <center>
                                                            <img src="data:image/png;base64,<?= $data["qr_code"] ?>" class="figure-img img-fluid rounded" alt="A generic square placeholder image with rounded corners in a figure."></center>
                                                        <figcaption class="figure-caption text-center">
                                                            <h4><?= $data["nxt_address"] ?></h4></figcaption>
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
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Dumy</td>
                                                            <td>Lol</td>
                                                            <td>Blah</td>
                                                            <td>10%</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total BTC</th>
                                                            <th>000000</th>
                                                            <th>000000</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="whitepapper">
                                                <p>Wah</p>
                                            </div>
                                            <div class="tab-pane" id="instructions">
                                                
                                                <p _ngcontent-c9="" class="bold">
                                                    Here are step by step instructions of how to contribute funds to the Adel ICO, as well as navigation throughout the various ICO module tabs:
                                                </p>

                                                <p _ngcontent-c9="">1. <span _ngcontent-c9="">The first step is to click "ICO Contribution" on the Adel homepage at <a _ngcontent-c9="" href="https://adelphoi.io">https://adelphoi.io</a>, then click "Create a new account" in the bottom right corner. Enter your details and click “I accept the Adel ICO Terms &amp; Conditions”. Click “I hereby declare that the above information is true and correct”, and click that you are not a robot (i.e. reCaptcha API), then “Register”. Then go to your email application and wait for a message from Adel to validate your email address. Once you have clicked the provided link in the email message, you will be redirected back to the <a _ngcontent-c9="" href="https://ico.adelphoi.io">https://ico.adelphoi.io</a> website so you can login to your new Adel ICO account. </span>
                                                </p>
                                                <p _ngcontent-c9="">2. <span _ngcontent-c9="">Your next step is to set up a new Nxt account, or enter your existing Nxt address if you already have one. (You need a Nxt address since Adel uses the Nxt blockchain). <b _ngcontent-c9="" style="color: red">Make sure you save secret in a safe location</b> because these details will not be displayed again. </span>
                                                </p>
                                                <p _ngcontent-c9="">3. <span _ngcontent-c9="">Then you will be directed to the ICO Dashboard tab. Here you will see your Nxt address on the left, and your new ICO address on the right. This ICO address is your unique BTC address for all of your ICO contributions. A Qr (Quick response) code is also provided so that you can easily transfer your ICO address to your mobile phone. You need to use this ICO address to send BTC from your bitcoin wallet (If you don’t already have one, then you can set up a new account with Kraken, Coinbase, Changelly, Shapeshift, or Cubits. We have provided walkthrough documents on our home page to help you with this process, and convert your fiat currency or other cryptocurrencies to BTC). </span>
                                                </p>
                                                <p _ngcontent-c9="">4. <span _ngcontent-c9="">In the Dashboard tab, you can contribute funds to the ICO using the Shapeshift or Changelly APIs provided. The Dashboard tab also displays your overall BTC balance for all your contributions throughout the ICO. You can also see your voting power and overall ADL balance. Note that your voting power and ADL balance will decrease over time throughout the ICO. This is normal because other contributing funds further distribute the ADL coins and voting weight amongst new participants. You can increase your voting power and ADL balance by submitting additional BTC. </span></p>
                                                <p _ngcontent-c9="">5. <span _ngcontent-c9="">In the Account tab, you can view the history of all your BTC transactions, voting bonuses, and an equivalent amount in Euros. Your voting bonus increases your voting power, as well as the number of ADL coins you will receive at the end of the ICO.</span>
                                                </p>
                                                <p _ngcontent-c9="">6. <span _ngcontent-c9="">The Identification tab displays your personal details. As your balance passes certain thresholds, then additional credentials will be needed to meet Adel’s Anti-Money Laundering policy (this is a legal requirement for the Isle of Man regulators). If you pass a contribution threshold of 1 BTC, then your phone number, birthday, and a scanned copy of your passport or ID will be required in order to pass Anti-Money Laundering procedures. If your contribution passes 20 BTC, then your address of residence and a scanned copy of your utility bill (displaying your name and address of residence) will be required. You can edit your details at any time throughout the ICO (except for your email address since each ICO account requires a unique email address). Once you have edited your details, then check the verification and authorization boxes and save your details. Scanned documents, such as your government-issued passport / ID and utility bills, will be verified by Adel. Your Identification status will remain “Pending” while your documents are being validated by AML Officers. If there is a discrepancy in the details you submitted, then you will receive a message from Adel to update your credentials until they are accepted by the AML Officer. If your credentials are not corrected by the end of the ICO on May 31st, 2017, then your funds will be returned to you if you have provided a BTC return address under the settings <i _ngcontent-c9="" class="fa fa-cog iconbutton orange" routerlink="settings" tabindex="0"></i>
 menu. </span>
                                                </p>
                                            </div>
                                            <div class="tab-pane" id="escrow">
                                                <p>escrow details</p>
                                            </div>
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
