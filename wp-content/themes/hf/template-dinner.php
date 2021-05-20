<?php
/**
* Template Name: Dinner
*/
?>
<!--==================================
=           Dinner Page            =
===================================-->

<section class="dinner-hero-section full-height-fold" id="hero-fold">
	<div class="vid-container">
		<div class="hf-overlay"></div>
		<div class="dinner-navigation">
			<div class="container">
				<div class="row justify-content-center">
					<a class="navbar-brand" href="#"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/telethon-logo.png" /></a>
				</div>


				
				<a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars" aria-hidden="true"></i></a>
				<div class="topnav" id="myTopnav">
					<ul class="navbar-navc mr-auto mt-2 float-left">
						<li class="nav-item active">
							<a class="nav-link" href="#">GALLERY <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">SPONSORS</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">SPEAKERS</a>
						</li>
					</ul>
					<ul class="navbar-navc mr-auto mt-2 mt-md-0 float-right">
						<li class="nav-item active">
							<a class="nav-link" href="#">AGENDA <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">HISTORY</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">STATISTICS</a>
						</li>
					</ul>



				</div>

			</div>
		</div>

		<div class="hero-vid-wrapper">
			<div class="container">
				<div class="row">
					<div class="col vertical-middle">
						<div class="video-main-container">
							<div class="col-lg-6 col-md-6 col-sm-12 float-left">
								<div class="row">
									<iframe style="width: 100%;" height="315" src="https://www.youtube.com/embed/c7CBfid942s" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 float-right">
								<div class="row">
									<div class="th-content">
										<div class="th-heading">
											<h1>dinner</h1>
											<h5>2017</h5>
											<div class="th-text-paragraph">
												<p>Had Replenish, wherein let first after sea make. Darkness blessed years place and place face</p>
											</div>
											<div class="th-buttons">
												<a class="btn btn-primary btn-hollow-y-border">DONATE NOW</a>
												<a class="btn btn-primary btn-hollow-y-border">Be a SPONSOR</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="th-bottom-large-navgation" >
			<div class="container" style="display: none;">
				<ul>
					<li class="pa-sponsor">
						<a href="#!">
							<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/th-participate.png">
							<span class="title-label">participate as</span>
							<span class="title">sponsor</span>
						</a>
					</li>
					<li class="donate-now">
						<a href="#!">
							<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/th-dnow.png">
							<span class="title">Donate now</span>
						</a>
					</li>
					<li class="ja-volunteer">
						<a href="#!">
							<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/th-volunteer.png">
							<span class="title-label">join as</span>
							<span class="title">volunteer</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="donation-target-status">
				<div class="container">
					<div class="row rtl-display align-items-center">
						<div class="col-12 float-left">
							<div class="col-4 float-left">
								<div class="icon-container float-left">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-bullseye.png" alt="" />
								</div>
								<div class="dts-figures float-left">
									<h4>USD<span>400</span>K</h4>
									<h6>target</h6>
								</div>
							</div>
							<div class="col-4 float-left">
								<div class="icon-container float-left">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-donation.png" alt="" />
								</div>
								<div class="dts-figures float-left">
									<h4>USD<span id="figurePlus">100</span>K</h4>
									<h6>COLLECTED</h6>
								</div>
							</div>
							<div class="col-4 float-left">
								<div class="icon-container float-left">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-pledged.png" alt="" />
								</div>
								<div class="dts-figures float-left">
									<h4>USD<span id="figureadd">350</span>K</h4>
									<h6>PLEDGED</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>

	</section>


