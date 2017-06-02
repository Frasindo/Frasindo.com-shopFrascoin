<!-- jQuery 3.1.1 -->
<script src="<?= base_url("assets/") ?>plugins/jQuery/jquery-3.1.1.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/base64/jquery.base64.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url("assets/") ?>bootstrap/js/bootstrap.min.js"></script>
<script>
$(function() {
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
        var email = $("#exEmail").val();
        var passwordA = $("#exPassword").val();
        var passwordR = $("#exPasswordR").val();
        $.base64.utf8encode = true;
        if(passwordR != "" && passwordA != "")
        {
            if(passwordR == passwordA)
            {
                var password = $.base64.encode(passwordA, true);
                setTimeout(function(){
                $.post("<?= base_url("rest/register") ?>", {email: email,pass : password}, function(result){
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
                alert("Your Password not Equal");
            }
        }else{
            $("#register").attr("disabled",false);
            alert("Check Your Password");
        }
        
    });
});

</script>
</html>
