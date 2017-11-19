<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Frasindo | Testimony</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <!--
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE
	DESIGNED & DEVELOPED by FREEHTML5.CO

	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="view-source:https://www.frasindo.com/wp-content/uploads/2017/05/BTCC_170516_0034.jpg">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>

	<!-- Animate.css -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url("assets/assetTestimonial/") ?>css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="<?= base_url("assets/assetTestimonial/") ?>css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="<?= base_url("assets/assetTestimonial/") ?>css/simple-line-icons.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="<?= base_url("assets/assetTestimonial/") ?>css/magnific-popup.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="<?= base_url("assets/assetTestimonial/") ?>css/bootstrap.css">

	<!--
	Default Theme Style
	You can change the style.css (default color purple) to one of these styles

	1. pink.css
	2. blue.css
	3. turquoise.css
	4. orange.css
	5. lightblue.css
	6. brown.css
	7. green.css

	-->
	<link rel="stylesheet" href="<?= base_url("assets/assetTestimonial/") ?>css/style.css">

	<!-- Styleswitcher ( This style is for demo purposes only, you may delete this anytime. ) -->
	<link rel="stylesheet" id="theme-switch" href="<?= base_url("assets/assetTestimonial/") ?>css/style3.css">
	<!-- End demo purposes only -->


	<style>
	/* For demo purpose only */

	/* For Demo Purposes Only ( You can delete this anytime :-) */
	#colour-variations {
		padding: 10px;
		-webkit-transition: 0.5s;
	  	-o-transition: 0.5s;
	  	transition: 0.5s;
		width: 140px;
		position: fixed;
		left: 0;
		top: 100px;
		z-index: 999999;
		background: #fff;
		/*border-radius: 4px;*/
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
		-webkit-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-moz-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-ms-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
	}
	#colour-variations.sleep {
		margin-left: -140px;
	}
	#colour-variations h3 {
		text-align: center;;
		font-size: 11px;
		letter-spacing: 2px;
		text-transform: uppercase;
		color: #777;
		margin: 0 0 10px 0;
		padding: 0;;
	}
	#colour-variations ul,
	#colour-variations ul li {
		padding: 0;
		margin: 0;
	}
	#colour-variations li {
		list-style: none;
		display: block;
		margin-bottom: 5px!important;
		float: left;
		width: 100%;
	}
	#colour-variations li a {
		width: 100%;
		position: relative;
		display: block;
		overflow: hidden;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		border-radius: 4px;
		-webkit-transition: 0.4s;
		-o-transition: 0.4s;
		transition: 0.4s;
	}
	#colour-variations li a:hover {
	  	opacity: .9;
	}
	#colour-variations li a > span {
		width: 33.33%;
		height: 20px;
		float: left;
		display: -moz-inline-stack;
		display: inline-block;
		zoom: 1;
		*display: inline;
	}


	.option-toggle {
		position: absolute;
		right: 0;
		top: 0;
		margin-top: 5px;
		margin-right: -30px;
		width: 30px;
		height: 30px;
		background: #f64662;
		text-align: center;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
		color: #fff;
		cursor: pointer;
		-webkit-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-moz-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		-ms-box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
		box-shadow: 0 0 9px 0 rgba(0,0,0,.1);
	}
	.option-toggle i {
		top: 2px;
		position: relative;
	}
	.option-toggle:hover, .option-toggle:focus, .option-toggle:active {
		color:  #fff;
		text-decoration: none;
		outline: none;
	}
	</style>
	<!-- End demo purposes only -->


	<!-- Modernizr JS -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
	<header role="banner" id="fh5co-header">
			<div class="container">
				<!-- <div class="row"> -->
			    <nav class="navbar navbar-default">
		        <div class="navbar-header">
		        	<!-- Mobile Toggle Menu Button -->
					<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav">
		            <li><a href="https://www.frasindo.com"><span>HOME</span></a></li>
                <li><a href="http://www.frasindo.com/media"><span>MEDIA</span></a></li>
                <li><a href="https://frasindo.com/shop/shop"><span>SHOP</span></a></li>
		          </ul>
		        </div>
			    </nav>
			  <!-- </div> -->
		  </div>
	</header>

	<section id="fh5co-home" data-section="home" style="background-image: url(images/full_image_2.jpg);" data-stellar-background-ratio="0.5">
		<div class="gradient"></div>
		<div class="container">
			<div class="text-wrap">
				<div class="text-inner">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">

							<img class="to-animate center" src="https://www.frasindo.com/wp-content/uploads/2017/05/FRASINDO200X200.png" alt="">
							<h1 class="to-animate">What they say about us ? </h1>
              <center><a href="#fh5co-testimonials" data-nav-section="testimonials" class="btn btn-primary to-animate">Click to See.</a></center>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="slant"></div>
	</section>

	<section id="fh5co-testimonials" data-section="testimonials">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Testimonials</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext to-animate">
							<button class="btn btn-primary" id="review">Click To Post Your Testify</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
        <?php foreach ($testimon as $value){?>
				<div class="col-md-4">
					<div class="box-testimony">
						<blockquote class="to-animate-2">
							<p><?= $value->isi ?></p>
						</blockquote>
						<div class="author to-animate">
							<figure><img src="<?= $value->img ?>" alt="Person"></figure>
							<p><b><span>
							<?= $value->nama ?></span>
            </b>
            </p>
              <p><?= ($value->company == null || $value->job == null)?null:"&nbsp(".$value->job." at ".$value->company.")" ?></p>
						</div>
					</div>
				</div>
        <?php }?>
      </div>
		</div>
	</section>
	<footer id="footer" role="contentinfo">
		<a href="#" class="gotop js-gotop"><i class="fa fa-arrow-up"></i></a>
		<div class="container">
			<div class="">
				<div class="col-md-12 text-center">
					<p><a href="https://mystellar.org/">PT.Frasindo Lima Mandiri</a> © 2013-Today</p>

				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="social social-circle">
						<li><a href="https://www.facebook.com/frasindo"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://www.twitter.com/frascoin"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://www.mystellar.org"><i class="fa fa-link"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>

	<!-- jQuery -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/jquery.stellar.min.js"></script>
	<!-- Counter -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/jquery.magnific-popup.min.js"></script>
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/magnific-popup-options.js"></script>
	<!-- Google Map -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false"></script>
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/google_map.js"></script>

	<!-- For demo purposes only styleswitcher ( You may delete this anytime ) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
	<script>
		$(function(){
      $("#review").click(function() {
        $.get("<?= base_url("rest/cekReview") ?>",function(data) {
           if( typeof data === 'string' ) {
             data = JSON.parse(data);
           }
            if(data.status == 0)
            {
              alert("You Not Login or You Has Been Reviewed Us");
            }else{
                bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><textarea class="form-control isi" placeholder="Write Your Review" ></textarea></div></div><div class="col-md-12"><div class="form-group"><input type="text" class="form-control job" placeholder="Your Job (OPTIONAL)" /></div></div><div class="col-md-12"><div class="form-group"><input type="text" class="form-control company" placeholder="Your Company Name (OPTIONAL)" /></div></div></div>', function(result) {
                  if(result)
                  {
                    var isi = $(".isi").val();
                    var job = $(".job").val();
                    var company = $(".company").val();
                    var dialog = bootbox.dialog({
                        title: 'Please Wait . . .',
                        message: '<center><p><i class="fa fa-spin fa-spinner"></i> Submiting Your Review  . . . .</p></center>'
                    });
                    dialog.init(function(){
                        setTimeout(function(){
                            $.post("<?= base_url("rest/review") ?>",{isi:isi,job:job,company:company}, function(data) {
                              if(data.status == 1)
                              {
                                  dialog.find('.bootbox-body').html("<center>"+data.msg+", Wait for Approve</center>");
                                  dialog.find('.modal-title').html("Request Successfully");
                              }else{
                                dialog.find('.bootbox-body').html("<center>"+data.msg+"</center>");
                                dialog.find('.modal-title').html("Request Rejected");
                              }
                            });
                        }, 1000);
                    });
                  }
                  });
            }
          });
      });
		});
	</script>
	<!-- End demo purposes only -->

	<!-- Main JS (Do not remove) -->
	<script src="<?= base_url("assets/assetTestimonial/") ?>js/main.js"></script>

	</body>
</html>