<!--==================================
=            Map Ssection            =
===================================-->
<section class="t-map-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-12 col-sm-12">
				<div class="interactive-map-container">
					<!-- <img src="<?php // echo get_template_directory_uri(); ?>/assets/images/usmap3d.png" alt="" /> -->
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/usmap3d.png" alt="" usemap="#Map" />
					<map name="Map" id="Map">
						<area alt="" title="Maine" href="#!" shape="poly" coords="748,18,750,21,759,17,764,20,768,33,772,38,775,42,779,43,779,45,769,53,766,51,761,57,759,56,755,63,751,64,748,66,745,67,743,69,741,75,739,75,734,50,737,46,740,40,742,33,741,29" />
						<area alt="" title="New Hampshire" href="#!" shape="poly" coords="730,51,735,70,738,78,735,81,731,82,725,83,720,83,720,79,723,70,722,67,726,61,728,61,727,63,727,57" />
						<area alt="" title="Vermont" href="#!" shape="poly" coords="725,55,724,59,721,61,719,64,719,66,720,69,718,74,717,83,710,84,710,78,708,74,707,71,706,69,708,65,706,58" />
						<area alt="" title="Massachusetts" href="#!" shape="poly" coords="737,81,739,83,736,87,739,88,742,91,746,91,749,88,751,90,744,94,737,95,735,92,733,90,726,92,709,95,710,91,711,87,720,85,728,83,732,83,735,82" />
						<area alt="" title="Rhode Island" href="#!" shape="poly" coords="729,93,732,92,737,97,731,100" />
						<area alt="" title="Connecticut" href="#!" shape="poly" coords="727,95,712,97,710,99,710,103,710,106,709,108,717,104,725,104,728,102" />
						<area alt="" title="New Jersey" href="#!" shape="poly" coords="723,107,717,109,710,111,705,113,703,111,694,109,692,109,690,112,689,114,689,118,694,120,696,124,693,126,687,131,695,138,701,127,702,120,700,118,696,116,701,116,706,115,713,113,721,110" />
						<area alt="" title="Delaware" href="#!" shape="poly" coords="681,137,682,144,687,147,691,147,690,152,687,156,684,159,686,152,683,153,682,150,679,150,678,146,677,141" />
						<area alt="" title="Maryland" href="#!" shape="poly" coords="679,133,680,135,675,136,672,140,672,147,673,152,666,151,667,147,665,142,658,139,655,137,646,139,642,139,635,143,634,139,648,136,650,136,665,134" />
						<area alt="" title="New York" href="#!" shape="poly" coords="703,61,691,62,685,64,678,69,676,73,670,77,672,79,670,84,662,90,655,92,651,90,642,91,638,92,638,96,640,100,629,109,645,106,685,99,691,106,704,110,706,106,707,96,708,88,706,83,707,79,704,77,704,72" />
						<area alt="" title="Pennsylvania" href="#!" shape="poly" coords="688,107,689,109,686,112,686,116,686,119,692,123,686,128,682,128,679,130,622,138,620,113,626,109,629,110,685,101" />
						<area alt="" title="Virginia" href="#!" shape="poly" coords="658,143,661,144,664,147,661,152,665,153,671,156,674,156,676,164,673,168,675,170,680,169,681,171,617,181,587,184,592,180,601,175,607,177,609,176,617,175,618,173,625,170,632,157,636,158,641,152,644,152,650,144,654,145" />
						<area alt="West Virginia" title="" href="#!" shape="poly" coords="653,140,649,140,644,142,640,141,633,147,632,140,621,141,618,131,617,133,618,137,614,145,611,148,607,148,603,154,601,156,594,164,597,170,602,171,605,174,607,174,612,172,614,173,616,169,622,168,630,151,635,154,638,147,642,148" />
						<area alt="" title="Hawaii" href="#!" shape="poly" coords="218,374,225,377,229,385,222,386,217,390,213,389,214,384,213,379" />
						<area alt="" title="Alaska" href="#!" shape="poly" coords="94,290,90,288,85,290,80,288,77,288,74,287,67,287,62,283,59,284,59,281,55,281,54,283,47,283,44,285,34,292,27,293,28,295,30,299,36,306,34,307,34,309,26,309,24,306,17,306,13,308,15,310,14,315,18,315,20,317,22,316,25,317,28,315,31,315,30,317,32,322,24,324,18,325,16,324,6,331,6,337,6,339,8,344,11,343,14,339,16,341,14,344,14,351,21,352,24,354,26,353,29,354,25,360,15,364,10,367,4,369,0,372,6,371,15,370,22,365,29,362,38,358,46,354,42,350,49,347,49,343,57,340,54,350,59,350,64,346,65,349,67,341,71,340,74,345,78,343,79,346,84,347,99,347,100,349,110,354,114,353,117,349,131,362,133,366,135,367,136,365,139,367,139,363,133,359,123,350,117,344,112,346,108,349,104,345,101,342,93,342,91,338" />
						<area alt="" title="North Carolina" href="#!" shape="poly" coords="682,174,683,176,673,180,675,183,680,182,682,185,685,183,677,186,674,187,675,191,672,193,669,194,672,196,677,196,673,199,669,199,663,204,660,208,656,212,648,214,637,202,621,204,615,200,595,202,588,205,568,208,572,204,584,199,589,196,600,192,604,186" />
						<area alt="" title="Florida" href="#!" shape="poly" coords="522,272,521,269,556,263,562,267,592,265,600,268,603,260,609,260,608,266,609,270,609,274,611,277,613,280,615,282,620,286,621,288,624,301,628,306,630,311,629,314,628,320,625,326,622,328,609,318,606,314,604,309,600,308,597,304,596,295,593,297,595,287,587,280,582,275,575,271,565,273,556,278,554,275,551,272,543,270,532,271" />
						<area alt="" title="Alabama" href="#!" shape="poly" coords="549,213,555,243,556,246,553,251,555,257,553,260,520,264,518,269,513,266,509,272,512,253,518,215" />
						<area alt="" title="Tennessee" href="#!" shape="poly" coords="599,185,520,192,518,195,500,197,495,205,490,214,562,208,568,201,574,200,580,198,583,192,596,190" />
						<area alt="" title="Kentucky" href="#!" shape="poly" coords="591,162,588,159,585,161,580,162,577,163,573,161,569,160,567,157,565,158,562,163,557,163,548,172,542,172,540,177,535,174,533,178,526,176,521,177,520,182,516,183,514,187,510,188,508,187,506,188,506,191,512,192,516,191,519,189,534,188,580,184,588,179,597,173,591,168" />
						<area alt="" title="Ohio" href="#!" shape="poly" coords="617,114,607,118,604,121,600,120,595,123,589,123,586,122,581,121,580,119,567,122,565,153,569,154,573,156,576,158,581,158,584,157,588,155,593,159,596,157,597,151,601,151,606,145,610,144,615,136,613,133,617,127" />
						<area alt="" title="Georgia" href="#!" shape="poly" coords="552,212,583,208,582,212,593,222,600,223,602,230,608,231,610,236,612,241,615,244,610,254,608,256,599,257,598,262,593,261,562,262,560,261,557,254,560,249,563,245,556,240" />
						<area alt="" title="South Carolina" href="#!" shape="poly" coords="643,215,631,205,620,208,616,204,609,203,598,204,590,207,583,210,588,214,591,217,595,221,602,223,604,225,604,229,610,233,614,237,614,239,618,240,629,233,641,222,643,219,647,212,642,209,636,206,636,208" />
						<area alt="" title="Indiana" href="#!" shape="poly" coords="560,160,555,160,546,170,542,169,538,173,534,171,531,175,529,174,523,173,529,164,528,158,532,126,540,124,563,122,562,156" />
						<area alt="" title="Michigan" href="#!" shape="poly" coords="582,72,577,71,574,71,571,69,568,68,566,69,563,71,561,73,560,76,558,79,555,80,553,80,546,93,548,103,549,106,546,114,544,118,542,121,575,118,584,114,589,106,592,104,593,96,591,90,586,90,580,94,576,94,575,92,575,89,581,85" />
						<area alt="" title="Mississippi" href="#!" shape="poly" coords="515,215,490,217,485,220,483,224,479,230,475,234,471,237,475,241,473,244,473,236,475,245,476,252,473,256,470,261,464,267,491,266,490,272,492,277,499,274,506,274" />
						<area alt="" title="Louisiana" href="#!" shape="poly" coords="470,244,473,253,469,254,462,266,462,269,486,271,487,274,489,277,483,277,479,276,478,279,480,281,484,280,488,284,494,281,488,286,496,292,493,293,485,287,482,287,480,291,477,290,471,292,467,291,465,288,463,288,460,286,458,284,454,282,453,285,451,288,437,286,427,287,435,269,434,264,430,257,432,246" />
						<area alt="" title="Wisconsin" href="#!" shape="poly" coords="578,61,569,60,564,60,563,56,552,59,546,60,539,61,534,60,530,57,523,58,523,54,530,50,526,50,521,54,516,57,508,59,501,62,497,62,493,62,494,59,487,62,481,62,479,70,476,73,472,74,474,78,472,83,472,86,475,87,477,89,480,89,482,92,486,95,490,100,488,103,489,105,489,108,490,112,495,114,526,113,525,103,529,95,531,91,533,87,534,84,538,79,529,85,525,85,527,82,535,73,539,67,540,65,546,68,550,67,553,66,558,62,567,64,572,63" />
						<area alt="" title="Illinois" href="#!" shape="poly" coords="526,116,527,120,529,123,529,127,525,154,524,158,526,163,519,172,517,178,515,180,512,183,510,183,506,184,503,185,501,180,499,176,493,172,496,167,495,161,493,160,489,161,487,156,480,152,482,145,484,143,488,138,487,134,493,133,496,127,500,123,500,120,496,116" />
						<area alt="" title="Minnesota" href="#!" shape="poly" coords="509,41,501,42,497,41,492,43,488,43,485,42,482,40,480,40,475,37,468,37,464,38,461,36,459,36,456,36,455,34,455,29,453,28,451,31,449,32,431,33,431,35,428,39,427,44,429,47,428,60,430,71,426,77,429,82,426,102,483,101,480,96,478,92,474,92,470,89,467,88,469,77,468,74,469,71,476,67,478,60,483,55,493,48" />
						<area alt="" title="Iowa" href="#!" shape="poly" coords="484,104,424,105,423,107,424,111,421,116,422,120,425,129,425,134,427,138,427,141,475,140,478,142,483,137,482,133,484,130,491,128,495,124,494,120,485,112,486,106" />
						<area alt="" title="Missouri" href="#!" shape="poly" coords="494,201,489,201,492,198,490,195,489,193,432,195,437,168,437,165,433,158,435,153,430,148,428,145,474,144,478,148,478,153,485,159,487,165,492,164,488,172,494,176,499,183,499,186,503,188,504,192,501,194,497,192" />
						<area alt="" title="Arkansas" href="#!" shape="poly" coords="487,196,487,198,483,203,492,203,490,208,487,213,483,217,481,221,479,223,475,225,473,231,470,234,468,234,469,242,432,242,433,237,432,234,428,234,432,212,432,199" />
						<area alt="" title="North Dakota" href="#!" shape="poly" coords="426,33,426,35,425,37,424,45,427,48,425,60,426,66,426,70,342,68,352,31,369,32" />
						<area alt="" title="South Dakota" href="#!" shape="poly" coords="423,75,421,79,426,84,423,104,420,106,419,110,421,111,418,117,412,112,405,114,402,111,398,112,396,108,332,107,341,72" />
						<area alt="" title="Nebraska" href="#!" shape="poly" coords="411,114,406,116,402,114,397,115,395,111,330,109,324,132,348,135,345,147,425,148,422,140,422,135,422,128,418,118" />
						<area alt="" title="Kansas" href="#!" shape="poly" coords="427,151,430,153,428,158,430,161,433,164,429,188,335,188,343,150" />
						<area alt="" title="Oklahoma" href="#!" shape="poly" coords="325,191,430,191,429,198,429,209,427,221,424,232,425,236,419,231,414,233,407,233,400,236,399,231,394,232,389,237,386,229,382,232,377,233,375,227,370,230,362,227,355,227,352,221,357,198,321,196,318,193,319,190" />
						<area alt="" title="Texas" href="#!" shape="poly" coords="318,197,354,200,350,221,353,229,360,230,364,230,369,233,373,232,377,235,385,234,389,241,394,234,396,235,407,236,418,235,426,239,429,239,426,257,432,269,425,286,417,288,414,284,409,287,408,291,403,297,390,302,386,301,384,301,384,304,379,306,377,307,373,308,373,310,368,312,368,315,364,319,365,322,364,325,365,331,368,337,364,338,360,335,342,330,338,322,338,314,334,314,331,307,328,302,324,294,317,286,308,285,305,282,302,285,298,285,287,294,271,284,270,279,271,277,261,265,254,257,251,253,299,257,319,199,300,259" />
						<area alt="" title="Montana" href="#!" shape="poly" coords="221,16,217,27,218,30,219,32,218,36,221,41,223,45,228,48,221,61,225,59,228,61,227,67,229,70,228,72,230,73,231,78,239,76,246,78,250,75,252,77,254,73,335,80,349,30" />
						<area alt="" title="Wyoming" href="#!" shape="poly" coords="335,83,321,133,237,126,256,76" />
						<area alt="" title="Colorado" href="#!" shape="poly" coords="345,137,260,130,242,181,330,190,332,188" />
						<area alt="" title="New Mexico" href="#!" shape="poly" coords="317,191,242,185,215,256,224,257,227,253,248,254,249,251,298,255" />
						<area alt="" title="Idaho" href="#!" shape="poly" coords="218,16,214,27,216,32,213,35,218,41,219,45,224,49,218,62,221,65,225,62,224,67,225,70,224,73,228,75,229,81,239,80,246,81,249,80,251,82,239,113,170,102,180,81,185,75,182,73,185,67,189,67,197,58,197,53,195,50,211,14" />
						<area alt="" title="Utah" href="#!" shape="poly" coords="238,115,204,110,178,173,239,181,257,131,232,127" />
						<area alt="" title="Arizona" href="#!" shape="poly" coords="241,183,212,256,188,255,144,230,147,228,149,226,147,223,147,221,150,220,154,215,158,212,160,207,158,207,157,203,160,198,162,194,161,190,161,187,167,185,166,190,172,188,171,186,175,176,179,175" />
						<area alt="" title="Washington" href="#!" shape="poly" coords="208,14,152,1,154,4,151,7,151,15,144,23,140,24,140,21,143,18,144,13,136,10,127,5,124,7,125,13,126,8,125,16,123,22,126,25,123,26,123,28,120,32,127,35,128,38,131,44,142,44,147,46,172,46,192,50" />
						<area alt="" title="Oregon" href="#!" shape="poly" coords="193,54,194,57,186,65,182,67,179,73,180,76,179,79,167,102,87,85,88,78,88,74,92,73,92,71,99,65,119,34,125,37,125,43,130,47,138,46,147,49,157,49,174,49,187,51" />
						<area alt="" title="Nevada" href="#!" shape="poly" coords="157,198,158,194,159,190,159,184,167,182,169,185,202,110,168,105,134,97,116,136" />
						<area alt="" title="California" href="#!" shape="poly" coords="156,200,155,205,158,210,154,212,152,215,149,218,146,219,145,224,145,226,138,228,113,227,111,223,111,219,108,211,107,209,104,206,102,201,98,202,94,199,89,195,80,193,78,190,81,188,82,178,78,173,76,168,76,162,78,161,78,157,75,155,74,150,77,149,80,148,79,143,77,140,76,142,73,138,74,134,71,130,70,126,72,121,75,116,74,110,75,103,83,95,85,85,132,96,114,136" />
						
					</map>
				</div>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12">
				<div class="t-map-statistics">
					<div class="tms-header">
						<h5>latest donations</h5>
						<h4>$5000</h4>
					</div>
					<div class="tms-body">
						<div class="tms-list-item">
							<div class="flag-container">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/t-c-flag.jpg" alt="">
							</div>
							<div class="country-details">
								<h5>Alissa White</h5>
								<h6><i class="fa fa-clock-o" aria-hidden="true"></i> NOV 11, 2017 | 09:56 PM</h6>
							</div>
							<div class="tms-amount">
								<h6>$300</h6>
							</div>
						</div>
						<div class="tms-list-item">
							<div class="flag-container">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/t-c-flag.jpg" alt="">
							</div>
							<div class="country-details">
								<h5>Alissa White</h5>
								<h6><i class="fa fa-clock-o" aria-hidden="true"></i> NOV 11, 2017 | 09:56 PM</h6>
							</div>
							<div class="tms-amount">
								<h6>$300</h6>
							</div>
						</div>
						<div class="tms-list-item">
							<div class="flag-container">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/t-c-flag.jpg" alt="">
							</div>
							<div class="country-details">
								<h5>Alissa White</h5>
								<h6><i class="fa fa-clock-o" aria-hidden="true"></i> NOV 11, 2017 | 09:56 PM</h6>
							</div>
							<div class="tms-amount">
								<h6>$300</h6>
							</div>
						</div>
						<div class="tms-list-item">
							<div class="flag-container">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/t-c-flag.jpg" alt="">
							</div>
							<div class="country-details">
								<h5>Alissa White</h5>
								<h6><i class="fa fa-clock-o" aria-hidden="true"></i> NOV 11, 2017 | 09:56 PM</h6>
							</div>
							<div class="tms-amount">
								<h6>$300</h6>
							</div>
						</div>
						<div class="tms-list-item">
							<div class="flag-container">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/t-c-flag.jpg" alt="">
							</div>
							<div class="country-details">
								<h5>Alissa White</h5>
								<h6><i class="fa fa-clock-o" aria-hidden="true"></i> NOV 11, 2017 | 09:56 PM</h6>
							</div>
							<div class="tms-amount">
								<h6>$300</h6>
							</div>
						</div>
						<div class="tms-list-item">
							<div class="flag-container">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/t-c-flag.jpg" alt="">
							</div>
							<div class="country-details">
								<h5>Alissa White</h5>
								<h6><i class="fa fa-clock-o" aria-hidden="true"></i> NOV 11, 2017 | 09:56 PM</h6>
							</div>
							<div class="tms-amount">
								<h6>$300</h6>
							</div>
						</div>
						<div class="gray-donate-btn">
							<a href="#!"><i class="fa fa-heart" aria-hidden="true"></i> DONATE NOW</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!--====  End of Map Ssection  ====-->

