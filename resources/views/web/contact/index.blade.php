@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')

<!--wrapper-->
            <div id="wrapper" class="single-page-wrap">
                <!-- Content-->
                <div class="content">
                    <div class="single-page-decor"></div>
                    <div class="single-page-fixed-row">
                        <div class="scroll-down-wrap">
                            <div class="mousey">
                                <div class="scroller"></div>
                            </div>
                            <span>Scroll Down</span>
                        </div>
                        <a href="{{route('home1')}}" class="single-page-fixed-row-link"><i class="fal fa-arrow-left"></i> <span>Back to home</span></a>
                    </div>
                    <!-- section-->
                    <section class="parallax-section dark-bg sec-half parallax-sec-half-right" data-scrollax-parent="true">
                        <div class="bg par-elem"  data-bg="{{asset('web/assets/images/bg/28.jpg')}}" data-scrollax="properties: { translateY: '30%' }"></div>
                        <div class="overlay"></div>
                        <div class="pattern-bg"></div>
                        <div class="container">
                            <div class="section-title">
                                <h2>{{$pageDetail->title}}</h2>
                                <p> {{$pageDetail->description}} </p>
                                <div class="horizonral-subtitle"><span>{{$menu_detail->name}}</span></div>
                            </div>
                        </div>
                        <a href="{{url()->current()}}#sec1" class="custom-scroll-link hero-start-link"><span>Let's Start</span> <i class="fal fa-long-arrow-down"></i></a>
                    </section>
                    <!-- section end-->
                    <!-- section end-->  
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle"  data-scrollax="properties: { translateY: '-250px' }" >Get in Touch<span>//</span></div>
                        <div class="container">
                            <!-- contact details --> 
                            <div class="fl-wrap mar-bottom">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="pr-title fl-wrap">
                                            <h3>Contact  Details</h3>
                                            {{--<span>Lorem Ipsum generators on the Internet   king this the first true generator</span>
                                        --}}
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <!-- features-box-container --> 
                                        <div class="features-box-container single-serv fl-wrap">
                                            <div class="row">
                                                <!--features-box --> 
                                                <div class="features-box col-md-4">
                                                    <div class="time-line-icon">
                                                        <i class="fal fa-mobile-android"></i>
                                                    </div>
                                                    <h3>01. Phone</h3>
                                                    <a href="{{SetttingValue('contact_phone') ? SetttingValue('contact_phone') : '123-456-0975'}}">{{SetttingValue('contact_phone') ? SetttingValue('contact_phone') : '123-456-0975'}}</a>
                                                </div>
                                                <!-- features-box end  --> 
                                                <!--features-box --> 
                                                <div class="features-box col-md-4">
                                                    <div class="time-line-icon">
                                                        <i class="fal fa-compass"></i>
                                                    </div>
                                                    <h3>02. Location</h3>
                                                    <a href="#">{{SetttingValue('contact_address') ? SetttingValue('contact_address') : 'Brooklyn, NY 11212'}}</a>
                                                </div>
                                                <!-- features-box end  --> 
                                                <!--features-box --> 
                                                <div class="features-box col-md-4">
                                                    <div class="time-line-icon">
                                                        <i class="fal fa-envelope-open"></i>
                                                    </div>
                                                    <h3>03. Email</h3>
                                                    <a href="mailto:{{SetttingValue('contact_email') ? SetttingValue('contact_email') : 'info@yoursite.com'}}">{{SetttingValue('contact_email') ? SetttingValue('contact_email') : 'info@yoursite.com'}}</a>
                                                </div>
                                                <!-- features-box end  --> 
                                            </div>
                                        </div>
                                        <!-- features-box-container end  -->
                                    </div>
                                </div>
                            </div>
                            <!-- contact details end  --> 
                            <div class="fw-map-container fl-wrap mar-bottom">
                                <div class="map-container">
                                    <iframe width="100%" height="300px" src="{{SetttingValue('map_url') ? SetttingValue('map_url'):'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d28836.451501734264!2d82.98576945!3d25.3861783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1633676080091!5m2!1sen!2sin' }}"></iframe>
                                </div>
                            </div>
                            <!--  map end  --> 
                            <div class="fl-wrap mar-top">
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="pr-title fl-wrap">
                                            <h3>Get In Touch</h3>
                                            {{--
                                            <span>Lorem Ipsum generators on the Internet   king this the first true generator</span>
                                        --}}
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="contact-form">
                                            <div id="message"></div>
                                                <form id="main-form" class="custom-form" name="enq" method="POST">
                                                @csrf
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label><i class="fal fa-user"></i></label>
                                                            <input type="text" name="name" id="name" placeholder="Your Name *" required=""/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><i class="fal fa-envelope"></i> </label>
                                                            <input type="text"  name="email" id="email" placeholder="Email Address *" required=""/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><i class="fal fa-mobile-android"></i> </label>
                                                            <input type="text"  name="mobile" id="number" placeholder="Phone *" required=""/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><i class="fal fa-question"></i> </label>
                                                            <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" required="">
                                 
                                                        </div>
                                                    </div>
                                                    <textarea name="message"  id="message" cols="40" rows="3" placeholder="Your Message:" required=""></textarea>
                                                    
                                                    <div class="clearfix"></div>
                                                </fieldset>
                                                <div class="text-center wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="actions">
                                <button name="submit" id="submitButton" class="btn float-btn flat-btn color-btn" title="Click here to submit your message!" type="submit">Send Message</button>
                                <img src="{{asset('web/assets/images/ajax-loader.gif')}}" id="loader" style="display:none" alt="loading" width="16" height="16">
                            </div>
                        </div>
                                            </form>
                                        </div>
                                        <!-- contact form  end--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-parallax-module" data-position-top="70"  data-position-left="20" data-scrollax="properties: { translateY: '-250px' }"></div>
                        <div class="bg-parallax-module" data-position-top="40"  data-position-left="70" data-scrollax="properties: { translateY: '150px' }"></div>
                        <div class="bg-parallax-module" data-position-top="80"  data-position-left="80" data-scrollax="properties: { translateY: '350px' }"></div>
                        <div class="bg-parallax-module" data-position-top="95"  data-position-left="40" data-scrollax="properties: { translateY: '-550px' }"></div>
                        <div class="sec-lines"></div>
                    </section>
                    <!-- section end-->              
                    <!-- section-->
                    <section class="dark-bg2 small-padding order-wrap">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>Find me on social networks : </h3>
                                </div>
                                <div class="col-md-4">
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
                            </div>
                        </div>
                    </section>
                    <!-- section end-->
                </div>
                <!-- Content end -->






