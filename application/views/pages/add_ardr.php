<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Add New Address </h3>
                        </div>
                        <div class="box-body">
                          <?= (isset($alert_m))?$alert_m:null ?>
                          <form class="form-horizontal" action="" method="post">
                              <div style="padding-bottom:5px;" class="col-md-12">
                                  <input  class="form-control addr" type="text" name="nxt_address" placeholder="ARDOR Address"/>
                                  <div style="padding-top:5px;">
                                  <button class="btn btn-info genAcc" type="button">Generate New Address</button>
                                  <button class="btn btn-info " id="scanQR" type="button">Scan QR Code</button>
                                  </div>
                                <div style="padding-top:5px;">
                                  <input  class="form-control tok" type="text" name="token" placeholder="Input Your Token"/>
                                  <label style="font-weight: normal;">Please enter your ARDOR Wallet Address and Click (( <b>Setting -> Generate Tokens <?= htmlentities("</>") ?></b> )),
and enter your (( <b>Passphrase</b> ))+this website (( <b>frasindo.com</b> )).
If you use our (( <b>Generate New Address </b> )) then skip this input box. <a href="https://www.frasindo.com/GRAFIK%20SIMPAN/TUTORIAL%20-%20Add%20New%20Address.jpg" target="_blank" >Click this link --> TUTORIAL</a></label>
                              </div>
                              </div>
                              <br>
                              <div style="padding-bottom:5px;" class="col-md-12">
                                  <textarea class="form-control" type="text" name="notes" placeholder="You can add any TEXT/LABEL, to marking this New Address"/></textarea>
                              </div>
                              <div style="padding-top:5px;"class="col-md-12">
                                  <button type="submit" name="sARDR" class="btn btn-success">Save New Address</button>
                              </div>
                          </form>
                          <div id="results-modals" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">New Address Details</h4>
                                </div>
                                <style>
                                td {
                                    max-width: 100%;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                }
                                </style>
                                <div class="modal-body">
                                  <div class="col-md-12">
                                  <div class="innerBe">

                                  </div>
                                  <center>
                                    <button id="walletPrint" class='btn btn-info'>PRINT Paper Wallet</button>
                                  </center>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>

                            </div>
                          </div>
                          <script type="text/javascript" src="<?= base_url("assets/plugins/qr/") ?>instascan.min.js"></script>
                          <script type="text/javascript">
                          $( "#scanQR" ).click(function() {
                            var resultScanner;
                            bootbox.confirm('<div class="row"><center><label>Scan Your Code </label><br><video id="preview" width="300px" height="auto"></video></center></div><br><p >Scanner Result : <span id="scaner"></span></p></div>', function(result) {
                              if(result)
                              {
                                  $(".addr").val(resultScanner);
                              }
                              });

                              let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                              scanner.addListener('scan', function (content) {
                                $("#scaner").html(content);
                                resultScanner = content;
                              });
                              Instascan.Camera.getCameras().then(function (cameras) {
                                if (cameras.length > 0) {
                                  scanner.start(cameras[1]);
                                } else {
                                  console.error('No cameras found.');
                                }
                              }).catch(function (e) {
                                console.error(e);
                              });
                          });
                          </script>
                          <script>
                            $(function() {
                              $( "#walletPrint" ).click(function() {
                                var printContents = $("#printIt").attr("src");
                                var popupWin = window.open();
                                popupWin.document.open()
                                popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()"><center><img width="570px" height="auto" src="' + printContents + '"></img></center></html>');
                                popupWin.document.close();
                              });
                              $( ".genAcc" ).click(function() {
                                $.get("<?= base_url() ?>rest/createNXT", function(data) {
                                      var insert = $(".innerBe");
                                      var html = "";
                                      html +="<p>Your Address : <b>"+data.data.nxt_address+"</p></b>";
                                      html +="<p style='word-wrap: break-word;'>Your Secret Key : <b>"+data.data.secretKey+"</p></b>";
                                      html += "<p ><center style='color:red;font-size:18px;'>!! WARNING !!</center></p><p>Please store/write your (( <b>Wallet Address</b> )) and (( <b>Passphrase</b> )  on a paper. IF you lose this, you CAN NOT be able to access your Wallet Address anymore</p><center><img id='printIt' width='400' heigth='auto' src='data:image/png;base64,"+data.data.card+"' class='img-responsive '></img></center>";
                                      //html +="<p style='word-wrap: break-word;'><b>Your Token  :</b> "+data.data.token+"</p>";
                                      insert.html("");
                                      insert.append(html);
                                      $( ".addr" ).val(data.data.nxt_address);
                                      $( ".pk" ).val(data.data.public_key);
                                      $( ".tok" ).val(data.data.token);
                                      $("#results-modals").modal({ show: true });
                              });
                              });
                            });
                          </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>