<!--======================================
=            Schedule Section            =
=======================================-->

<section class="t-schedule-section">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<div class="row justify-content-center">
					<div class="col-12">
						<div class="tab-container">
							

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="country-name-1">
									<div id="accordion" role="tablist" aria-multiselectable="true">
										<ul>
											<li>
												<div class="card">
													<div class="card-header" role="tab" id="headingOne">
														<h5 class="mb-0">
															
															<span class="panel-date">09:00 am - 09:30 am</span>
															<span class="pipe-separator">|</span>
															<span class="schedule-title">Registration</span>
															
														</h5>
													</div>
													<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
														<div class="row justify-content-center">
															<div class="card-block card-block col-lg-6 col-md-12 col-sm-12 ">
																<div class="collapse-content mt-2">

																	<div class="name-title text-center">
																		<h5>Jane Smith</h5>
																		<h6>COO, Apple Inc.</h6>
																	</div>
																	<p>
																		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat numquam, nemo distinctio
																		doloremque cupiditate vel cum. Rem inventore quisquam, nostrum sequi porro, 
																	</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="card">
													<div class="card-header" role="tab" id="headingTwo">
														<h5 class="mb-0">
															
															<span class="panel-date">09:30 am - 09:40 am</span>
															<span class="pipe-separator">|</span>
															<span class="schedule-title">Welcome and Introduction</span>
															
														</h5>
													</div>
												</div>

											</li>
											<li>
												<div class="card">
													<div class="card-header" role="tab" id="headingThree">
														<h5 class="mb-0">
															
															<span class="panel-date">09:40 am - 10:40 am</span>
															<span class="pipe-separator">|</span>
															<span class="schedule-title">Keynote Speaker</span>

														</h5>
													</div>
												</div>

											</li>
											<li>
												<div class="card">
													<div class="card-header" role="tab" id="headingFour">
														<h5 class="mb-0">
															<span class="panel-date">09:40 am - 10:40 am</span>
															<span class="pipe-separator">|</span>
															<span class="schedule-title">Publice Session</span>
														</h5>
													</div>
												</div>


											</li>
											<li>
												<div class="card">
													<div class="card-header" role="tab" id="headingFive">
														<h5 class="mb-0">
															<span class="panel-date">09:40 am - 10:40 am</span>
															<span class="pipe-separator">|</span>
															<span class="schedule-title">Questions & Answer Session</span>
														</h5>
													</div>
												</div>

											</li>
											<li>
												<div class="card">
													<div class="card-header" role="tab" id="headingSix">
														<h5 class="mb-0">
															<span class="panel-date">09:40 am - 10:40 am</span>
															<span class="pipe-separator">|</span>
															<span class="schedule-title">Brunch</span>
														</h5>
													</div>
												</div>

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
	</div>
