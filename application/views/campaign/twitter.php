<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Twitter Campaign</h3>
              <div class="pull-right">
                  <button class="btn btn-success createUnique">Create Unique Hastag</button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" style="overflow: auto;max-height: 500px;">
                  <thead>
                    <th>Unique Hastag</th>
                    <th>Tweet Text</th>
                    <th>Status Tweet</th>
                    <th>Retweet</th>
                    <th>Validation</th>
                    <th>Tweet Date</th>
                    <th>Tweet Link</th>
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
                <li>You Must Tweet About Frasindo and put your unique hastag in your tweet</li>
                <li>One post put one Unique Hastag</li>
                <li>Min length of your tweet about frasindo is 50</li>
                <li>You can post everything about us, like a review or something else</li>
                <li>In example if you want tweet "Frasindo Great bla bla bla.. #youruniquehastag #frasindo"</li>
              </ol>
            </div>
          </div>
        </div>
    </div>
  </section>
</div>
<script>
 $(function() {
   var screenN = "<?= $this->session->twitter ?>";
   screenN = screenN.replace("@","");
   $.get("<?= base_url("rest/uniqid") ?>",function(a){
     if(a.length > 0)
     {

        for(var i = 0; i < a.length; i++)
        {
            var uniqcode = a[i].unique_code;
            $.get("<?= base_url("rest/validateTweet") ?>"+"/"+uniqcode+"/"+screenN,function(b){
              var html;
              html = "";
               if(b.status != 0)
               {
                  bs = b;
                  b = b.data;
                  html += "<tr>";
                  html += "<td>"+bs.ucode+"</td>";
                  html += "<td>"+b.statuses[0].text+"</td>";
                  var z = b.statuses[0].text;
                  h = z.split("");
                  if(h.length > 50)
                  {
                    html += "<td><center><span class='label label-success'><li class='fa fa-check'></li></span></td></center>";
                  }else{
                    html += "<td><center><span class='label label-danger'><li class='fa fa-ban'></li></span></td></center>";
                  }

                  if(b.validTweet == true)
                  {
                    html += "<td><center><span class='label label-success'><li class='fa fa-check'></li></span></td></center>";
                    html += "<td><center><span class='label label-success'><li class='fa fa-check'></li></span></td></center>";
                  }else{
                    html += "<td><center><span class='label label-warning'><li class='fa fa-hourglass'></li></span></td></center>";
                    html += "<td><center><span class='label label-warning'><li class='fa fa-hourglass'></li></span></td></center>";
                  }
                  html += "<td>"+b.statuses[0].created_at+"</td>";
                  html += "<td><a href='https://twitter.com/"+screenN+"/status/"+b.statuses[0].id_str+"'>https://twitter.com/"+screenN+"/status/"+b.statuses[0].id_str+"</a></td>";
                  html += "</tr>"
               }else{

                 html += "<tr>";
                 html += "<td>"+b.ucode+"</td>";
                 html += "<td><span class='label label-danger'>Need Validation</span></td>";
                 html += "<td><span class='label label-warning'>Pending</span></td>";
                 html += "<td><span class='label label-danger'>Need Validation</span></td>";
                 html += "<td><span class='label label-danger'>Need Validation</span></td>";
                 html += "<td><span class='label label-danger'>Need Validation</span></td>";
                 html += "<td><span class='label label-danger'>Need Validation</span></td>";
                 html += "</tr>"
               }
               $("#tweet").append(html);
            });
        }
     }
   });
 });
 $(function() {
   function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }
   $(".createUnique").click(function() {
     $.get(base_url+"rest/getFolowers/<?= $screenName ?>",function(a){
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
                   $.post(base_url+"rest/savecode",datapost,function(a){
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
         bootbox.alert(a.msg);
       }
     });
   });
 });
</script>
