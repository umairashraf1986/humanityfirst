<?php use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Google Places Search
*/

$stylesheetDirectory = get_stylesheet_directory_uri();
?>
<style type="text/css">
	body {
		position: relative;
	}
	section.search-wrapper {
		padding: 30px 0 0;
	}
	section.places-wrapper {
		padding: 0 0 30px;
	}
	article.place-wrapper {
		border: 1px solid #ccc;
		padding: 10px;
		clear: both;
		overflow: hidden;
		border-bottom: none;
		cursor: pointer;
		max-width: 600px;
		margin: 0 auto;
		text-align: left;
	}
	article.place-wrapper:last-child {
		border-bottom: 1px solid #ccc;
	}
	article.place-wrapper:hover {
		background-color: #efefef;
	}
	.info-wrapper {
		float: left;
		width: calc(100% - 150px);
	}
	.name {
		font-size: 22px;
		margin-bottom: 5px;
	}
	.rating {
		margin-bottom: 5px;
	}
	.image {
		float: right;
	}
	.image img {
		width: 100px;
		height: 100px;
		object-fit: cover;
	}
	.overlay {
		position: fixed;
		width: 100vw;
		height: 100vh;
		top: 0;
		left: 0;
		z-index: 99999;
		background: white;
		opacity: 0.4;
		display: none;
	}
	span.stars {
		margin-left: 5px;
	}
	span.stars .fa {
		color: #fbbc04;
	}
</style>

<!--===================================
=            Title Section            =
====================================-->

<section class="inner-page-title-section event-detail-page" <?php echo hf_header_bg_img(); ?>>

	<div class="iptc-content">
		<h1><?= Titles\title(); ?></h1>
		<?php bootstrap_breadcrumb(); ?>
	</div>

	<div class="overlay"></div>
</section>
<div class="clearfix"></div>

<!--====  End of Title Section  ====-->

<!--=========================================
=            Search Form Section            =
==========================================-->

<div class="overlay"></div>
<section class="search-wrapper">
	<div class="container">
		<?php
		$intro = rwmb_meta('hfusa-intro_page');
		if(!empty($intro)) {
		?>
		<div class="row">
			<div class="col-12">
				<div class="intro"><?php echo $intro; ?></div>
			</div>
		</div>
		<?php } ?>
		<div class="row">
			<div class="col-12">
				<form>
					<div class="form-row">
						<div class="form-group col-md-5">
							<input type="text" class="form-control" id="searchPlace" value="<?php echo rwmb_meta('hfusa-search_item'); ?>" <?php echo (rwmb_meta('hfusa-search_item_property')) ? 'disabled' : ''; ?>>
						</div>
						<div class="form-group col-md-2">
							<select id="searchType" class="form-control">
								<option value="" selected>Choose...</option>
								<?php
								$options = rwmb_meta('search_options');
								foreach ($options as $option) {
									echo "<option value='".$option['hfusa-search_option']."'>".$option['hfusa-search_option']."</option>";
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-5">
							<input type="text" class="form-control" id="searchText" placeholder="Search...">
						</div>
					</div>
					<div class="form-row">
						<?php
						$returnLabel = rwmb_meta('hfusa-return_button_label');
						$returnURL = rwmb_meta('hfusa-return_button_url');
						if(!empty($returnLabel) && !empty($returnURL)) {
						?>
						<div class="form-group col-12 col-md-4 order-md-1 order-3">
							<a href="<?php echo $returnURL; ?>" class="btn btn-primary btn-block"><?php echo $returnLabel; ?></a>	
						</div>
						<?php } ?>
						<div class="form-group col-12 <?php echo (!empty($returnLabel) && !empty($returnURL)) ? 'col-md-4' : 'col-md-8'; ?> order-md-2 order-1">
							<button type="submit" class="btn btn-primary btn-block" id="searchBtn">Search</button>	
						</div>
						<div class="form-group col-12 col-md-4  order-md-3 order-2">
							<button class="btn btn-primary btn-block" id="cancelBtn" disabled>Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<div class="container">
	<div class="row">
		<div class="col-12"><hr></div>
	</div>
</div>

<!--====  End of Search Form Section  ====-->

<!--===========================================
=            Seach Results Section            =
============================================-->

<section class='places-wrapper'>
	<div class="container">
		<div class="row">
			<div class="col col-12 text-center">
				<div class="searchMessage"><em>Search results appear here</em></div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Seach Results Section  ====-->

<div class="text-center">
	<img src="<?php echo $stylesheetDirectory; ?>/assets/images/100px(blue).gif" style="display: none; margin-bottom: 20px;" id="loader">
</div>