</section>
<div class="clearfix"></div>

<!--====  End of Schedule Section  ====-->


<!--===============================
=     Donation Target Status      =
================================-->
<div class="donation-target-status" style="display: none;">
	<div class="container">
		<div class="row rtl-display d-flex align-items-center">
			<div class="col-12 float-left">
				<div class="col-lg-4 col-md-2 col-sm-12 float-left">
					<div class="icon-container float-left">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-bullseye.png" alt="" />
					</div>
					<div class="dts-figures float-left">
						<h4>USD<span>400</span>K</h4>
						<h6>target</h6>
					</div>
				</div>
				<div class="col-4 float-left">
					<div class="icon-container float-left">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-donation.png" alt="" />
					</div>
					<div class="dts-figures float-left">
						<h4>USD<span id="figurePlus">100</span>K</h4>
						<h6>COLLECTED</h6>
					</div>
				</div>
				<div class="col-4 float-left">
					<div class="icon-container float-left">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-pledged.png" alt="" />
					</div>
					<div class="dts-figures float-left">
						<h4>USD<span id="figureadd">350</span>K</h4>
						<h6>PLEDGED</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>


<!--====  End of Donation Target Status    ====-->

<!--============================================
=            sponsors and speakers             =
=============================================-->

<section class="t-sponsors-speakers">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<div class="col-lg-6 col-md-12 col-sm-6 float-left">
					<div class="t-sponsors">
						<h1 class="underlined-heading capital">sponsors</h1>
						<div class="sponsors-logos-container">
							<ul>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bmo-harris-bank.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bankfirstnational_nowhite2_jpeg.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/uwo.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/imprint.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/steinert-logo-no-background.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/new-horizons-logo-4c.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/pasted-image-381x135.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_oshkosh_chamber_commerce-color.png" alt="" /></a></li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/images/oracularuse.png" alt="" /></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 float-left">
					<div class="t-speakers">
						<h1 class="gray-simple-heading capital">SPEAKERS</h1>
						<div class="speakers-list-container">
							<ul>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left">
									<a href="#!">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" alt="" />
									</a>
									<div class="clearfix"></div>
									<h5 class="speaker-name">john cornik</h5>
									<h6 class="speaker-designation">senior developer</h6>
									<ul class="slc-social-profiles">
										<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>
									</ul>
								</li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left">
									<a href="#!">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" alt="" />
									</a>
									<div class="clearfix"></div>
									<h5 class="speaker-name">john cornik</h5>
									<h6 class="speaker-designation">senior developer</h6>
									<ul class="slc-social-profiles">
										<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>
									</ul>
								</li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left">
									<a href="#!">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" alt="" />
									</a>
									<div class="clearfix"></div>
									<h5 class="speaker-name">john cornik</h5>
									<h6 class="speaker-designation">senior developer</h6>
									<ul class="slc-social-profiles">
										<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>
									</ul>
								</li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left">
									<a href="#!">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" alt="" />
									</a>
									<div class="clearfix"></div>
									<h5 class="speaker-name">john cornik</h5>
									<h6 class="speaker-designation">senior developer</h6>
									<ul class="slc-social-profiles">
										<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>
									</ul>
								</li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left">
									<a href="#!">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" alt="" />
									</a>
									<div class="clearfix"></div>
									<h5 class="speaker-name">john cornik</h5>
									<h6 class="speaker-designation">senior developer</h6>
									<ul class="slc-social-profiles">
										<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>
									</ul>
								</li>
								<li class="col-lg-4 col-md-4 col-sm-6 float-left">
									<a href="#!">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ed-b-man.jpg" alt="" />
									</a>
									<div class="clearfix"></div>
									<h5 class="speaker-name">john cornik</h5>
									<h6 class="speaker-designation">senior developer</h6>
									<ul class="slc-social-profiles">
										<li><a href="#!"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#!"><i><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>

