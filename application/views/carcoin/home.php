<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
tbody {
    overflow-y: auto;    /* Trigger vertical scroll    */
    overflow-x: hidden;  /* Hide the horizontal scroll */
}
</style>
<script>
    var base_url = "<?= base_url() ?>";
</script>

    <div class="content-wrapper">
        <section class="content">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box" style="background-color:#fff;">
                  <span class="info-box-icon" style="background-color:#99265A;"><img src="https://www.frasindo.com/GRAFIK%20SIMPAN/Coin%20TAXI%20Design%20-%20CAR.png" class="img-responsive"></span>
                  <div class="info-box-content">
                      <span class="info-box-text">CAR COIN (TOTAL)</span>
                      <span class="info-box-number" ><?= $totalCar ?></span>
                  </div>
              </div>
            </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">TIME REMAINING</span>
                          <span class="info-box-number" id="countdown"></span>
                      </div>
                  </div>
              </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-gift"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">NEXT CAR Bonus (TOTAL)</span>
                        <span class="info-box-number"><?= $totalNextCar ?></span>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">MY CAR COIN</h3>
                        </div>
                        <script type="text/javascript" src="<?= base_url("assets/plugins/qr/") ?>instascan.min.js"></script>
                        <div class="box-body">
                            <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <center><button type="button" class="btn btn-danger send"><li class="fa fa-send"></li> SEND CAR COIN</button> <button type="button" class="btn bg-yellow history"><li class="fa fa-history"></li> CARCOIN HISTORY</button></center>
                                </div>
                                <div class="col-md-8">
                                    <center><button type="button" class="btn bg-purple createvoucher"><li class="fa fa-plus"></li> CREATE VOUCHER</button> <button type="button" class="btn btn-success redeem"><li class="fa fa-arrow-circle-down"></li>   REDEEM VOUCHER</button></center>
                                </div>
                                </div>
                              </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                        <th>Account Address</th>
                                        <th>Account Type</th>
                                        <th>FRAS</th>
                                        <th>Your CAR</th>
                                        <th>Next CAR</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </thead>
                                    <?php $pa = $this->acc->checksaldo(trim($this->session->nxt_address," "),"asemcoin"); ?>
                                    <tbody>
                                      <tr>
                                        <td><?= $this->session->nxt_address ?></td>
                                        <td>Primary</td>
                                        <td><?= $this->str->add_comma((isset($pa->quantityQNT))?$pa->quantityQNT:"",8) ?></td>
                                        <td><?= $this->bill->carBalance($this->session->nxt_address) ?></td>
                                        <td><?= $this->bill->carNextBonus($this->session->nxt_address) ?></td>
                                        <td><?=(isset( $this->db->get_where("user_info",array("nxt_address"=>$this->session->nxt_address))->result()[0]->notes))? $this->db->get_where("user_info",array("nxt_address"=>$this->session->nxt_address))->result()[0]->notes:null ?></td>
                                        <td></td>
                                      </tr>
                                      <?php foreach($this->db->get_where("setAcc",array("id_user"=>$data_page->id_users))->result() as $dataList){ ?>
                                      <tr>
                                        <td><?= $dataList->nxt_address ?></td>
                                        <td>Secondary</td>
                                        <td><?= $this->str->add_comma((isset($this->acc->checksaldo(trim($dataList->nxt_address," "),"asemcoin")->quantityQNT))?$this->acc->checksaldo(trim($dataList->nxt_address," "),"asemcoin")->quantityQNT:"",8) ?></td>
                                        <td><?= $this->bill->carBalance($dataList->nxt_address) ?></td>
                                        <td><?= $this->bill->carNextBonus($dataList->nxt_address) ?></td>
                                        <td><?= $dataList->notes ?></td>
                                        <td><button type="button" data="<?= $dataList->nxt_address ?>" class="btn btn-primary transfer"><b>Transfer CAR COIN</b></br> to Primary Account</button></td>
                                      </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
    function printit() {
      var printContents = $(".voucherPict").attr("src");
      var popupWin = window.open();
      popupWin.document.open()
      popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()"><center><img width="570px" height="auto" src="' + printContents + '"></img></center></html>');
      popupWin.document.close();
    }
    </script>
    <script>
    $(function() {
      $(".history").click(function() {
        var data = $(this);
        var dialog = bootbox.dialog({
            title: 'CARCOIN HISTORY',
            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Loading Your History . . .</p></center>'
        });
        dialog.init(function(){
            $.get("<?= base_url("rest/carcoinHistory") ?>", function(data) {
                var html = "";
                if(data.status == 1)
                {
                  var u ;
                  for(u = 0; u <= data.data.length-1; u++)
                  {
                    html += "<tr>";
                      html += "<td>"+(u+1)+"</td>";
                      html += "<td>"+data.data[u].trx_name+"</td>";
                      html += "<td>"+data.data[u].carcoin+"</td>";
                      html += "<td>"+data.data[u].date+"</td>";
                    html += "</tr>";
                  }
                }
                setTimeout(function(){
                  dialog.find('.bootbox-body').html('<div class="row"><div class="col-md-12"><table class="table" id="dynatable"><thead><tr><th>#</th><th>TRANSACTION NAME</th><th>CARCOIN</th><th>DATE</th></tr></thead><tbody>'+html+'</tbody></table></div></div>');
                }, 1000);
            });
        });
      });
      $(".transfer").click(function() {
          var data = $(this);
          var dialog = bootbox.dialog({
              title: 'Please Wait . . .',
              message: '<center><p><i class="fa fa-spin fa-spinner"></i> Transfering  . . . .</p></center>'
          });
          dialog.init(function(){
              setTimeout(function(){
                $.post("<?= base_url("rest/transferAll") ?>",{addr:data.attr("data")}, function(data) {
                      if(data.status == 1)
                      {
                        dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+data.msg+'</center></div>');
                      }else{
                        dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+data.msg+'</center></div>');
                      }
                  });
              }, 1000);
          });
      });
      $(".redeem").click(function() {
        $.get("<?= base_url("rest/myAddress") ?>",function(data) {
          bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control code" placeholder="Place Your Voucher Code" type="text"></div></div><div class="col-md-12"><div class="form-group"><label>To Address :</label><select class="form-control fromAddr">'+data.data+'</select></div></div><div class="col-md-12"><center><video id="previewRedeem" width="300px" height="auto"></video></center></div></div>', function(result) {
            if(result)
            {
              var code = $(".code").val();
              var toAddr = $(".fromAddr").val();
              var dialog = bootbox.dialog({
                  title: 'Please Wait . . .',
                  message: '<center><p><i class="fa fa-spin fa-spinner"></i> Processing Voucher  . . . .</p></center>'
              });
              dialog.init(function(){
                  setTimeout(function(){
                    $.post("<?= base_url("rest/reddem") ?>",{code:code,to:toAddr}, function(data) {
                          if(data.status == 1)
                          {
                            dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+data.msg+'</center></div>');
                          }else{
                            dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+data.msg+'</center></div>');
                          }
                      });
                  }, 1000);
              });
            }
            });
            redeem();
        });
      });
      function previewSendcar(){
        let scanner = new Instascan.Scanner({ video: document.getElementById('previewSendCar') });
        scanner.addListener('scan', function (content) {
          $(".target").val(content);
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
      };
      function redeem(){
        let scanner = new Instascan.Scanner({ video: document.getElementById('previewRedeem') });
        scanner.addListener('scan', function (content) {
          $(".code").val(content);
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
      };
      $(".voucherPict").click(function() {
         var link = document.createElement("voucherPict");
         link.setAttribute("href", base64);
         link.setAttribute("download", fileName);
         link.click();
      });
      $(".createvoucher").click(function() {
        $.get("<?= base_url("rest/myAddress") ?>",function(data) {
        bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control amount" placeholder="Place Your Voucher Amount" type="number"></div></div><div class="col-md-12"><div class="form-group"><label>From Address :</label><select class="form-control fromAddr">'+data.data+'</select></div></div></div>', function(result) {
          if(result)
          {
            var amount = $(".amount").val();
            var fromAddr = $(".fromAddr").val();
            var dialog = bootbox.dialog({
                title: 'Please Wait . . .',
                message: '<center><p><i class="fa fa-spin fa-spinner"></i> Creating Voucher  . . . .</p></center>'
            });
            dialog.init(function(){
                setTimeout(function(){
                  $.post("<?= base_url("rest/voucher") ?>",{sender:fromAddr,total:amount}, function(data) {
                        if(data.status == 1)
                        {
                          dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+data.msg+'</center></div><div><center><img width="450px" height="auto" class="img-responsive voucherPict" src="data:image/png;base64,'+data.picture+'" ></img><button style="padding:5px 5px 5px 5px" onclick="printit()" class="btn btn-info">PRINT Voucher</button></center></div>');
                        }else{
                          dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+data.msg+'</center></div>');
                        }
                    });
                }, 1000);
            });
          }
          });
        });
      });
      $(".send").click(function() {
        $.get("<?= base_url("rest/myAddress") ?>",function(data) {
        bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><label>From Address :</label><select class="form-control fromAddr">'+data.data+'</select></div></div><div class="col-md-12"><div class="form-group"><label>Send to Recipient :</label><input class="form-control target" placeholder="Recipient Address" type="text"></div></div><div class="col-md-12"><center><label>QR-Scan Recipient ARDOR Account Address :</label><video id="previewSendCar" width="300px" height="auto"></video></center></div><div class="col-md-12"><div class="form-group"><label>CAR COIN Amount :</label><input class="form-control amount" placeholder="Place Your Send Amount" type="number"></div></div></div>', function(result) {
          if(result)
          {
            var amount = $(".amount").val();
            var target = $(".target").val();
            var fromAddr = $(".fromAddr").val();
            var dialog = bootbox.dialog({
                title: 'Please Wait . . .',
                message: '<center><p><i class="fa fa-spin fa-spinner"></i> Transfering  . . . .</p></center>'
            });
            dialog.init(function(){
                setTimeout(function(){
                  $.post("<?= base_url("rest/send") ?>",{sender:fromAddr,target:target,total:amount}, function(data) {
                        if(data.status == 1)
                        {
                          dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+data.msg+'</center></div>');
                        }else{
                          dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+data.msg+'</center></div>');
                        }
                    });
                }, 1000);
            });
          }
          });
          previewSendcar();
        });
      });
    });
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
            countdown.innerHTML = hours + ':'
            + minutes + ':' + seconds;
            }, 1000);
        }
      });
    </script>
