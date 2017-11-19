<body>
<div class="container">
<div class="row">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="padding-top:160px;">
            <div class="panel panel-primary">
                <div class="panel-heading">Set Your Avatar</div>
                <div class="panel-body">
                        <?= (isset($alert))?$alert:null ?>
                        <div class="col-sm-4 text-center">
                            <img src="http://plugins.krajee.com/uploads/default_avatar_male.jpg" class="center-block img-circle img-responsive">
                        </div>
                        <div class="col-sm-8">
                            
                            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="">
                            <div class="row">
                            <div class="col-sm-12">
                                <input type="file" name="avatar" class="form-control"/>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-12 text-center">
                                <br>
                            <button type="submit" name="setAvatar" class="btn btn-success">Set Avatar</button>
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