<!--====  End of sponsors and speakers   ====-->

<!--=====================================
=            gallery section            =
======================================-->
<section class="t-light-box-gallery">
	<div class="pd-light-box">
		<ul>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
			<li><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/t-lb-image.jpg"><a href="#!" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>
		</ul>
	</div>
</section>
<div class="clearfix"></div>

<!--====  End of gallery section  ====-->


<!--================================
=            Newsletter            =
=================================-->
<section class="t-newsletter">
	<div class="hf-overlay"></div>
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<div class="row justify-content-center">
					<div class="col-lg-10 col-sm-12 col-md-10">
						<h3>SUBSCRIBE OUR NEWSLETTER</h3>
						<p class="th-text-paragraph-white">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat
							volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper.
						</p>
						<div class="row justify-content-center">
							<div class="col-10">
								<div class="t-newsletter-form">
									<form action=""><input type="text" placeholder="Your Email Address"><button>SUBSCRIBE</button></form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<!--====  End of Newsletter  ====-->


<!--============================
=            Footer            =
=============================-->
<section class="dinner-footer">
	<div class="tfooter-logo">
		<a href="#"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-gray-logo.png" /></a>
	</div>
	<div class="tf-social-icons">
		<ul>
			<li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
			<li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			<li><a href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
			<li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
		</ul>
	</div>
	<p class="text-paragraph text-center">Copyright 2017 Humanity First USA - All rights reserved. </p>
