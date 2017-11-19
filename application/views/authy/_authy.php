<body>
<div class="container">
<div class="row">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="padding-top:160px;">
            <div class="panel panel-primary">
                <div class="panel-heading">2FA Challange</div>
                <div class="panel-body">
                        <?= (isset($alert))?$alert:null ?>
                        <div class="col-sm-12">
                            
                            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="">
                            <div class="row">
                            <div class="col-sm-12">
                                <input type="text" placeholder="Enter Google Authy Code" name="authy" class="form-control"/>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-12 text-center">
                                <br>
                            <button type="submit" name="setAuth" class="btn btn-success">Send Authy</button>
                            </div>
                            </div>
                             </form>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>