@endsection
@section('js')
<!-- form-contact js -->
      <script>
      // JavaScript contact form Document
$(document).ready(function() {
	$('form#main-form').submit(function() {
	$('form#main-form .error').remove();
	var hasError = false;
	$('.requiredField').each(function() {
	if(jQuery.trim($(this).val()) == '') {
    var labelText = $(this).prev('label').text();
    $(this).parent().append('<span class="error">You forgot to enter your '+labelText+'</span>');
    $(this).addClass('inputError');
    hasError = true;
    } else if($(this).hasClass('email')) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if(!emailReg.test(jQuery.trim($(this).val()))) {
    var labelText = $(this).prev('label').text();
    $(this).parent().append('<span class="error">You entered an invalid '+labelText+'</span>');
    $(this).addClass('inputError');
    hasError = true;
    }
    }
    });
    if(!hasError) {
    $('form#main-form input.submit').fadeOut('normal', function() {
    $(this).parent().append('');
    });

     $("#loader").show();
    /*
            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
*/
        $.ajax({
            url: "{{route('web.enquiry.form.save')}}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                console.log(data);
                $("#loader").hide();
                if(data =='success'){
			  $('form#main-form').slideUp("fast", function() { $(this).before('<div class="bg-success shadow-sm text-center p-4"><img class="img-fluid" src="{{asset("web/assets/images/support.png")}}" alt=""><span>Thank you. Your Enquiry was sent successfully. &nbsp; <i class="fal fa-check-square fa-3x"></i></span></div>');
			  });
                      }else{
                            $('form#main-form').before('<div class="bg-danger shadow-sm text-center p-4 mb-5"><span class="text-danger">Some Error Occured. <br> <i class="fal fa-question"></i></span></div>');
			 
                      }
            }           
       });
	   
	   return false;
    }
 
   });
});
      </script>
@endsection