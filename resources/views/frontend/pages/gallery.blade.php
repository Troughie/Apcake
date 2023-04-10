@extends('layouts.master')
@section('main-content')

<section class="portfolio_area portfolio_full p_100">
	<div class="portfolio_filter">
		<ul class="list_style">
			<li class="active" data-filter="*"><a href="#">All</a></li>
			<li data-filter=".cake"><a href="#">Cakes</a></li>
			<li data-filter=".bakery"><a href="#">cupcake</a></li>
			<li data-filter=".past"><a href="#">donut</a></li>
			<li data-filter=".choco"><a href="#">Macaron</a></li>
			<li data-filter=".bread"><a href="#">birthday cake</a></li>
		</ul>
	</div>
	<div class="portfolio_full_width_area grid_portfolio_area imageGallery1">
		<div class="portfolio_full_item cake choco">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-1.jpg">
						<img class="img-fluid" src="img/portfolio/resize/resie6.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
					<a href="#"><h4>birthday cake</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item bakery">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-2.jpg">
						<img class="img-fluid" src="img/portfolio/resize/resize11.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>birthday cake</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item cake choco">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-3.jpg">
						<img class="img-fluid" src="img/portfolio/resize/resize9.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>birthday cake</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item cake bakery">
			<div class="portfolio_item past">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-4.jpg">
						<img class="img-fluid" src="img/portfolio/resize/resize7.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>birthday cake</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item bakery choco">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-5.jpg">
						<img class="img-fluid" src="img/portfolio/MC.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>Macaron</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item cake past">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-6.jpg">
						<img class="img-fluid" src="img/portfolio/72efa0a0691b6be224cbcd0165764ba2.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>Macaron</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item bakery past">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-7.jpg">
						<img class="img-fluid" src="img/portfolio/MC2.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>Macaron</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item past bread">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-8.jpg">
						<img class="img-fluid" src="img/portfolio/MS.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>moouse</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item past bread">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-9.jpg">
						<img class="img-fluid" src="img/portfolio/MS2.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>moouse</h4></a>
				</div>
			</div>
		</div>
		<div class="portfolio_full_item past bread">
			<div class="portfolio_item">
				<div class="portfolio_img">
					<a class="light" href="img/portfolio/portfolio-3.jpg">
						<img class="img-fluid" src="img/portfolio/SU.png" alt="">
					</a>
				</div>
				<div class="portfolio_text">
					<a href="#"><h4>Su kem</h4></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================End Portfolio Area Area =================-->
<!--================Newsletter Area =================-->
<section class="newsletter_area">
	<div class="container">
		<div class="row newsletter_inner">
			<div class="col-lg-6">
				<div class="news_left_text">
					<h4>Join our Newsletter list to get all the latest offers, discounts and
						other benefits</h4>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="newsletter_form">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Enter your email
							address">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" type="button">Subscribe Now</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection