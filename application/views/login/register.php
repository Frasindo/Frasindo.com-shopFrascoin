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
            <div class="" id="alert">

            </div>
            <form role="form" id="registForm" class="flp">
              <div class="input-group has-feedback">
                <label class="sr-only" for="exUser">Username</label>
                <input type="text" class="form-control" id="exUser" placeholder="Your Username">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
              </div>
              <div class="input-group has-feedback">
                <label class="sr-only" for="exEmail">Email</label>
                <input type="email" class="form-control" id="exEmail" placeholder="Email">
                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
              </div>
              <div class="input-group has-feedback">
                <label class="sr-only" for="exEmail">Repeat Email</label>
                <input type="email" class="form-control" id="exEmailR" placeholder="Re Enter Your Email">
                <div class="input-group-addon"><i class="fa fa-refresh"></i></div>
              </div>
              <div class="input-group">
                <label class="sr-only" for="exPassword">Password</label>
                <input type="password" class="form-control" id="exPassword" placeholder="Password">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
              </div>
              <div class="input-group">
                <label class="sr-only" for="exPassword">Password</label>
                <input type="password" class="form-control" id="exPasswordR" placeholder="Password Repeat">
                <div class="input-group-addon"><i class="fa fa-refresh"></i></div>
              </div>
              <button type="button" class="btn btn-primary btn-block" id="register" data-loading-text="Logining in...">Register</button>
              <center><h4>OR</h4></center>
              <a href="<?= base_url("login") ?>"  class="btn btn-success btn-block">Login</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
