		<!-- Top Bar
		============================================= -->
		<div id="top-bar">
			<div class="container">

				<div class="row justify-content-between">
					<div class="col-12 col-md-auto">

						<!-- Top Links
						============================================= -->
						<div class="top-links on-click">
							<ul class="top-links-container">
                                @if (Route::has('login'))
                                    @auth
                                    <li class="top-links-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>   
                                        |
                                    <li class="top-links-item"><a href="{{ route('logout') }}">Log Out</a></li>                     
                                    @else
                                    <li class="top-links-item"><a href="{{ route('login') }}">Log in</a></li>
                                        | 
                                        @if (Route::has('register'))
                                        <li class="top-links-item"><a href="{{ route('register') }}">Register</a></li>
                                        @endif
                                    @endauth
                            @endif



							</ul>
						</div><!-- .top-links end -->

					</div>

					<div class="col-12 col-md-auto">

						<!-- Top Social
						============================================= -->
						<ul id="top-social">
							<li><a href="#" class="h-bg-facebook"><span class="ts-icon"><i class="fa-brands fa-facebook-f"></i></span><span class="ts-text">Facebook</span></a></li>
							<li><a href="#" class="h-bg-x-twitter"><span class="ts-icon"><i class="fa-brands fa-x-twitter"></i></span><span class="ts-text">Twitter</span></a></li>
							<li><a href="tel:+1.11.85412542" class="h-bg-call"><span class="ts-icon"><i class="fa-solid fa-phone"></i></span><span class="ts-text">+1.11.85412542</span></a></li>
							<li><a href="mailto:info@canvas.com" class="h-bg-email3"><span class="ts-icon"><i class="fa-solid fa-envelope"></i></span><span class="ts-text">info@canvas.com</span></a></li>
						</ul><!-- #top-social end -->

					</div>

				</div>

			</div>
		</div><!-- #top-bar end -->

		<!-- Header
		============================================= -->
		<header id="header" class="header-size-sm" data-sticky-shrink="false">
			<div class="container">
				<div class="header-row flex-column flex-lg-row justify-content-center justify-content-lg-start">

					<!-- Logo
					============================================= -->
					<div id="logo" class="me-0 me-lg-auto">
						<a href="index.html">
							<img class="logo-default" srcset="images/logo.png, images/logo@2x.png 2x" src="images/logo@2x.png" alt="Canvas Logo">
							<img class="logo-dark" srcset="images/logo-dark.png, images/logo-dark@2x.png 2x" src="images/logo-dark@2x.png" alt="Canvas Logo">
						</a>
					</div><!-- #logo end -->

					<div class="header-misc mb-4 mb-lg-0 d-none d-lg-flex">

						<div class="top-advert">
							<img src="images/magazine/ad.jpg" alt="Ad">
						</div>

					</div>

				</div>
			</div>

			<div id="header-wrap" class="border-top border-f5">
				<div class="container">
					<div class="header-row justify-content-between">

						<div class="header-misc">

							<!-- Top Search
							============================================= -->
							<div id="top-search" class="header-misc-icon">
								<a href="#" id="top-search-trigger"><i class="uil uil-search"></i><i class="bi-x-lg"></i></a>
							</div><!-- #top-search end -->

						</div>

						<div class="primary-menu-trigger">
							<button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
								<span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
							</button>
						</div>

						<!-- Primary Navigation
						============================================= -->
						<nav class="primary-menu">

							<ul class="menu-container">
								<li class="menu-item">
									<a class="menu-link" href="index.html"><div>Home</div></a>
								</li>
                                <li class="menu-item">
									<a class="menu-link" href="index.html"><div>Current issue</div></a>
								</li>
								<li class="menu-item">
									<a class="menu-link" href="#"><div>Archive</div></a>
									<ul class="sub-menu-container">
										<li class="menu-item">
											<a class="menu-link" href="#"><div><i class="bi-hypnotize"></i>Isue 1</div></a>
										</li>
                                        <li class="menu-item">
											<a class="menu-link" href="#"><div><i class="bi-hypnotize"></i>Isue 2</div></a>
										</li>
									</ul>
								</li>
                                <li class="menu-item">
									<a class="menu-link" href="index.html"><div>Jornal info</div></a>
								</li>
                                <li class="menu-item">
									<a class="menu-link" href="index.html"><div>Editorial and peer review proces</div></a>
								</li>
                                <li class="menu-item">
									<a class="menu-link" href="index.html"><div>Editorial board</div></a>
								</li>
                                <li class="menu-item">
									<a class="menu-link" href="#"><div>Submit</div></a>
									<ul class="sub-menu-container">
										<li class="menu-item">
											<a class="menu-link" href="#"><div><i class="bi-hypnotize"></i>Submission guidance</div></a>
										</li>
                                        <li class="menu-item">
											<a class="menu-link" href="#"><div><i class="bi-hypnotize"></i>Tehnical publishing practice</div></a>
										</li>
									</ul>
								</li>
							</ul>

						</nav><!-- #primary-menu end -->

						<form class="top-search-form" action="search.html" method="get">
							<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
						</form>

					</div>

				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->