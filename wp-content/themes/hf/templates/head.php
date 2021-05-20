<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118598702-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-118598702-1');
	</script>

	<?php if (is_page_template('template-telethon.php')) { ?>
		<!-- Facebook Pixel Code -->
		<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window,document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '2167127029985992'); 
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height="1" width="1" 
				src="https://www.facebook.com/tr?id=2167127029985992&ev=PageView
				&noscript=1"/>
			</noscript>
			<!-- End Facebook Pixel Code -->


		<?php } else { ?>
			
			<!-- Facebook Pixel Code -->
			<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
					n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t,s)}(window,document,'script',
						'https://connect.facebook.net/en_US/fbevents.js');
					fbq('init', '779790382451586'); 
					fbq('track', 'PageView');
				</script>
				<noscript>
					<img height="1" width="1" 
					src="https://www.facebook.com/tr?id=779790382451586&ev=PageView
					&noscript=1"/>
				</noscript>
				<!-- End Facebook Pixel Code -->
			<?php } ?>

			<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
			<meta http-equiv="x-ua-compatible" content="ie=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta property="al:ios:app_name" content="HumanityFirst Dev">
			<meta property="al:ios:app_store_id" content="com.oracular.humanityfirst.test">

			<?php wp_head(); ?>
		</head>
