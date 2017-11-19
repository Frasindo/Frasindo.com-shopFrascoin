<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Vlog Campaign</h3>
              <div class="pull-right">
                  <button class="btn btn-success createUnique">Create Unique Hastag</button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" style="overflow: auto;max-height: 500px;">
                  <thead>
                    <th>Unique Hastag</th>
                    <th>Video Description</th>
                    <th>Video Duration</th>
                    <th>Validation</th>
                    <th>Video Date</th>
                    <th>Video Link</th>
                  </thead>
                  <tbody id="tweet">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Guides</h3>
            </div>
            <div class="box-body">
              <ol>
                <li>Generate Unique Hastag by Click "Create Unique Hastag"</li>
                <li>You Must Upload Videos About Frasindo and put your unique hastag in your Video Description</li>
                <li>One post put one Unique Hastag</li>
                <li>Min length Duration of Your Video >= 1 Min</li>
                <li>You can post everything about us, like a review or something else</li>
                <li>In example in your description video "That review frasindo from me #youruniquehastag"</li>
              </ol>
            </div>
          </div>
        </div>
    </div>
  </section>
</div>
<script>
 $(function() {
   function convert_time(duration) {
    var a = duration.match(/\d+/g);

    if (duration.indexOf('M') >= 0 && duration.indexOf('H') == -1 && duration.indexOf('S') == -1) {
        a = [0, a[0], 0];
    }

    if (duration.indexOf('H') >= 0 && duration.indexOf('M') == -1) {
        a = [a[0], 0, a[1]];
    }
    if (duration.indexOf('H') >= 0 && duration.indexOf('M') == -1 && duration.indexOf('S') == -1) {
        a = [a[0], 0, 0];
    }

    duration = 0;

    if (a.length == 3) {
        duration = duration + parseInt(a[0]) * 3600;
        duration = duration + parseInt(a[1]) * 60;
        duration = duration + parseInt(a[2]);
    }

    if (a.length == 2) {
        duration = duration + parseInt(a[0]) * 60;
        duration = duration + parseInt(a[1]);
    }

    if (a.length == 1) {
        duration = duration + parseInt(a[0]);
    }
    return duration
}
   var ytdid;
      $.get("<?= base_url("rest/uniqidytd") ?>",function(a){
        if(a.length > 0)
        {

          for(var i = 0; i < a.length; i++)
          {
            var ytdid = "<?= $this->session->youtube ?>";
            var uniqcode = a[i].unique_code;
            $.get("<?= base_url("rest/validateVlog") ?>"+"/"+uniqcode+"/"+ytdid,function(b){
              var html;
              html = "";
              if(b.status != 0)
              {
                b = b.data;
                var duration = parseFloat(convert_time(b.duration) / 60).toFixed(0);
                html += "<tr>";
                html += "<td>"+b.uniqcode+"</td>";
                html += "<td><span class='label label-primary'>"+b.description+"</span></td>";
                if(duration >= 5)
                {
                  html += "<td><span class='label label-primary'>"+duration+"</span></td>";
                }else{
                  html += "<td><span class='label label-danger'>Duration Invalid ("+duration+")</span></td>";
                }

                if(b.validate != false)
                {
                  html += "<td><span class='label label-success'>Valid</span></td>";
                }else{
                  html += "<td><span class='label label-danger'>Invalid</span></td>";
                }
                var date = new Date(b.publishedAt)
                html += "<td><span class='label label-primary'>"+date+"</span></td>";
                html += "<td><span class='label label-primary'><a href='"+b.link+"' style='color:white;'>"+b.link+"</a></span></td>";
                html += "</tr>"
              }else{
                html += "<tr>";
                html += "<td>"+b.uniqcode+"</td>";
                html += "<td><span class='label label-danger'>Not Found</span></td>";
                html += "<td><span class='label label-danger'>Not Found</span></td>";
                html += "<td><span class='label label-danger'>Not Found</span></td>";
                html += "<td><span class='label label-danger'>Not Found</span></td>";
                html += "<td><span class='label label-danger'>Not Found</span></td>";
                html += "</tr>"
              }
              $("#tweet").append(html);
            });
          }
        }
      });
 });
 $(function(){
   function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }
   $(".createUnique").click(function() {
     $.get("<?= base_url("rest/cekYt/".$this->session->id_users) ?>",function(a){
       if(a.status == 1)
       {
         bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control how" type="number" placeholder="How Many Unique Hastag ?"  /></div><div class="col-md-12"><div class="generated"></div></div></div></div>', function(result) {
           if(result)
           {
             var how = $(".how").val();
             var gen = $(".generated");
             if(how > 0)
             {
               var field;
               field = "";
               var code = [];
               for(var i = 0; i < how; i++){
                 code[i] = "<?= $this->session->id_users ?>"+randomString(10,"AS4E2HHASD621UFQWE612YKGD8KI12I863YU97TRGHD1091FYPR6FYGRH3FE0RDFYR3GWTDF");
                 field += "<div class='col-md-3'>"+code[i]+"</div>";
               }
               var datapost = {code:code};
               var dialog = bootbox.dialog({
                   title: 'Please Wait . . .',
                   message: '<center><p><i class="fa fa-spin fa-spinner"></i> Saving . . . .</p></center>'
               });
               dialog.init(function(){
                   setTimeout(function(){
                     $.post(base_url+"rest/savecodeytd",datapost,function(a){
                       if(a.status == 1)
                       {
                         dialog.find(".modal-title").html("Request Successfully");
                         dialog.find('.bootbox-body').html('<div class="row"><div class="col-md-12"><center><b>Hastag Has Been Generated</b></center></div>'+field+'</div>');
                       }else{
                         dialog.find(".modal-title").html("Request Rejected");
                         dialog.find('.bootbox-body').html('<div class="alert alert-danger"><center>'+a.msg+'</center></div>');
                       }
                     });
                   }, 1000);
               });
             }else{
               bootbox.alert("Sorry You Can Generate Unique Hastag More than 0");
             }
           }
         });
       }else{
         bootbox.alert("Oops Your ChanelID Empty or Wrong");
       }
     });
   });
 });
 </script>
