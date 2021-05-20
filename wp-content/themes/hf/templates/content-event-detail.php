<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>
  
  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<section class="inner-page-navigation">
	<div class="container">
		<div class="row">
			<div class="pn-menu">
				<ul>
					<li class="active"><a class="pnm-e-about" href="#!"><span>about</span></a>
					</li>
					<li><a class="pnm-e-agenda" href="#!"><span>agenda</span></a>
					</li>
					<li><a class="pnm-e-speakers" href="#!"><span>speakers</span></a>
					</li>
					<li><a class="pnm-e-venue" href="#!"><span>venue</span></a>
					</li>
					<li><a class="pnm-e-sponsors" href="#!"><span>sponsors</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>


<!--====================================
=             event detail             =
=====================================-->
<!--====  event intro  ====-->

<section class="event-detail-content page-wrapper">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-8 float-left">
				<div class="event-post">
					<div class="event-container">
						<div class="event-feature">
							<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/eve-det-post.jpg" />
						</div>
						<p class="text-paragraph">
							Every human being’s most fundamental right to life is trampled when they do not have access to adequate health care. Humanity First envisions universal health care in all communities. Common diseases, epidemics, and blindness are some health concerns that can be easily prevented and sufficiently contained. Every human being’s most fundamental right to life is trampled when they do not have access to adequate health care. Humanity First envisions universal health care in all communities.
							<br />
							<br />
							Common diseases, epidemics, and blindness are some health concerns that can be easily prevented and sufficiently contained. Every human being’s most fundamental right to life is trampled when they do not have access to adequate health care. Humanity First envisions universal health care in all communities. Common diseases, epidemics, and blindness are some health concerns that can be easily prevented and sufficiently contained. Every human being’s most fundamental right to life is trampled when they do not have access to adequate health care. Humanity First envisions universal health care in all communities.
							<br />
							<br />      
							Every human being’s most fundamental right to life is trampled when they do not have access.
						</p>
						<div class="clearfix"></div>


						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>


				</div>
			</div>


			<div class="col-4 float-right">
				<div class="blog-sidebar">
					<div class="write-your-story-btn">
						<a href="#!">BUY TICKET</a>
					</div>

					<div class="sidebar-links">
						<h4>Details</h4>
						<div class="detail-container">
							<div class="de-date">
								<div class="icon">
									<i class="fa fa-calendar-o" aria-hidden="true"></i>
								</div>
								<div class="date">
									<h5>Date</h5>
									<h6>02 November, 2017</h6>
								</div>
							</div>
							<div class="de-date">
								<div class="icon">
									<i class="fa fa-play-circle-o" aria-hidden="true"></i>
								</div>
								<div class="date">
									<h5>Event Start</h5>
									<h6>09:00 AM US Time Zone</h6>
								</div>
							</div>

							<div class="de-date">
								<div class="icon">
									<i class="fa fa-power-off" aria-hidden="true"></i>
								</div>
								<div class="date">
									<h5>Event End</h5>
									<h6>05:00 PM US Time Zone</h6>
								</div>
							</div>

							<div class="de-date">
								<div class="icon">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
								</div>
								<div class="date">
									<h5>Venue</h5>
									<h6>Oshkosh Community Hall</h6>
								</div>
							</div>


						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>


<!--====  end of event intro  ====-->

<!--===============================
=            Starts In            =
================================-->

<section class="event-starts-in">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<h3>Event Starts in</h3>
				<p id="demo" class="count-down-timer"><time><span>43</span> <b>Days</b> </time><time><span>18</span><b>Hours</b> </time><time><span>32</span><b>Minutes</b> </time> <time><span>2</span><b>Seconds</b> </time></p>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>
<script>
	var countDownDate = new Date("Jan 5, 2018 15:37:25").getTime();

	var x = setInterval(function() {

		var now = new Date().getTime();


		var distance = countDownDate - now;

		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		document.getElementById("demo").innerHTML = "<time><span>" + days + "</span> <b>Days</b> </time>" + "<time><span>" + hours + "</span><b>Hours</b> </time>"  + "<time><span>" + minutes + "</span><b>Minutes</b> </time> " + "<time><span>" + seconds + "</span><b>Seconds</b> </time>";

		if (distance < 0) {
			clearInterval(x);
			document.getElementById("demo").innerHTML = "EXPIRED";
		}
	}, 1000);
</script>
<!--====  End of Starts In  ====-->

<!--==============================
=            Schedule            =
===============================-->

