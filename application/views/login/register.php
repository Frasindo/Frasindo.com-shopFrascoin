<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div class="col-xs-12"><div class="row">
        <div class="col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">
          <div class="signUpForm">
            <div class="head">
              <img src="<?= $img ?>" alt="Subscribe"/>
            </div>
            <div class="" id="alert">
              
            </div>
            <form role="form" id="registForm" class="flp">
             <div class="input-group has-feedback">
                <label class="sr-only" for="exName">Your Full Name</label>
                <input type="text" class="form-control" id="exName" placeholder="Your Full Name">
                <div class="input-group-addon"><i class="fa fa-users"></i></div>
              </div>
              <div class="input-group has-feedback">
                <label class="sr-only" for="exUser">Username</label>
                <input type="text" class="form-control" id="exUser" placeholder="Your Username">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
              </div>
              <div class="input-group has-feedback">
                <label class="sr-only" for="exBd">BirthDay</label>
                <input type="text" class="form-control" id="exBd" placeholder="Your BirthDay for Special Gift">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              </div>
              <div class="input-group has-feedback">
                <label class="sr-only" for="exWa">WA Number</label>
                <input type="number" class="form-control" id="exWa" placeholder="Your Whatsapp Number for VideoCall with Us">
                <div class="input-group-addon"><i class="fa fa-whatsapp"></i></div>
              </div>
              <div class="input-group has-feedback">
                <label class="sr-only" for="exLine">Line ID</label>
                <input type="text" class="form-control" id="exLine" placeholder="Your Line ID for Audit - Only for 200 Account">
                <div class="input-group-addon"><i class="fa fa-chain"></i></div>
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
              <button type="button" class="btn btn-primary btn-block" id="register" data-loading-text="Logining in...">Login</button>
              <a href="<?= base_url("login") ?>">Have Account ? Login Now </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>