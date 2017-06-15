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
<script>
$(function() {
    $('#exBd').datepicker();
    $("#login").click(function() {
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
                    $("#alert").html(result.msg);
                    setTimeout(function(){window.location="<?= base_url() ?>";},2000);
                }else{
                    $("#alert").addClass("alert alert-danger");
                    $("#alert").html(result.msg);
                }
            setTimeout(function(){
                $("#alert").removeAttr("class");
                $("#alert").attr("class","hidden");
                
            },2000);
        });
        $("#login").attr("disabled",false);
        },3000);
    });
    $("#register").click(function() {
        $("#register").attr("disabled",true);
        var nama = $("#exName").val();
        var birth = $("#exBd").val();
        var wa = $("#exWa").val();
        var line = $("#exLine").val();
        var username = $("#exUser").val();
        var emailA = $("#exEmail").val();
        var emailR = $("#exEmailR").val();
        var passwordA = $("#exPassword").val();
        var passwordR = $("#exPasswordR").val();
        $.base64.utf8encode = true;
        if(passwordR != "" && passwordA != "" &&  nama != "" && birth != "" && line != "" && $.isNumeric(wa)  && username != "" && emailA != "" && emailR != "")
        {
            if(passwordR == passwordA && emailA == emailR)
            {
                var password = $.base64.encode(passwordA, true);
                var email = emailA;
                setTimeout(function(){
                $.post("<?= base_url("rest/register") ?>", {birthday:birth,line:line,wa:wa,user:username,nama:nama,email: email,pass : password}, function(result){
                    console.log(result);
                    $("#alert").removeAttr("class");
                    $("#alert").html("");
                    if(result.status == 1)
                    {
                        $("#alert").addClass("alert alert-success");
                        $("#alert").html(result.msg);
                    }else{
                        $("#alert").addClass("alert alert-danger");
                        $("#alert").html(result.msg);
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
                alert("Your Password not Equal or Your Email Not Equal");
            }
        }else{
            $("#register").attr("disabled",false);
            alert("Check Your Field");
        }
        
    });
});

</script>
</html>