<section class="schedule-section">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<h3>SCHEDULE</h3>
				<div class="row justify-content-center">
					<div class="col-9">
						<div class="tab-container">
							<ul class="nav nav-tabs d-flex justify-content-center" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" href="#friday" role="tab" data-toggle="tab"><span class="day">FRIDAY</span><span class="date">NOV 26, 2017</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#saturday" role="tab" data-toggle="tab"><span class="day">SATURDAY</span><span class="date">NOV 26, 2017</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#sunday" role="tab" data-toggle="tab"><span class="day">SUNDAY</span><span class="date">NOV 26, 2017</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#monday" role="tab" data-toggle="tab"><span class="day">MONDAY</span><span class="date">NOV 26, 2017</span></a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="friday">
									<ul>
										<li>
											<span class="panel-date">09:00 am - 09:30 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Registration</span>
										</li>
										<li>
											<span class="panel-date">09:30 am - 09:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Welcome and Introduction</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Keynote Speaker</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Publice Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Questions & Answer Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Brunch</span>
										</li>
									</ul>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="saturday">	<ul>
										<li>
											<span class="panel-date">09:00 am - 09:30 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Registration</span>
										</li>
										<li>
											<span class="panel-date">09:30 am - 09:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Welcome and Introduction</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Keynote Speaker</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Publice Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Questions & Answer Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Brunch</span>
										</li>
									</ul>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="sunday">	<ul>
										<li>
											<span class="panel-date">09:00 am - 09:30 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Registration</span>
										</li>
										<li>
											<span class="panel-date">09:30 am - 09:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Welcome and Introduction</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Keynote Speaker</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Publice Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Questions & Answer Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Brunch</span>
										</li>
									</ul>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="monday">	<ul>
										<li>
											<span class="panel-date">09:00 am - 09:30 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Registration</span>
										</li>
										<li>
											<span class="panel-date">09:30 am - 09:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Welcome and Introduction</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Keynote Speaker</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Publice Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Questions & Answer Session</span>
										</li>
										<li>
											<span class="panel-date">09:40 am - 10:40 am</span>
											<span class="pipe-separator">|</span>
											<span class="schedule-title">Brunch</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>

<!--====  End of Schedule  ====-->

<!--==============================
=            Speakers            =
===============================-->

<section class="speakers-section">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<h3>speakers</h3>
				<div class="row">
					<div class="col-3">
						<div class="evnts-speaker-block">
							<div class="ets-image">
								<div class="ets-image-inner">
									<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" />
									<div class="social-icons">
										<ul>
											<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>

							</div>
							<div class="name-designation">
								<h2>eddy adams</h2>
								<h5>Deputy General Commisioner</h5>
								<h5>Regional Policies</h5>
							</div>
						</div>
					</div>
					<div class="col-3">
						<div class="evnts-speaker-block">
							<div class="ets-image">
								<div class="ets-image-inner">
									<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" />
									<div class="social-icons">
										<ul>
											<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
								
							</div>
							<div class="name-designation">
								<h2>eddy adams</h2>
								<h5>Deputy General Commisioner</h5>
								<h5>Regional Policies</h5>
							</div>
						</div>
					</div>
					<div class="col-3">
						<div class="evnts-speaker-block">
							<div class="ets-image">
								<div class="ets-image-inner">
									<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" />
									<div class="social-icons">
										<ul>
											<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
								
							</div>
							<div class="name-designation">
								<h2>eddy adams</h2>
								<h5>Deputy General Commisioner</h5>
								<h5>Regional Policies</h5>
							</div>
						</div>
					</div>
					<div class="col-3">
						<div class="evnts-speaker-block">
							<div class="ets-image">
								<div class="ets-image-inner">
									<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" />
									<div class="social-icons">
										<ul>
											<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#!"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
								
							</div>
							<div class="name-designation">
								<h2>eddy adams</h2>
								<h5>Deputy General Commisioner</h5>
								<h5>Regional Policies</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>

<!--====  End of Speakers  ====-->

<!--==========================================
=            Addreass Map Section            =
===========================================-->
<section class="map-section">
	<div class="map-main-container">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8114.622693307916!2d-88.55531822721669!3d44.02237883922294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8803ebe40a08408b%3A0xb8f8ec18c1c8b267!2sUniversity+of+Wisconsin-Oshkosh!5e0!3m2!1sen!2s!4v1511435458598" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		<div class="contact-details">
			<h2>contact</h2>
			<div class="map-address">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				<h6>300 E. Lombard Street, Suite 840 Baltimore, MD 21202 USA</h6>
			</div>
			<div class="map-address">
				<i class="fa fa-phone" aria-hidden="true"></i>
				<h6>877-99-HFUSA (877-994-3872</h6>
			</div>
			<div class="map-address">
				<i class="fa fa-envelope" aria-hidden="true"></i>
				<h6>info@us.humanityfirst.org</h6>
			</div>
		</div>
	</div>	
</section>
<div class="clearfix"></div>

<!--====  End of Addreass Map Section  ====-->


<!--==============================
=            Sponsors            =
===============================-->
<section class="sponsors-section">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<h3><span>trusted hands behind us</span>Our Great Sponsors</h3>
				<p class="text-paragraph text-center heading-text">
					Every human being’s most fundamental right to life is trampled when they do not have access to adequate health care. Humanity First envisions universal health care in all communities. Common diseases, epidemics, and blindness are some health concerns that can be easily prevented and sufficiently contained. 
				</p>
				<div class="sponsors-logos">
					<table class="table">
						<tbody>
							<tr>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/bankfirstnational_nowhite2_jpeg.png" /></td>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/uwo.png" /></td>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/imprint.png" /></td>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/steinert-logo-no-background.png" /></td>
							</tr>
							<tr>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/new-horizons-logo-4c.png" /></td>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/pasted-image-381x135.png" /></td>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_oshkosh_chamber_commerce-color.png" /></td>
								<td><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/oracularuse.png" /></td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="clearfix"></div>
<!--====  End of Sponsors  ====-->

<!--====  end of event detail ====-->


