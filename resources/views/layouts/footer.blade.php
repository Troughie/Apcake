<footer class="footer_area">
    <div class="footer_widgets">
        <div class="container">
            <div class="row footer_wd_inner">
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_about_widget">
                        <img src="{{ asset('img/Logo_apcake.png') }}" alt="">
                        <p>APCAKE bakery, where we offer you a delightful experience of various sweet and savory cakes
                            with de
                        <ul class="nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-amazon"></i></a></li>
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_link_widget">
                        <div class="f_title">
                            <h3>Quick links</h3>
                        </div>
                        <ul class="list_style">
                            @if (Auth::check())
                                <li>
                                    <a href="{{ route('user.profile', Auth::id()) }}">Your Account</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.showcart', Auth::id()) }}">View Order</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('blog') }}">View blog</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">View contact</a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_link_widget">
                        <div class="f_title">
                            <h3>Giờ làm việc</h3>
                        </div>
                        <ul class="list_style">
                            <li>
                                <a href="#">Thứ 2 - Thứ 6: 08:00 - 20:00</a>
                                </li>
                            <li>
                                <a href="#">Thứ 7 : 09:00 - 16:00</a>
                            </li>
                            <li>
                                <a href="#">Chủ Nhật : Nghỉ</a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_contact_widget">
                        <div class="f_title">
                            <h3>Thông tin liên lạc</h3>
                        </div>
                        <h4>(1900) 251 234</h4>
                        <p>ApCake Store <br />590 Cách Mạng T8, Quận 3, TPHCM</p>
                        <h5>apcake0304@gmail.com</h5>
                    </aside>
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






<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- Rev slider js -->
<script src="{{ asset('vendors/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('vendors/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{ asset('vendors/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('vendors/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ asset('vendors/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('vendors/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<!-- Extra plugin js -->
<script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendors/magnifc-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('vendors/datetime-picker/js/moment.min.js') }}"></script>
<script src="{{ asset('vendors/datetime-picker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>

<script src="{{ asset('js/theme.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.8/sweetalert2.min.js"
    integrity="sha512-ySDkgzoUz5V9hQAlAg0uMRJXZPfZjE8QiW0fFMW7Jm15pBfNn3kbGsOis5lPxswtpxyY3wF5hFKHi+R/XitalA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>