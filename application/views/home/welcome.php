<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    var base_url = "<?= base_url() ?>";
</script>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Welcome to <b>Frasindo</b>SHOP </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Set Up Your ARDOR Account</h3>
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#have"  data-toggle="tab">I Have an ARDOR Account</a></li>
                                            <li class="nothave"><a href="#nothave"  data-toggle="tab">I Need a New ARDOR Account</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="have">
                                                <div id="haveit">
                                                    <div class="row">
                                                    <div class="col-lg-4">
                                                        <input class="form-control" id="nxt_acc" placeholder="Please input your  ARDOR Account Address">
                                                        <br>
                                                        <input class="form-control" id="token" placeholder="Please input your  Token">
                                                        <br>
                                                        <a href="https://www.frasindo.com/GRAFIK%20SIMPAN/TUTORIAL%20-%20Add%20New%20Address.jpg" class="btn btn-danger" target="_blank">How to Generate Token ? </a>
                                                        <button style="padding-top:5px;" id="scanQR" class="btn btn-info">Scan QR Code</button>
                                                    </div>
                                                    <div class="col-lg-6" style="padding-top:5px;">
                                                      <video id="preview" width="300px" height="auto"></video>
                                                      <script type="text/javascript" src="<?= base_url("assets/plugins/qr/") ?>instascan.min.js"></script>
                                                      <script type="text/javascript">
                                                      $( "#scanQR" ).click(function() {
                                                        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                                                        scanner.addListener('scan', function (content) {
                                                          $("#nxt_acc").val(content);
                                                        });
                                                        Instascan.Camera.getCameras().then(function (cameras) {
                                                          if (cameras.length > 0) {
                                                            var count = cameras.length;
                                                            if(count > 1)
                                                            {
                                                              scanner.start(cameras[1]);
                                                            }else{
                                                              scanner.start(cameras[0]);
                                                            }
                                                          } else {
                                                            console.error('No cameras found.');
                                                          }
                                                        }).catch(function (e) {
                                                          console.error(e);
                                                        });
                                                      });
                                                      </script>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                        <button class="btn btn-info" type="button" style="margin-top: 20px" id="save_nxt">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="nothave">
                                            <style type="text/css">
                                              @media print
                                              {
                                                * { margin: 0 !important; padding: 0 !important; }
                                                body * { visibility: hidden; }
                                                .printIt {
                                                  visibility:visible;
                                                  position:relative;
                                                  left: 0px;
                                                  top: -200px;
                                                  overflow: hidden;
                                                  width: 1772px;
                                                  height: auto;
                                                }
                                              }
                                              table{
                                                  table-layout: fixed;
                                              }
                                              td{
                                                  word-wrap:break-word;
                                              }
                                            </style>
                                            <script>
                                            function printit() {
                                              var printContents = $(".printIt").attr("src");
                                              var popupWin = window.open();
                                              popupWin.document.open()
                                              popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()"><center><img width="570px" height="auto" src="' + printContents + '"></img></center></html>');
                                              popupWin.document.close();
                                            }
                                            </script>
                                                <div id="new_nxt">
                                                    <p style="font-size: 20px; padding-bottom: 12px">Creating Your Account . . .</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <button id="saveNewNXT" class="btn btn-info">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
