<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<meta name="author" content="Taner Ahmed">
	<meta name="description" content="Medical Journal.">

	<!-- Font Imports -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet">

	<!-- Core Style -->
	<link rel="stylesheet" href="{{asset('../assets/css/style.css') }}">

	<!-- Font Icons -->
	<link rel="stylesheet" href=" {{asset('../assets/css/css/font-icons.css') }}">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{asset('../assets/css/css/customs.css') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Document Title
	============================================= -->
	<title>Medical Journal</title>

	<style>
	.device-down-md .oc-item {
		height: 60vh;
	}
	</style>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper">

        <!-- Header -->
        @include('canva.header')
        <!-- Header END -->

		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap">
                {{-- Slider --}}
				<div id="oc-images" class="owl-carousel owl-carousel-full news-carousel header-stick mb-6 carousel-widget" data-margin="3" data-loop="true" data-stage-padding="50" data-pagi="false" data-items-xs="1" data-items-lg="2">

					<div class="oc-item">
						<img src="images/magazine/carousel/1.jpg" alt="Image 1" class="d-block w-100 h-100 object-cover">
						<div class="bg-overlay">
							<div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start p-4">
								<div>
									<span class="badge bg-danger">World</span>
									<div class="portfolio-desc px-0">
										<h3>CJI defends collegium system, says don't defame judiciary</h3>
										<span>14th Sep 2021</span>
									</div>
									<a href="#" class="btn btn-sm btn-outline-light mx-0 mb-2">Read Story</a>
								</div>
							</div>
							<div class="rounded-skill d-none d-sm-block" data-color="#e74c3c" data-trackcolor="rgba(255,255,255,0.4)" data-size="80" data-percent="75" data-width="3" data-animate="3000">7.5</div>
						</div>
					</div>
					<div class="oc-item">
						<img src="images/magazine/carousel/4.jpg" alt="Image 2" class="d-block w-100 h-100 object-cover">
						<div class="bg-overlay">
							<div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start p-4">
								<div>
									<span class="badge bg-danger">World</span>
									<div class="portfolio-desc px-0">
										<h3>Nutrition pursue these aspirations network respect focus</h3>
										<span>21st Aug 2021</span>
									</div>
									<a href="#" class="btn btn-sm btn-outline-light mx-0 mb-2">Read Story</a>
								</div>
							</div>
							<div class="rounded-skill d-none d-sm-block" data-color="#e74c3c" data-trackcolor="rgba(255,255,255,0.4)" data-size="80" data-percent="50" data-width="3" data-animate="3000">5.0</div>
						</div>
					</div>
					<div class="oc-item">
						<img src="images/magazine/carousel/6.jpg" alt="Image 3" class="d-block w-100 h-100 object-cover">
						<div class="bg-overlay">
							<div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start p-4">
								<div>
									<span class="badge bg-danger">World</span>
									<div class="portfolio-desc px-0">
										<h3>Political, vulnerable citizens eradicate philanthropy</h3>
										<span>8th Nov 2021</span>
									</div>
									<a href="#" class="btn btn-sm btn-outline-light mx-0 mb-2">Read Story</a>
								</div>
							</div>
							<div class="rounded-skill d-none d-sm-block" data-color="#e74c3c" data-trackcolor="rgba(255,255,255,0.4)" data-size="80" data-percent="60" data-width="3" data-animate="3000">6.0</div>
						</div>
					</div>
					<div class="oc-item">
						<img src="images/magazine/carousel/11.jpg" alt="Image 4" class="d-block w-100 h-100 object-cover">
						<div class="bg-overlay">
							<div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start p-4">
								<div>
									<span class="badge bg-danger">World</span>
									<div class="portfolio-desc px-0">
										<h3>Revitalize Bloomberg accelerate human potential</h3>
										<span>30th Jan 2021</span>
									</div>
									<a href="#" class="btn btn-sm btn-outline-light mx-0 mb-2">Read Story</a>
								</div>
							</div>
							<div class="rounded-skill d-none d-sm-block" data-color="#e74c3c" data-trackcolor="rgba(255,255,255,0.4)" data-size="80" data-percent="80" data-width="3" data-animate="3000">8.0</div>
						</div>
					</div>
					<div class="oc-item">
						<img src="images/magazine/carousel/13.jpg" alt="Image 5" class="d-block w-100 h-100 object-cover">
						<div class="bg-overlay">
							<div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start p-4">
								<div>
									<span class="badge bg-danger">World</span>
									<div class="portfolio-desc px-0">
										<h3>Momentum tackling cross-agency coordination volunteer revitalize</h3>
										<span>11th Feb 2021</span>
									</div>
									<a href="#" class="btn btn-sm btn-outline-light mx-0 mb-2">Read Story</a>
								</div>
							</div>
							<div class="rounded-skill d-none d-sm-block" data-color="#e74c3c" data-trackcolor="rgba(255,255,255,0.4)" data-size="80" data-percent="40" data-width="3" data-animate="3000">4.0</div>
						</div>
					</div>
					<div class="oc-item">
						<img src="images/magazine/carousel/14.jpg" alt="Image 6" class="d-block w-100 h-100 object-cover">
						<div class="bg-overlay">
							<div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start p-4">
								<div>
									<span class="badge bg-danger">World</span>
									<div class="portfolio-desc px-0">
										<h3>Social responsibility Aga Khan health institutions</h3>
										<span>27th Mar 2021</span>
									</div>
									<a href="#" class="btn btn-sm btn-outline-light mx-0 mb-2">Read Story</a>
								</div>
							</div>
							<div class="rounded-skill d-none d-sm-block" data-color="#e74c3c" data-trackcolor="rgba(255,255,255,0.4)" data-size="80" data-percent="62" data-width="3" data-animate="3000">6.2</div>
						</div>
					</div>

				</div>
                {{-- Slider  END--}}
				<div class="container">

					<div class="mb-6">
						<img src="images/magazine/ad.jpg" alt="Ad" class="aligncenter my-0">
					</div>

					<div class="fancy-title title-border">
						<h3>Technology</h3>
					</div>

					<div class="row col-mb-50 mb-0">
						<div class="col-lg-8">

							<div class="posts-md">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/7.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-sm">
										<h3><a href="blog-single.html">Toyota's next minivan will let you shout at your kids without turning around</a></h3>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 17th Jan 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 31</a></li>
											<li><a href="#"><i class="uil uil-camera"></i></a></li>
										</ul>
									</div>
									<div class="entry-content">
										<p class="mb-0">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, repudiandae.</p>
									</div>
								</div>
							</div>

						</div>

						<div class="col-lg-4">

							<div class="posts-sm row col-mb-30">
								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/1.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">UK government weighs Tesla's Model S for its 5 million electric vehicle fleet</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 1st Aug 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 32</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/2.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">MIT's new robot glove can give you extra fingers</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 13th Sep 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 11</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/3.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">You can now listen to headphones through your hoodie</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 27th July 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 13</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/4.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">How would you change Kobo's Aura HD e-reader?</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 31st Jan 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 7</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/5.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Combat malaria solve, disruption advancement socio-economic</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 22nd Jan 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 55</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/6.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Interconnectivity raise awareness fighting</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 15th Feb 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 55</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

					<div class="fancy-title title-border">
						<h3>Entertainment</h3>
					</div>

					<div class="row col-mb-50 mb-0">

						<div class="col-lg-8">

							<div class="posts-md">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/13.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-sm">
										<h3><a href="blog-single.html">Effectiveness emergent catalyst combat malaria positive social change</a></h3>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 10th Feb 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 22</a></li>
											<li><a href="#"><i class="uil uil-camera"></i></a></li>
										</ul>
									</div>
									<div class="entry-content">
										<p class="mb-0">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, repudiandae.</p>
									</div>
								</div>
							</div>

						</div>

						<div class="col-lg-4">

							<div class="posts-sm row col-mb-30">
								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/1.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">UK government weighs Tesla's Model S for its 5 million electric vehicle fleet</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 1st Aug 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 32</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/2.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">MIT's new robot glove can give you extra fingers</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 13th Sep 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 11</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/3.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">You can now listen to headphones through your hoodie</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 27th July 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 13</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/4.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">How would you change Kobo's Aura HD e-reader?</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 31st Jan 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 7</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/5.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Combat malaria solve, disruption advancement socio-economic</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 22nd Jan 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 55</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/6.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Interconnectivity raise awareness fighting</a></h4>
											</div>
											<div class="entry-meta">
												<ul>
													<li><i class="uil uil-schedule"></i> 15th Feb 2021</li>
													<li><a href="#"><i class="uil uil-comments-alt"></i> 55</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

					<div class="fancy-title title-border title-center">
						<h3>Featured Video</h3>
					</div>

					<iframe src="https://player.vimeo.com/video/99895335" width="500" height="281" allow="autoplay; fullscreen" allowfullscreen></iframe>

				</div>

				<div class="section dark">

					<div class="container">

						<h3 class="text-center">Featured News</h3>

						<div id="oc-images2" class="owl-carousel image-carousel carousel-widget posts-md" data-margin="20" data-pagi="false" data-rewind="true" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" data-items-xl="5">

							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/1.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">A Baseball Team Blew Up A Bunch Of Justin Bieber And Miley Cyrus Merch</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 17th Feb 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 32</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/2.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">UK government weighs Tesla's Model S for its ??5 million electric vehicle fleet</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 1st Apr 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 21</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/3.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">MIT's new robot glove can give you extra fingers</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 21th Apr 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 30</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/4.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">Yen dips on modest reduction in risk aversion, markets still wary</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 2nd Jun 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 61</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/5.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">Beyonce Dropped A '50 Shades Of Grey', Teaser On Instagram Last Night</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 10th Sep 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 49</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/6.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">Want To Know The New 'Star Wars' Plot? Then This Is The Post For You</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 12th Mar 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 74</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/7.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">Toyotas next minivan will let you shout at your kids without turning around</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 23rd Aug 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 06</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="oc-item">
								<div class="entry">
									<div class="entry-image">
										<a href="#"><img src="images/magazine/thumb/8.jpg" alt="Image"></a>
									</div>
									<div class="entry-title title-xs text-transform-none">
										<h4><a href="blog-single.html">You can now listen to headphones through your hoodie</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="uil uil-schedule"></i> 26th Nov 2021</li>
											<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 13</a></li>
										</ul>
									</div>
								</div>
							</div>

						</div>


					</div>

				</div>

				<div class="container">

					<div class="row col-mb-50">
						<div class="col-12">

							<div class="fancy-title title-border title-center">
								<h3>Other News</h3>
							</div>

							<div class="row posts-md col-mb-30">
								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/11.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">Toyotas next minivan will let you shout at your kids without turning around</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 10th Nov 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 15</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Neque nesciunt molestias soluta esse debitis. Magni impedit quae consectetur consequuntur.</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/14.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">UK government weighs Tesla's Model S for its ??5 million electric vehicle fleet</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 13th Nov 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 25</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Eaque iusto quod assumenda beatae, nesciunt aliquid. Vel, eos eligendi?</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/15.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">Combat malaria positive social change civil society. Fundraise inspire.</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 19th Dec 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 19</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Combat malaria positive social change civil society fundraise inspire.</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/13.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">MIT's new robot glove can give you extra fingers</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 22nd Jan 2013</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 14</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Magni impedit quae consectetur consequuntur adipisci veritatis modi a, officia cum.</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/3.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">Beyonce Dropped A '50 Shades Of Grey', Teaser On Instagram Last Night</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 19th Apr 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 55</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Neque nesciunt molestias soluta esse debitis. Magni impedit quae consectetur consequuntur.</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/4.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">A Baseball Team Blew Up A Bunch Of Justin Bieber And Miley Cyrus Merch</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 26th Apr 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 41</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Eaque iusto quod assumenda beatae, nesciunt aliquid. Vel, eos eligendi emo perferendis dolorem voluptatem.</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/7.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">Cross-agency coordination meaningful work inclusive community maximize.</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 31st Mar 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 43</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Eaque iusto quod assumenda beatae, nesciunt aliquid. Vel, eos eligendi emo perferendis dolorem voluptatem.</p>
										</div>
									</div>
								</div>

								<div class="entry col-sm-6 col-lg-3">
									<div class="grid-inner">
										<div class="entry-image">
											<a href="#"><img src="images/magazine/thumb/5.jpg" alt="Image"></a>
										</div>
										<div class="entry-title title-xs text-transform-none">
											<h3><a href="blog-single.html">Want To Know The New 'Star Wars' Plot? Then This Is The Post For You</a></h3>
										</div>
										<div class="entry-meta">
											<ul>
												<li><i class="uil uil-schedule"></i> 10th Feb 2021</li>
												<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 21</a></li>
											</ul>
										</div>
										<div class="entry-content">
											<p>Magni impedit quae consectetur consequuntur adipisci veritatis modi a, officia cum.</p>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="col-12">
							<img src="images/magazine/ad.jpg" alt="Ad" class="aligncenter">
						</div>

						<div class="col-md-6 col-lg-4">

							<div class="fancy-title title-border">
								<h4>Recent Movies</h4>
							</div>

							<div class="posts-sm row col-mb-30">
								<div class="entry col-12">
									<div class="grid-inner row align-items-center g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/movie/3.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">The Purge: Anarchy</a></h4>
											</div>
											<div class="entry-meta no-separator">
												<ul>
													<li class="color"><i class="bi-star-fill"></i><i class="bi-star-fill"></i><i class="bi-star-half"></i><i class="bi-star"></i><i class="bi-star"></i></li>
													<li><i class="bi-heart-fill text-warning"></i> 54%</li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row align-items-center g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/movie/4.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Planes: Fire And Rescue</a></h4>
											</div>
											<div class="entry-meta no-separator">
												<ul>
													<li class="color"><i class="bi-star-fill"></i><i class="bi-star-fill"></i><i class="bi-star"></i><i class="bi-star"></i><i class="bi-star"></i></li>
													<li><i class="bi-heart-fill text-warning"></i> 45%</li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row align-items-center g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/movie/5.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Sex Tape</a></h4>
											</div>
											<div class="entry-meta no-separator">
												<ul>
													<li class="color"><i class="bi-star-fill"></i><i class="bi-star-half"></i><i class="bi-star"></i><i class="bi-star"></i><i class="bi-star"></i></li>
													<li><i class="bi-heart-fill text-default"></i> 20%</li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row align-items-center g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/movie/6.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">Transformers: Age of Extinction</a></h4>
											</div>
											<div class="entry-meta no-separator">
												<ul>
													<li class="color"><i class="bi-star-fill"></i><i class="bi-star"></i><i class="bi-star"></i><i class="bi-star"></i><i class="bi-star"></i></li>
													<li><i class="bi-heart-fill text-default"></i> 17%</li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="entry col-12">
									<div class="grid-inner row align-items-center g-0">
										<div class="col-auto">
											<div class="entry-image">
												<a href="#"><img src="images/magazine/small/movie/7.jpg" alt="Image"></a>
											</div>
										</div>
										<div class="col ps-3">
											<div class="entry-title">
												<h4><a href="#">How to Train Your Dragon 2</a></h4>
											</div>
											<div class="entry-meta no-separator">
												<ul>
													<li class="color"><i class="bi-star-fill"></i><i class="bi-star-fill"></i><i class="bi-star-fill"></i><i class="bi-star-fill"></i><i class="bi-star"></i></li>
													<li><i class="bi-heart-fill text-danger"></i> 90%</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="col-md-6 col-lg-4">

							<div class="fancy-title title-border">
								<h4>Musics Review</h4>
							</div>

							<div class="posts-sm row col-mb-30">
								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Thomas Jack Presents: Tropical House Vol.5</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-heart-fill text-danger"></i> 92%</li>
											<li>Thomas Jack</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Major Lazer's Walshy Fire Presents: Jesse Royal - Royally Speaking</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-heart-fill text-warning"></i> 54%</li>
											<li>Major Lazer</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">The Weeknd - King Of The Fall</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-heart-fill text-success"></i> 78%</li>
											<li>The Weeknd-XO</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">No Flex Zone Remix Feat. Nicki Minaj</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-heart-fill text-warning"></i> 45%</li>
											<li>Nicki Minaj</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Mike Mago &amp; Dragonette - Outlines</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-heart-fill text-primary"></i> 65%</li>
											<li>Mike Mago</li>
										</ul>
									</div>
								</div>
							</div>

						</div>

						<div class="col-lg-4">

							<div class="fancy-title title-border">
								<h4>Opinion Polls</h4>
							</div>

							<div class="posts-sm row col-mb-30">
								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Who do you think is responsible for shooting down Malaysia Airlines flight MH17?</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><span class="text-success">Ukraine:</span> 77%</li>
											<li><span class="text-danger">Rebels:</span> 23%</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Maradona says Messi didn't deserve Golden Ball?</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-hand-thumbs-up text-success"></i> 54%</li>
											<li><i class="bi-hand-thumbs-down text-danger"></i> 46%</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Palestinian president says Israel is carrying out a genocide in Gaza?</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-hand-thumbs-up text-success"></i> 80%</li>
											<li><i class="bi-hand-thumbs-down text-danger"></i> 20%</li>
										</ul>
									</div>
								</div>

								<div class="entry col-12">
									<div class="entry-title">
										<h4><a href="#">Can Brazil progress in the World Cup without Neymar?</a></h4>
									</div>
									<div class="entry-meta">
										<ul>
											<li><i class="bi-hand-thumbs-up text-success"></i> 55%</li>
											<li><i class="bi-hand-thumbs-down text-danger"></i> 45%</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</section><!-- #content end -->

        <!-- Footer -->
        @include('canva.footer')
        <!-- Footer END -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="uil uil-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="{{ asset('../assets/js/js/plugins.min.js') }}"></script>
	<script src="{{ asset('../assets/js/js/functions.bundle.js') }}"></script>

</body>
</html>