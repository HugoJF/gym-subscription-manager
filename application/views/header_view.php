<?php

	$names = $this->gsm_model->get_all_users_name();
	$users_name = array();
	foreach($names->result() as $name) {
		array_push($users_name, $name->first_name . ' ' . $name->last_name);
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Carousel Template &middot; Bootstrap</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link href="<?php echo base_url ('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url ('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<style>

			/* GLOBAL STYLES
			-------------------------------------------------- */
			/* Padding below the footer and lighter body text */

		body {
			padding-bottom: 40px;
			color: #5a5a5a;
		}

			/* CUSTOMIZE THE NAVBAR
			-------------------------------------------------- */

			/* Special class on .container surrounding .navbar, used for positioning it into place. */
		.navbar-wrapper {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			z-index: 10;
			margin-top: 20px;
			margin-bottom: -90px; /* Negative margin to pull up carousel. 90px is roughly margins and height of navbar. */
		}

		.navbar-wrapper .navbar {

		}

			/* Remove border and change up box shadow for more contrast */
		.navbar .navbar-inner {
			border: 0;
			-webkit-box-shadow: 0 2px 10px rgba(0, 0, 0, .25);
			-moz-box-shadow: 0 2px 10px rgba(0, 0, 0, .25);
			box-shadow: 0 2px 10px rgba(0, 0, 0, .25);
		}

			/* Downsize the brand/project name a bit */
		.navbar .brand {
			padding: 14px 20px 16px; /* Increase vertical padding to match navbar links */
			font-size: 16px;
			font-weight: bold;
			text-shadow: 0 -1px 0 rgba(0, 0, 0, .5);
		}

			/* Navbar links: increase padding for taller navbar */
		.navbar .nav > li > a {
			padding: 15px 20px;
		}

			/* Offset the responsive button for proper vertical alignment */
		.navbar .btn-navbar {
			margin-top: 10px;
		}

			/* MARKETING CONTENT
			-------------------------------------------------- */

			/* Center align the text within the three columns below the carousel */
		.marketing {
			margin-top: 75px;
		}

		.marketing .span4 {
			text-align: center;
		}

		.marketing h2 {
			font-weight: normal;
		}

		.marketing .span4 p {
			margin-left: 10px;
			margin-right: 10px;
		}

			/* RESPONSIVE CSS
			-------------------------------------------------- */

		@media (min-width: 979px) {
			/*DESKTOPS*/
			.action-table-header {
				width: 300px;
			}
		}

		@media (max-width: 979px) {
			.action-table-header {
				width: 300px;
			}

			.container.navbar-wrapper {
				margin-bottom: 0;
				width: auto;
			}

			.navbar-inner {
				border-radius: 0;
				margin: -20px 0;
			}

			.carousel .item {
				height: 500px;
			}

			.carousel img {
				width: auto;
				height: 500px;
			}

			.featurette {
				height: auto;
				padding: 0;
			}

			.featurette-image.pull-left,
			.featurette-image.pull-right {
				display: block;
				float: none;
				max-width: 40%;
				margin: 0 auto 20px;
			}
		}

		@media (max-width: 767px) {
			/*PHONE*/

			.navbar-inner {
			}

			.carousel {
				margin-left: -20px;
				margin-right: -20px;
			}

			.carousel .container {

			}

			.carousel .item {
				height: 300px;
			}

			.carousel img {
				height: 300px;
			}

			.carousel-caption {
				width: 65%;
				padding: 0 70px;
				margin-top: 100px;
			}

			.carousel-caption h1 {
				font-size: 30px;
			}

			.carousel-caption .lead,
			.carousel-caption .btn {
				font-size: 18px;
			}

			.marketing .span4 + .span4 {
				margin-top: 40px;
			}

			.featurette-heading {
				font-size: 30px;
			}

			.featurette .lead {
				font-size: 18px;
				line-height: 1.5;

			}

		}

		.label {
			width: 120px;
			text-align: center;
		}

		.action-table-header {
			width: auto !important;
		}


	</style>

	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>

<body style="padding-left:5px;padding-right: 5px">


<!-- NAVBAR
================================================== -->
<div class="navbar-wrapper">
	<!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
	<div class="container">
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('header_title'); ?></a>
				<!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="active"><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('header_home'); ?></a></li>
						<li><a href="<?php echo base_url('users/add'); ?>"><?php echo $this->lang->line('header_register_user'); ?></a></li>
						<li><a href="<?php echo base_url('users/deactivated'); ?>"><?php echo $this->lang->line('header_deactivated_users'); ?></a></li>
						<!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
					</ul>
						<form method="POST"action="<?php echo base_url('users/detail')?>" style="margin-top: 5px"class="navbar-form pull-right">
							<input type="text" name="user" data-provide="typeahead" data-items="5" data-source="<?php /* echo '[&quot;' . implode('&quot;, &quot;', $users_name) . '&quot;]'; */?>" placeholder="<?php echo $this->lang->line('user_name'); ?>" autocomplete="off">
						</form>
				</div>
				<!--/.nav-collapse -->
			</div>
			<!-- /.navbar-inner -->
		</div>
		<!-- /.navbar -->
	</div>
	<!-- /.container -->
</div>
<!-- /.navbar-wrapper -->