</section>


<!--====  End of Footer  ====-->



<!--====  End of dinner Page  ====-->


<button id="open_message" class="open-message"><i class="fa fa-comments-o" aria-hidden="true"></i> message</button>
<div id="chat_main_box" class="chat-main-container" style="display:none;">
	<a href="#!" id="close-chat"><i class="fa fa-times" aria-hidden="true"></i></a> 
	<div class="chat-container">


		<div class="chat">


			<div class="chat-history">
				<ul>
					<li class="clearfix">
						<div class="message-data align-right">
							<span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;
							<span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>

						</div>
						<div class="message other-message float-right">
							Hi Vincent, how are you? How is the project coming along?
						</div>
					</li>

					<li>
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
							<span class="message-data-time">10:12 AM, Today</span>
						</div>
						<div class="message my-message">
							Are we meeting today? Project has been already finished and I have results to show you.
						</div>
					</li>

					<li class="clearfix">
						<div class="message-data align-right">
							<span class="message-data-time" >10:14 AM, Today</span> &nbsp; &nbsp;
							<span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>

						</div>
						<div class="message other-message float-right">
							Well I am not sure. The rest of the team is not here yet. Maybe in an hour or so? Have you faced any problems at the last phase of the project?
						</div>
					</li>

					<li>
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
							<span class="message-data-time">10:20 AM, Today</span>
						</div>
						<div class="message my-message">
							Actually everything was fine. I'm very excited to show this to our team.
						</div>
					</li>

					<li>
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
							<span class="message-data-time">10:31 AM, Today</span>
						</div>
						<i class="fa fa-circle online"></i>
						<i class="fa fa-circle online" style="color: #AED2A6"></i>
						<i class="fa fa-circle online" style="color:#DAE9DA"></i>
					</li>

				</ul>

			</div> <!-- end chat-history -->

			<div class="chat-message clearfix">
				<textarea name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>
				<button>Send</button>

			</div> <!-- end chat-message -->

		</div> <!-- end chat -->

	</div>
</div>


<script type="text/javascript">
	function myFunction() {
		var x = document.getElementById("myTopnav");
		if (x.className === "topnav") {
			x.className += " responsive";
		} else {
			x.className = "topnav";
		}
	}
</script>
