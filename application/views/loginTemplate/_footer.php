<!-- jQuery 3.1.1 -->
<script src="<?= base_url("assets/") ?>plugins/jQuery/jquery-3.1.1.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/base64/jquery.base64.js"></script>
<script src="<?= base_url("assets/") ?>plugins/jQueryUpload/jUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url("assets/") ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url("assets/") ?>bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script>
$(function() {
    $(".spinner").fadeOut(1000);
    $("#faceoff").fadeOut(1000);
    function hidePreload(){
      $(".spinner").fadeOut(2000);
      $("#faceoff").fadeOut(2000);
    }
    function showPreload() {
      $(".spinner").fadeIn(2000);
      $("#faceoff").fadeIn(2000);
    }

    $('#exBd').datepicker();

    $("#forgot").click(function() {
      var e = $(this);
      e.attr("disabled",true);
      bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><input class="form-control mail" placeholder="Input Your Email" type="email"></div></div></div>', function(result) {
        if(result)
        {
          var email = $(".mail").val();
          $.post("<?= base_url("rest/sendmail") ?>",{email:email},function(data){
              if(data.status != 0)
              {
                  var msg = '<div class="alert alert-success"><center>'+data.msg+'</center></div>';
              }else{
                  var msg = '<div class="alert alert-danger"><center>'+data.msg+'</center></div>';
              }
              var dialog = bootbox.dialog({
                  title: 'Please Wait . . .',
                  message: '<center><p><i class="fa fa-spin fa-spinner"></i> Reseting Your Password  . . . .</p></center>'
              });
              dialog.init(function(){
                  setTimeout(function(){
                    dialog.find('.bootbox-body').html(msg);
                  }, 1000);

              });
          });
        }
        e.removeAttr("disabled");
      });
    });
    $("#loginCampaign").click(function() {
        showPreload();
        var e = $(this);
        e.attr("disabled",true);
        var email = $("#exEmail").val();
        var password = $("#exPassword").val();
        $.base64.utf8encode = true;
        password = $.base64.encode(password, true);
        setTimeout(function(){
        $.post("<?= base_url("rest/loginCampaign") ?>", {email: email,pass : password}, function(result){
            console.log(result);
            $("#alert").removeAttr("class");
            $("#alert").html("");
            if(result.status == 1)
                {
                    $("#alert").addClass("alert alert-success");
                    $("#alert").html("<center>"+result.msg+"</center>");
                    setTimeout(function(){window.location = "<?= base_url("campaign") ?>";},2000);
                    hidePreload();
                }else{
                    $("#alert").addClass("alert alert-danger");
                    $("#alert").html("<center>"+result.msg+"</center>");
                    hidePreload();
                }
            setTimeout(function(){
                $("#alert").removeAttr("class");
                $("#alert").attr("class","hidden");
            },2000);
        });
      },2000);
        e.attr("disabled",false);
        });
    $("#loginAdmin").click(function() {
        showPreload();
        var e = $(this);
        e.attr("disabled",true);
        var email = $("#exEmail").val();
        var password = $("#exPassword").val();
        $.base64.utf8encode = true;
        password = $.base64.encode(password, true);
        setTimeout(function(){
        $.post("<?= base_url("rest/loginAdmin") ?>", {email: email,pass : password}, function(result){
            console.log(result);
            $("#alert").removeAttr("class");
            $("#alert").html("");
            if(result.status == 1)
                {
                    $("#alert").addClass("alert alert-success");
                    $("#alert").html("<center>"+result.msg+"</center>");
                    setTimeout(function(){window.location = "<?= base_url("admin") ?>";},2000);
                    hidePreload();
                }else{
                    $("#alert").addClass("alert alert-danger");
                    $("#alert").html("<center>"+result.msg+"</center>");
                    hidePreload();
                }
            setTimeout(function(){
                $("#alert").removeAttr("class");
                $("#alert").attr("class","hidden");
            },2000);
        });
      },2000);
        e.attr("disabled",false);
        });
    $("#login").click(function() {
        showPreload();
        $("#login").attr("disabled",true);
        var email = $("#exEmail").val();
        var password = $("#exPassword").val();
        $.base64.utf8encode = true;
        password = $.base64.encode(password, true);
        setTimeout(function(){
        $.post("<?= base_url("rest/login") ?>", {email: email,pass : password}, function(result){
            console.log(result);
            $("#alert").removeAttr("class");
            $("#alert").html("");
            if(result.status == 1)
                {
                    $("#alert").addClass("alert alert-success");
                    $("#alert").html("<center>"+result.msg+"</center>");
                    setTimeout(function(){window.location = "<?= base_url("shop") ?>";},2000);
                    hidePreload();
                }else{
                    $("#alert").addClass("alert alert-danger");
                    $("#alert").html("<center>"+result.msg+"</center>");
                    hidePreload();
                }
            setTimeout(function(){
                $("#alert").removeAttr("class");
                $("#alert").attr("class","hidden");

            },3000);
        });
        $("#login").attr("disabled",false);
        },3000);
    });
    $("#register").click(function() {
        showPreload();
        $("#register").attr("disabled",true);
        var username = $("#exUser").val();
        var emailA = $("#exEmail").val();
        var emailR = $("#exEmailR").val();
        var passwordA = $("#exPassword").val();
        var passwordR = $("#exPasswordR").val();
        $.base64.utf8encode = true;
        if(passwordR != "" && passwordA != ""  && username != "" && emailA != "" && emailR != "")
        {
            if(passwordR == passwordA && emailA == emailR)
            {
                var password = $.base64.encode(passwordA, true);
                var email = emailA;
                setTimeout(function(){
                $.post("<?= base_url("rest/register") ?>", {user:username,email: email,pass : password}, function(result){
                    console.log(result);
                    $("#alert").removeAttr("class");
                    $("#alert").html("");
                    if(result.status == 1)
                    {
                        $("#alert").addClass("alert alert-success");
                        $("#alert").html("<center>"+result.msg+"</center>");
                        setTimeout(function(){window.location = "<?= base_url("shop") ?>";},2000);
                        hidePreload();
                    }else{
                        $("#alert").addClass("alert alert-danger");
                        $("#alert").html("<center>"+result.msg+"</center>");
                        hidePreload();
                    }
                    setTimeout(function(){
                        $("#alert").removeAttr("class");
                        $("#alert").attr("class","hidden");
                     },3000);
                     $("#register").attr("disabled",false);
                });
                },3000);
            }else{
                $("#register").attr("disabled",false);
                $("#alert").addClass("alert alert-danger");
                $("#alert").html("<center>Your Password not Equal or Your Email Not Equal</center>");
                hidePreload();
            }
        }else{
            $("#register").attr("disabled",false);
            $("#alert").addClass("alert alert-danger");
            $("#alert").html("<center>Check Your Field</center>");
            hidePreload();
        }

    });
});

</script>
</html>
