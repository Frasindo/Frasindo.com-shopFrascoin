<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div class="col-xs-12"><div class="row">
        <div class="col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">
          <div class="signUpForm">
            <div class="head">
              <center><img  src="https://www.frasindo.com/media/wp-content/uploads/2017/05/Logo-FRASINDO-favicon-3.png" alt="Subscribe"/></center>
            </div>
            <div id="alert" class="">

            </div>
            <form role="form" class="flp">
              <div class="input-group has-feedback">
                <label class="sr-only" for="exEmail">Email</label>
                <input type="text" class="form-control" id="exEmail" placeholder="Username">
                <div class="input-group-addon"><i class="fa fa-users"></i></div>
              </div>
              <div class="input-group">
                <label class="sr-only" for="exPassword">Password</label>
                <input type="password" class="form-control" id="exPassword" placeholder="Password">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
              </div>
              <button type="button" class="btn btn-primary btn-block" id="loginCampaign" data-loading-text="Logining in...">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
