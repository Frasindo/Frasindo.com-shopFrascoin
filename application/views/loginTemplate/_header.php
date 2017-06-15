<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $judul ?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url("assets/") ?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url("assets/") ?>plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url("assets/") ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        body {
          background-image: url();
          background-color: #313139;
        }

        .signUpForm {
          overflow: hidden;
          margin-top: 6rem;
          border-bottom: 6px solid #357ebd;
          box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.3);
          background-color: #fff;
          max-width: 300px;
          min-width: 240px;
        }

        .loginWith {
          overflow: hidden;
          margin-top: 2rem;
          padding: 1rem 2rem;
          border-bottom: 6px solid #357ebd;
          box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.3);
          background-color: #fff;
          max-width: 300px;
          min-width: 240px;
        }
        .loginWith h6 {
          color: #999;
        }
        .loginWith a, .loginWith i {
          width: 31.5%;
          cursor: pointer;
        }
        .loginWith i {
          text-align: center;
          font-size: 22px;
          line-height: 36px;
          border-right: 1px solid #ccc;
          margin: 0.8rem 0 1rem 0;
        }
        .loginWith .noBorder {
          border-right: none;
        }

        .head {
          position: relative;
        }
        .head img {
          width: 100%;
        }
        .head a {
          position: absolute;
          top: 6px;
          left: 8px;
          font-size: 11px;
          color: #fff;
          opacity: 0.33;
        }
        .head a:hover {
          opacity: 0.56;
        }
        .head a span {
          font-size: 12px;
          font-weight: bold;
        }

        .close {
          position: absolute;
          top: 0;
          right: 10px;
          font-size: 12px;
        }
        .close .circle {
          background-color: #ccc;
          padding: 1rem;
        }

        form {
          padding: 2.2rem 2rem;
        }
        form .input-group {
          margin-bottom: 1.6rem;
        }
        form .input-group .input-group-addon {
          border-radius: 0;
        }
        form .input-group .fa-lock {
          font-size: 18px;
          width: 14px;
        }
        form #exEmail, form #exPassword {
          border-radius: 0;
          height: 36px;
        }
        form #exEmail:focus, form #exPassword:focus {
          box-shadow: none;
        }
        form .btn {
          margin-bottom: 1.4rem;
          border-radius: 0;
        }
        form a {
          font-size: 11px;
        }

    </style>
    <style>
        .disabledLink {
            cursor: no-drop;
            pointer-events: none;
        }

    </style>
</head>
