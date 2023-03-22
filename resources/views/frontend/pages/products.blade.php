@extends('layouts.master')
@section('main-content')



<section class="product_details_area p_100">
	<div class="container">
		<div class="row product_d_price">
			<div class="col-lg-6">
				<div class="product_img"><img class="img-fluid" src="img/product/product-details-1.jpg" alt=""></div>
			</div>
			<div class="col-lg-6">
				<div class="product_details_text">
					<h4>Brown Cake</h4>
					<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequ untur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, </p>
					<h5>Price :<span>$24.5</span></h5>
					<div class="quantity_box">
						<label for="quantity">Quantity :</label>
						<input type="text" placeholder="1" id="quantity">
					</div>
					<a class="pink_more" href="#">Add to Cart</a>
				</div>
			</div>
		</div>
		<div class="product_tab_area">
			  <nav>
				  <div class="nav nav-tabs" id="nav-tab" role="tablist">
					  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Descripton</a>
					  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Specification</a>
					  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Review (0)</a>
				  </div>
			  </nav>
			  <div class="tab-content" id="nav-tabContent">
				  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
					  <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
				  </div>
				  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
					  <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
				  </div>
				  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
					  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
					  <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
				  </div>
			  </div>
		</div>
	</div>
</section>
<!--================End Product Details Area =================-->

<!--================Similar Product Area =================-->
<section class="similar_product_area p_100">
	<div class="container">
		<div class="main_title">
			<h2>Similar Products</h2>
		</div>
		<div class="row similar_product_inner">
			<div class="col-lg-3 col-md-4 col-6">
				<div class="cake_feature_item">
					  <div class="cake_img">
						  <img src="img/cake-feature/c-feature-1.jpg" alt="">
					  </div>
					  <div class="cake_text">
						  <h4>$29</h4>
						  <h3>Strawberry Cupcakes</h3>
						  <a class="pest_btn" href="#">Add to cart</a>
					  </div>
				  </div>
			</div>
			<div class="col-lg-3 col-md-4 col-6">
				<div class="cake_feature_item">
					  <div class="cake_img">
						  <img src="img/cake-feature/c-feature-2.jpg" alt="">
					  </div>
					  <div class="cake_text">
						  <h4>$29</h4>
						  <h3>Strawberry Cupcakes</h3>
						  <a class="pest_btn" href="#">Add to cart</a>
					  </div>
				  </div>
			</div>
			<div class="col-lg-3 col-md-4 col-6">
				<div class="cake_feature_item">
					  <div class="cake_img">
						  <img src="img/cake-feature/c-feature-3.jpg" alt="">
					  </div>
					  <div class="cake_text">
						  <h4>$29</h4>
						  <h3>Strawberry Cupcakes</h3>
						  <a class="pest_btn" href="#">Add to cart</a>
					  </div>
				  </div>
			</div>
			<div class="col-lg-3 col-md-4 col-6">
				<div class="cake_feature_item">
					  <div class="cake_img">
						  <img src="img/cake-feature/c-feature-4.jpg" alt="">
					  </div>
					  <div class="cake_text">
						  <h4>$29</h4>
						  <h3>Strawberry Cupcakes</h3>
						  <a class="pest_btn" href="#">Add to cart</a>
					  </div>
				  </div>
			</div>
		</div>
	</div>
</section>
<!--================End Similar Product Area =================-->

<!--================Newsletter Area =================-->
<section class="newsletter_area">
	<div class="container">
		<div class="row newsletter_inner">
			<div class="col-lg-6">
				<div class="news_left_text">
					<h4>Join our Newsletter list to get all the latest offers, discounts and other benefits</h4>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="newsletter_form">
					  <div class="input-group">
						  <input type="text" class="form-control" placeholder="Enter your email address">
						  <div class="input-group-append">
							  <button class="btn btn-outline-secondary" type="button">Subscribe Now</button>
						  </div>
					  </div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================End Newsletter Area =================-->

<!--================Footer Area =================-->
<footer class="footer_area">
	<div class="footer_widgets">
		<div class="container">
			<div class="row footer_wd_inner">
				<div class="col-lg-3 col-6">
					<aside class="f_widget f_about_widget">
						<img src="img/footer-logo.png" alt="">
						<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui bland itiis praesentium voluptatum deleniti atque corrupti.</p>
						<ul class="nav">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						</ul>
					</aside>
				</div>
				<div class="col-lg-3 col-6">
					<aside class="f_widget f_link_widget">
						<div class="f_title">
							<h3>Quick links</h3>
						</div>
						<ul class="list_style">
							<li><a href="#">Your Account</a></li>
							<li><a href="#">View Order</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Terms & Conditionis</a></li>
						</ul>
					</aside>
				</div>
				<div class="col-lg-3 col-6">
					<aside class="f_widget f_link_widget">
						<div class="f_title">
							<h3>Work Times</h3>
						</div>
						<ul class="list_style">
							<li><a href="#">Mon. :  Fri.: 8 am - 8 pm</a></li>
							<li><a href="#">Sat. : 9am - 4pm</a></li>
							<li><a href="#">Sun. : Closed</a></li>
						</ul>
					</aside>
				</div>
				<div class="col-lg-3 col-6">
					<aside class="f_widget f_contact_widget">
						<div class="f_title">
							<h3>Contact Info</h3>
						</div>
						<h4>(1800) 574 9687</h4>
						<p>Justshiop Store <br />256, baker Street,, New Youk, 5245</p>
						<h5>cakebakery@contact.co.in</h5>
					</aside>
				</div>
			</div>
		</div>
	</div>
	<div class="footer_copyright">
		<div class="container">
			<div class="copyright_inner">
				<div class="float-left">
					<h5><a target="_blank" href="https://www.templatespoint.net">Templates Point</a></h5>
				</div>
				<div class="float-right">
					<a href="#">Purchase Now</a>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--================End Footer Area =================-->


<!--================Search Box Area =================-->
<div class="search_area zoom-anim-dialog mfp-hide" id="test-search">
	<div class="search_box_inner">
		<h3>Search</h3>
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search for...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button"><i class="icon icon-Search"></i></button>
			</span>
		</div>
	</div>
</div>
<!--================End Search Box Area =================-->
@endsection