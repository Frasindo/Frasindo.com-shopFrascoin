<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
      <section class="content">
          <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-red"><i class="fa fa-ticket"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">Unanswered Ticket</span>
                          <span class="info-box-number"><?= $tiket ?></span>
                      </div>

                  </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                      <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">TOTAL USER</span>
                          <span class="info-box-number"><?= $totalUser ?></span>
                      </div>
                  </div>
              </div>
              <div class="clearfix visible-sm-block"></div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box" style="background-color:#fff;">
                    <span class="info-box-icon" style="background-color:#99265A;"><img src="https://www.frasindo.com/GRAFIK%20SIMPAN/Coin%20TAXI%20Design%20-%20FRAS.png" class="img-responsive"></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Fras Remaining </span>
                        <span class="info-box-number"><?= $fras ?></span>
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
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">CROWDSALE LIST</h3> <div class="pull-right"><button class="btn btn-success addCrowdsale"><li class="fa fa-plus"></li></button></div>
                    </div>
                    <div class="box-body">
                      <br>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Crowdsale Created</th>
                              <th>Total Rounds</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; foreach ($crowdsaleItem->result() as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->created ?></td>
                                <td><?= $value->round ?></td>
                                <td><button class="btn btn-success detail" data-id="<?= $value->id_crowdsale ?>"><li class="fa fa-search"></li></button> <button class="btn btn-warning edit" data-id="<?= $value->id_crowdsale ?>"><li class="fa fa-edit"></li></button> <button class="btn btn-danger delete" data-id="<?= $value->id_crowdsale ?>"><li class="fa fa-trash"></li></button></td>
                            </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">ADMIN LIST</h3> <div class="pull-right"><button class="btn btn-success addUser"><li class="fa fa-plus"></li></button></div>
                    </div>
                    <div class="box-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no = 1; foreach ($listAdmin->result() as $key => $value) {?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $value->nama ?></td>
                              <td><?= $value->department_name ?></td>
                              <td><button class="btn btn-danger deleteAkun" data-email="<?= $value->email ?>"><li class="fa fa-trash"></li></button></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
          </section>
    </div>
    <script>
     $('.table').DataTable({
        "scrollX": true
    });
    $(function(){
      var timedata;
      $.ajax({
        url : base_url + "rest/getDate",
        type : "get",
        async: false,
        success : function(data) {
            timedata = data;
        }
      });
      var target_date = new Date(timedata.time).getTime();
      var cu_date = new Date(timedata.curdate).getTime();
      getFixed();
      if(target_date <= cu_date)
      {
        var ht = document.getElementById('countdown');
        ht.innerHTML = "END CROWDSALE";
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
          countdown.innerHTML = days +  ':' + hours + ':'+ minutes +" <br> <span class='label label-info'>Market is "+timedata.type+"</span>";

          }, 1000);
      }
      $(".table").on("click",".deleteAkun", function() {
        var e = $(this);
        var email = e.attr("data-email");
        bootbox.confirm('<div class="row"><center><h2>Are You Sure ?</h2></center></div>', function(a) {
          if(a)
          {
            var dialog = bootbox.dialog({
              title: 'Please Wait . . .',
              message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting  . . . .</p></center>'
            });
            dialog.init(function(){
              setTimeout(function(){
                $.post(base_url+"rest/deleteadmin",{email:email},function(a){
                  if(a.status == 1)
                  {
                    dialog.find(".modal-title").html("Request Successfully");
                    dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  }else{
                    dialog.find(".modal-title").html("Request Rejected");
                    dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                  }
                });
              }, 1000);
            });
          }
        });

      });
      $(".table").on("click",".edit", function() {
        var o = $(this);
          var dialog = bootbox.dialog({
              title: 'Please Wait . . .',
              message: '<center><p><i class="fa fa-spin fa-spinner"></i> Loading . . . .</p></center>'
          });
          dialog.init(function(){
              var id = o.attr("data-id");
              setTimeout(function(){
                $.get("<?= base_url("rest/crowdsaleTime") ?>"+"/"+id,function(d){
                if(d.status == 1)
                {
                var totalRound = d.msg.length;
                dialog.find(".modal-title").html("Edit Your Option");
                var html = "<div class='row'>"

                for(var i=1; i <= totalRound; i++)
                {
                  var ixar = i-1;
                  var json = JSON.parse(d.msg[ixar].meta_value);
                  var bonus = (json.timer_type == "open")?json.data.timer_bonus:"-1";
                  html += "<div class='col-md-12'>";
                  html +="<div class='col-md-12'><center><b>Round "+i+"</b></center></div>";
                  html += "<div class='col-md-4'><div class='form-group'><input value='"+(json.data.timer_start).split(" ")[0]+"' class='form-control date1' id='start_"+i+"' placeholder='Start Date'/></div></div>";
                  html += "<div class='col-md-4'><div class='form-group'><input class='form-control date2' value='"+(json.data.timer_end).split(" ")[0]+"' id='end_"+i+"' placeholder='End Date'/></div></div>";
                  html += "<div class='col-md-4'><div class='form-group'><input class='form-control ' value='"+bonus+"' id='bonus_"+i+"' placeholder='Bonus (-1 For Closed)'/></div></div>";
                  html += "</div>";
                }
                html += "<div class='col-md-12'>";
                html += "<div class='col-md-12'><div class='form-group'><input class='form-control sell' type='number' value='"+d.coin+"' placeholder='Total Coin Sell In This Round'/></div></div>";
                html += "<div class='col-md-12'>";
                html += "<div class='pull-right'>";
                html += "<button class='btn btn-primary' id='saveCrowdsale' data-round='"+totalRound+"'><li class='fa fa-save'></li></button>";
                html += "</div>";
                html += "</div>";
                html += "</div>";
                html +="</div>";
                dialog.find('.bootbox-body').html(html);
                dialog.find('.date1').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true}).on('changeDate', function (ev) {
                       $(this).blur();
                       $(this).datepicker('hide');
                });
                dialog.find('.date2').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true}).on('changeDate', function (ev) {
                       $(this).blur();
                       $(this).datepicker('hide');
                });
                dialog.find("#saveCrowdsale").click(function(){
                  bootbox.hideAll();
                  var dataForm = [];
                  var ix = 1;
                  var status = 1;
                  var sellcoin = $(".sell").val();
                  for(var i = 0; i < totalRound; i++)
                  {
                    var start = $("#start_"+ix).val();
                    var end = $("#end_"+ix).val();
                    var bonus = $("#bonus_"+ix).val();
                    if(bonus >= -1 && sellcoin > 0)
                    {
                      dataForm[i] = {start_date:start,end_date:end,bonus:bonus};
                      ix++
                    }else{
                      status = 0;
                      break;
                    }

                  }
                  console.log(dataForm);
                  if(status == 1)
                  {
                    var dialog = bootbox.dialog({
                        title: 'Please Wait . . .',
                        message: '<center><p><i class="fa fa-spin fa-spinner"></i> Creating  . . . .</p></center>'
                    });
                    dialog.init(function(){
                        setTimeout(function(){
                          $.post("<?= base_url("rest/updatecrowdsale") ?>",{data:dataForm,sell:sellcoin,id_crowdsale:id},function(data){
                            if(data.status == 1)
                            {
                              dialog.find(".modal-title").html("Request Successfully");
                              dialog.find(".bootbox-body").html("<div class='alert alert-success'>"+data.msg+"</div>");
                              location.reload(true);
                            }else{
                              dialog.find(".modal-title").html("Request Failed");
                              dialog.find(".bootbox-body").html("<div class='alert alert-danger'>"+data.msg+"</div>");
                            }
                          });

                        }, 1000);
                    });
                  }else{
                    bootbox.alert("Bonus must more than -1");
                  }
                });
                }else{
                  bootbox.alert("ID Not Found");
                }
                });
              }, 1000);
          });
      });
      $(".addUserakun").click(function() {
          bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control nama" placeholder="Name" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control user" placeholder="Username" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control pass" placeholder="Password" type="password" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control email" placeholder="Email" /></div></div></div>', function(result) {
            if(result)
            {
              var nama = $(".nama").val();
              var user = $(".user").val();
              var pass = $(".pass").val();
              var email = $(".email").val();
              if(nama.length > 3 && user.length > 3 && pass.length > 3 && email.length > 5 )
              {
                var datapost = {email:email,nama:nama,user:user,pass:pass};
                var dialog = bootbox.dialog({
                    title: 'Please Wait . . .',
                    message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
                });
                dialog.init(function(){
                    setTimeout(function(){
                      $.post(base_url+"rest/adduser",datapost,function(a){
                        if(a.status == 1)
                        {
                          dialog.find(".modal-title").html("Request Successfully");
                          dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                          location.reload(true);
                        }else{
                          dialog.find(".modal-title").html("Request Rejected");
                          dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                        }
                      });
                    }, 1000);
                });
              }else{
                bootbox.alert("Opps Something Error Check All Field. Name,Username,Password must be more than 3 and email more than 5 words");
              }
            }
        });
      });
      $(".addUser").click(function() {
        $.get("<?= base_url("rest/listdep") ?>",function(c){
          var dataoption = "<option selected>.: Choose One Department :.</option>";
          for(var i = 0; i < c.length; i++)
          {
            dataoption +="<option value='"+c[i].id_department+"'>"+c[i].department_name+"</option>";
          }
          bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control nama" placeholder="Name" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control user" placeholder="Username" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control pass" placeholder="Password" type="password" /></div></div><div class="col-md-12"><div class="form-group"><input class="form-control email" placeholder="Email" /></div></div><div class="col-md-12"><select class="form-control depid">'+dataoption+'</select></div></div>', function(result) {
            if(result)
            {
              var nama = $(".nama").val();
              var user = $(".user").val();
              var pass = $(".pass").val();
              var email = $(".email").val();
              var depid = $(".depid").val();
              if(nama.length > 3 && user.length > 3 && pass.length > 3 && email.length > 5 && $.isNumeric(depid))
              {
                var datapost = {email:email,nama:nama,user:user,pass:pass,depid:depid};
                var dialog = bootbox.dialog({
                    title: 'Please Wait . . .',
                    message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
                });
                dialog.init(function(){
                    setTimeout(function(){
                      $.post(base_url+"rest/addadmin",datapost,function(a){
                        if(a.status == 1)
                        {
                          dialog.find(".modal-title").html("Request Successfully");
                          dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                          location.reload(true);
                        }else{
                          dialog.find(".modal-title").html("Request Rejected");
                          dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                        }
                      });
                    }, 1000);
                });
              }else{
                bootbox.alert("Opps Something Error Check All Field. Name,Username,Passowrd must be more than 3 and email more than 5 words");
              }
            }
          });
        });
      });
      $(".addCrowdsale").click(function() {
        var a = $(this);
        bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control round" placeholder="Set How Many Round" type="number" /></div></div></div>', function(result) {
          if(result)
          {
            var totalRound = $(".round").val();
            if(totalRound > 0)
            {
              var dialog = bootbox.dialog({
                  title: 'Please Wait . . .',
                  message: '<center><p><i class="fa fa-spin fa-spinner"></i> Loading . . . .</p></center>'
              });
              dialog.init(function(){
                  setTimeout(function(){
                    dialog.find(".modal-title").html("Fill Your Option");
                    var html = "<div class='row'>"
                    for(var i=1; i <= totalRound; i++)
                    {
                      html += "<div class='col-md-12'>";
                      html +="<div class='col-md-12'><center><b>Round "+i+"</b></center></div>";
                      html += "<div class='col-md-4'><div class='form-group'><input class='form-control date1' id='start_"+i+"' placeholder='Start Date'/></div></div>";
                      html += "<div class='col-md-4'><div class='form-group'><input class='form-control date2' id='end_"+i+"' placeholder='End Date'/></div></div>";
                      html += "<div class='col-md-4'><div class='form-group'><input class='form-control ' id='bonus_"+i+"' placeholder='Bonus (-1 For Closed)'/></div></div>";
                      html += "</div>";
                    }
                    html += "<div class='col-md-12'>";
                    html += "<div class='col-md-12'><div class='form-group'><input class='form-control sell' type='number' placeholder='Total Coin Sell In This Round'/></div></div>";
                    html += "<div class='col-md-12'>";
                    html += "<div class='pull-right'>";
                    html += "<button class='btn btn-primary' id='saveCrowdsale' data-round='"+totalRound+"'><li class='fa fa-save'></li></button>";
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    html +="</div>";
                    dialog.find('.bootbox-body').html(html);
                    dialog.find('.date1').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true}).on('changeDate', function (ev) {
                           $(this).blur();
                           $(this).datepicker('hide');
                    });
                    dialog.find('.date2').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true}).on('changeDate', function (ev) {
                           $(this).blur();
                           $(this).datepicker('hide');
                    });
                    dialog.find("#saveCrowdsale").click(function(){
                      bootbox.hideAll();
                      var dataForm = [];
                      var ix = 1;
                      var status = 1;
                      var sellcoin = $(".sell").val();
                      for(var i = 0; i < totalRound; i++)
                      {
                        var start = $("#start_"+ix).val();
                        var end = $("#end_"+ix).val();
                        var bonus = $("#bonus_"+ix).val();
                        if(bonus >= -1 && sellcoin > 0)
                        {
                          dataForm[i] = {start_date:start,end_date:end,bonus:bonus};
                          ix++
                        }else{
                          status = 0;
                          break;
                        }

                      }
                      console.log(dataForm);
                      if(status == 1)
                      {
                        var dialog = bootbox.dialog({
                            title: 'Please Wait . . .',
                            message: '<center><p><i class="fa fa-spin fa-spinner"></i> Creating  . . . .</p></center>'
                        });
                        dialog.init(function(){
                            setTimeout(function(){
                              $.post("<?= base_url("rest/createcrowdsale") ?>",{data:dataForm,sell:sellcoin},function(data){
                                if(data.status == 1)
                                {
                                  dialog.find(".modal-title").html("Request Successfully");
                                  dialog.find(".bootbox-body").html("<div class='alert alert-success'>"+data.msg+"</div>");
                                  location.reload(true);
                                }else{
                                  dialog.find(".modal-title").html("Request Failed");
                                  dialog.find(".bootbox-body").html("<div class='alert alert-danger'>"+data.msg+"</div>");
                                }
                              });
                            }, 1000);
                        });
                      }else{
                        bootbox.alert("Bonus must more than -1");
                      }
                    });
                  }, 1000);
              });
            }else{
              bootbox.alert("Round must more than 0");
            }

          }
          });
      });
      $("#saveSetTimer").click(function() {
        var e = $(this);
        e.attr("disabled",true);
        var input = $("#timerSet").val();
        if(input != null)
        {
          var dialog = bootbox.dialog({
              title: 'Please Wait . . .',
              message: '<center><p><i class="fa fa-spin fa-spinner"></i> Setting Date CROWDSALE  . . . .</p></center>'
          });
          dialog.init(function(){
              setTimeout(function(){
                $.post(base_url+"rest/setTimer",{timer:input},function(a){
                  if(a.status == 1)
                  {
                    dialog.find(".modal-title").html("Request Successfully");
                    dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  }else{
                    dialog.find(".modal-title").html("Request Rejected");
                    dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                  }
                });
              }, 1000);
          });
        }else{
          bootbox.alert("<center>Date Cannot be NUll</center>");
        }
        e.removeAttr("disabled");
      });
      $(".table").on("click",".delete", function() {
        var e = $(this);
        bootbox.confirm('<div class="row"><center><h2>Are You Sure ?</h2></center></div>', function(a) {
          if(a)
          {
            var dialog = bootbox.dialog({
                title: 'Please Wait . . .',
                message: '<center><p><i class="fa fa-spin fa-spinner"></i> Deleting . . . .</p></center>'
            });
            dialog.init(function(){
                setTimeout(function(){
                  $.post(base_url+"rest/deletecrowdsale",{id:e.attr("data-id")},function(b){
                    if(b.status == 1)
                    {
                      dialog.find(".modal-title").html("Request Successfully");
                      dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+b.msg+'</center></div>');
                      location.reload(true);
                    }else{
                      dialog.find(".modal-title").html("Request Rejected");
                      dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+b.msg+'</center></div>');
                    }
                  });
                }, 1000);
            });
          }
        });
      });
      $(".table").on("click",".detail", function() {
        var e = $(this);
        $.get("<?= base_url("rest/crowdsaleTime/") ?>"+e.attr("data-id"),function(data){
          var dialog = bootbox.dialog({
              title: 'Please Wait . . .',
              message: '<center><p><i class="fa fa-spin fa-spinner"></i> Fetching Data . . </p></center>'
          });
          dialog.init(function(){
              setTimeout(function(){
                if(data.status == 1)
                {
                  dialog.find(".modal-title").html("Data Found");
                  var html = '<table class="table"><thead><th>Round</th><th>Timer Type</th><th>Start Round</th><th>End Round</th><th>Bonus</th><th>Status</th></thead><tbody>';
                  for(var i = 0; i < data.msg.length; i++)
                  {
                    var no = i+1;
                    var json = JSON.parse(data.msg[i].meta_value);
                    var splitStart = ((json.data.timer_start).split(" ")[0]).split("-")[2]+"-"+((json.data.timer_start).split(" ")[0]).split("-")[1]+"-"+((json.data.timer_start).split(" ")[0]).split("-")[0]+" "+(json.data.timer_start).split(" ")[1];
                    var splitEnd = ((json.data.timer_end).split(" ")[0]).split("-")[2]+"-"+((json.data.timer_end).split(" ")[0]).split("-")[1]+"-"+((json.data.timer_end).split(" ")[0]).split("-")[0]+" "+(json.data.timer_start).split(" ")[1];
                    var dateStart = new Date(splitStart).getTime();
                    var dateEnd = new Date(splitEnd).getTime();
                    var statusRound = ( cu_date >= dateStart  && cu_date <= dateEnd)?"Running":"Pending / Runned";
                    html += "<tr>";
                    html += "<td>"+data.msg[i].meta_key+"</td>";
                    html += "<td>"+json.timer_type+"</td>";
                    html += "<td>"+json.data.timer_start+"</td>";
                    html += "<td>"+json.data.timer_end+"</td>";
                    html += "<td>"+json.data.timer_bonus+"</td>";
                    html += "<td>"+statusRound+"</td>";
                    html += "</tr>";
                  }
                  html +="<tr class='bg-green'><td><b>Total Coin Sell</b></td><td colspan='5' align='center'><b>"+data.coin+" FRAS</b></td></tr>";
                  html +="</tbody></table>"
                  dialog.find('.bootbox-body').html(html);
                }else{
                  dialog.find(".modal-title").html("Data Not Found");
                  dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+data.msg+'</center></div>');
                }
              }, 1000);
          });
        });
      });
      $("#saveSetFras").click(function() {
        var e = $(this);
        e.attr("disabled",true);
        var input = $("#frasSet").val();
        if(input > 0)
        {
          var dialog = bootbox.dialog({
              title: 'Please Wait . . .',
              message: '<center><p><i class="fa fa-spin fa-spinner"></i> Setting Frascoin  . . . .</p></center>'
          });
          dialog.init(function(){
              setTimeout(function(){
                $.post(base_url+"rest/setFras",{fras:input},function(a){
                  if(a.status == 1)
                  {
                    dialog.find(".modal-title").html("Request Successfully");
                    dialog.find('.bootbox-body').html('<div class="alert alert-success"><center>'+a.msg+'</center></div>');
                  }else{
                    dialog.find(".modal-title").html("Request Rejected");
                    dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                  }
                });
              }, 1000);
          });
        }else{
          bootbox.alert("<center>Your Amount Cannot be Null</center>");
        }
        e.removeAttr("disabled");
      });
    });
    </script>
