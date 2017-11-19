<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    var base_url = "<?= base_url() ?>";
</script>

    <div class="content-wrapper">
        <section class="content">
          <div class="row">
            <a style="color: black;" target="_blank" href="<?= base_url("page/history/btc") ?>">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-aqua"><i class="fa fa-btc"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">Total Invested</span>
                          <span class="info-box-number"><?= $data["Tinvest"] ?> BTC</span>
                      </div>

                      <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
              </div>
            </a>
              <!-- /.col -->
              <a style="color: black;" target="_blank" href="<?= base_url("page/history/btc") ?>">
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
            </a>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Invested in cash</span>
                        <span><b>1,081,500,000 IDR</b></span>
                        <span class="info-box-text">(81,931.81 USD)</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box" style="background-color:#fff;">
                    <span class="info-box-icon" style="background-color:#99265A;"><img src="https://www.frasindo.com/GRAFIK%20SIMPAN/Coin%20TAXI%20Design%20-%20FRAS.png" class="img-responsive"></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Fras Remaining </span>
                        <span class="info-box-number" id="remainFras"><?= number_format($data["fixedFras"]) ?> Fras</span>
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sales History of Frasindo</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="table-responsive">
                                <table class="table table-striped" id="my-table">
                                  <thead>
                                   <th>Timestamp</th>
                                   <th>Username</th>
                                   <th>BTC</th>
                                   <th>USD</th>
                                   <th>FRAS</th>
                                   <th>Bonus FRAS</th>
                                   <th>Transaction ID</th>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <th>Total</th>
                                      <th></th>
                                      <th id="btchere">0</th>
                                      <th></th>
                                      <th id="frashere">0</th>
                                      <th id="bonushere">0</th>
                                    </tr>
                                    <tr>
                                      <th>Total FRAS + Bonus</th>
                                      <th></th>
                                      <th ></th>
                                      <th></th>
                                      <th id="frasTotal" colspan="2">0</th>
                                      <th></th>
                                    </tr>

                                  </tfoot>
                                </table>
                            </div>
                            </div>
                            </div>
                        </div>

                        <script>
                        var dat;
                        $.ajax({
                    			url : "<?= base_url("rest/historyBTC") ?>",
                    			type : "get",
                    			async: false,
                    			success : function(data) {
                              $("#btchere").html(data.totalBTC);
                              $("#frashere").html(data.totalFras);
                              $("#bonushere").html(data.totalBonus);
                              $("#frasTotal").html((data.totalBonus+data.totalFras));
                       				dat = data;
                    			}
                        });
                        $('#my-table').dynatable({
                        dataset: {
                          records: dat.records
                        }
                        });
                        </script>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
    window.onload = function() {
      setTimeout(function() {
          $.get(base_url + "rest/historyBTC", function(data) {
                var i = 1;
                var html = "";

                for(var b = 0; b <= data.length-1; b++)
                {
                    html += "<tr>";
                    var listUser = "";
                    var listHash = "";
                    var timestamp = "";
                    var frasData = "";
                    var bonusData = "";
                    var btc_data = "";
                    var btcH = "";
                    var kBTC = "";
                    var coreData = data[b].data;
                    for(var q = 0; q <= coreData.username.length-1;q++)
                    {
                      listUser += "<p>"+coreData.username[q]+"</p>";
                    }
                    for(var q = 0; q <= coreData.hash_list.length-1;q++)
                    {
                      listHash += "<p><a target='_blank' href='https://blockchain.info/tx/" + coreData.hash_list[q] + "'>" + coreData.hash_list[q] + "</a></p>";
                    }
                    for(var q = 0; q <= coreData.timestamp.length-1;q++)
                    {
                      timestamp += "<p>"+coreData.timestamp[q]+"</p>";
                    }
                    for(var q = 0; q <= coreData.fras.length-1;q++)
                    {
                      frasData+= "<p>"+coreData.fras[q]+"</p>";
                    }
                    for(var q = 0; q <= coreData.bonus_log.length-1;q++)
                    {
                      bonusData+= "<p>"+coreData.bonus_log[q]+"</p>";
                    }

                    for(var q = 0; q <= coreData.btc.length-1;q++)
                    {
                      btcH+= "<p>"+coreData.btc[q]+"</p>";
                    }

                    for(var q = 0; q <= coreData.kursBTCUSD.length-1;q++)
                    {
                      kBTC+= "<p>"+coreData.kursBTCUSD[q]+"</p>";
                    }
                    html += "<td>"+i+"</td>";
                    html += "<td>"+timestamp+"</td>";
                    html += "<td>"+listUser+"</td>";
                    html += "<td>"+btcH+"</td>";
                    html += "<td>"+kBTC+"</td>";
                    html += "<td>"+frasData+"</td>";
                    html += "<td>"+bonusData+"</td>";
                    html += "<td>"+listHash+"</td>";
                    i++;
                    html += "</tr>";
                }
                $("#historyBTC").html(html);
          });
        },1000);
    }


    </script>
