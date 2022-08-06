<!-- footer-->
                <div class="height-emulator fl-wrap"></div>
                <footer class="main-footer fixed-footer">
                    <!--footer-inner-->
                    <div class="footer-inner fl-wrap">
                        <div class="container">
                            <div class="partcile-dec" data-parcount="90"></div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="footer-title fl-wrap">
                                        <span>{{SetttingValue('buisness_name') ? SetttingValue('buisness_name') : config('app.app_name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="footer-header fl-wrap">Last Twitts</div>
                                    <div class="footer-box fl-wrap">
                                        <div class="twitter-swiper-container fl-wrap" id="twitts-container"></div>
                                        <a href="#" class="btn float-btn trsp-btn">Follow</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="footer-header fl-wrap"> Subscribe / Contacts</div>
                                    <!-- footer-box-->
                                    <div class="footer-box fl-wrap">
                                        <p>Want to be notified when we launch a new template or an udpate. Just sign up and we'll send you a notification by email.</p>
                                        <div class="subcribe-form fl-wrap">
                                            <form id="subscribe" class="fl-wrap">
                                                <input class="enteremail" name="email" id="subscribe-email" placeholder="email" spellcheck="false" type="text">
                                                <button type="submit" id="subscribe-button" class="subscribe-button"><i class="fal fa-paper-plane"></i> Send </button>
                                                <label for="subscribe-email" class="subscribe-message"></label>
                                            </form>
                                        </div>
                                        <!-- footer-contacts-->
                                        <div class="footer-contacts fl-wrap">
                                            <ul>
                                                <li><i class="fal fa-phone"></i><span>Phone :</span><a href="tel:{{SetttingValue('contact_phone') ? SetttingValue('contact_phone') : '123-456-0975'}}">{{SetttingValue('contact_phone') ? SetttingValue('contact_phone') : '123-456-0975'}}</a></li>
                                                <li><i class="fal fa-envelope"></i><span>Email :</span><a href="mailto:{{SetttingValue('contact_email') ? SetttingValue('contact_email') : 'info@yoursite.com'}}">{{SetttingValue('contact_email') ? SetttingValue('contact_email') : 'info@yoursite.com'}}</a></li>
                                                <li><i class="fal fa-map-marker"></i><span>Address</span><a href="#">{{SetttingValue('contact_address') ? SetttingValue('contact_address') : 'Brooklyn, NY 11212'}}</a></li>
                                            </ul>
                                        </div>
                                        <!-- footer end -->
                                        <!-- footer-socilal -->
                                        <div class="footer-socilal fl-wrap">
                                            <ul >
                                                @if(!empty(SetttingValue('facebook')))
                                                <li><a href="{{SetttingValue('facebook')}}#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                @endif
                                                @if(!empty(SetttingValue('instagram')))
                                                <li><a href="{{SetttingValue('instagram')}}#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                                @endif
                                                @if(!empty(SetttingValue('twitter')))
                                                <li><a href="{{SetttingValue('twitter')}}#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                @endif
                                                @if(!empty(SetttingValue('youtube')))
                                                <li><a href="{{SetttingValue('youtube')}}#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                                @endif
                                                @if(!empty(SetttingValue('linkedin')))
                                                <li><a href="{{SetttingValue('linkedin')}}#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                        <!-- footer-socilal end -->
                                    </div>
                                    <!-- footer-box end-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--footer-inne endr-->
                    <!--subfooter-->
                    <div class="subfooter fl-wrap">
                        <div class="container">
                            <!-- policy-box-->
                            <div class="policy-box">
                                <span>{{SetttingValue('copyright') ? SetttingValue('copyright') : 'Copyright © 2021/  All rights reserved.'}}   </span>
                            </div>
                            <!-- policy-box end-->
                            <a href="{{url()->current()}}#" class="to-top color-bg"><i class="fal fa-angle-up"></i><span></span></a>
                        </div>
                    </div>
                    <!--subfooter end-->
                </footer>
                <!-- footer end-->
                <!-- contact-btn -->
                <a class="contact-btn color-bg" href="{{url('contact-us')}}"><i class="fal fa-envelope"></i><span>Get in Touch</span></a>
                <!-- contact-btn end -->