
<!-- hero-wrap-->
                <div class="hero-wrap" id="sec1" data-scrollax-parent="true">
                    <!-- hero-inner-->
                    <!-- fullscreen-slider-wrap-->
                    <div class="slider-carousel-wrap full-height fullscreen-slider-wrap">
                        <div class="fullscreen-slider full-height cur_carousel-slider-container fl-wrap" data-slick='{"autoplay": true, "autoplaySpeed": 4000 , "pauseOnHover": false}'>
                            @php
                $homeSlidersArray = \App\Models\WebSlider::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->get();
                @endphp
                @forelse($homeSlidersArray as $value)
                @if(!empty($value->image))
                            <!-- fullscreen-slider-item-->
                            <div class="fullscreen-slider-item full-height fl-wrap">
                                <div class="bg par-elem"  data-bg="{{asset($value->image)}}"></div>
                                <div class="overlay"></div>
                                <div class="half-hero-wrap">
                                    
                                    @if(!empty($value->title))
                                    <h1>{{$value->title}}</h1>
                                    @endif
                                    @if(!empty($value->sub_title))
                                    <h4>{{$value->sub_title}}</h4>
                                     @endif
                                    <div class="clearfix"></div>
                                    <a href="{{url()->current()}}#sec2" class="custom-scroll-link btn float-btn flat-btn color-btn mar-top">Let's Start</a>
                                </div>
                            </div>
                            <!-- fullscreen-slider-item end-->
                            @else
                            <!-- fullscreen-slider-item-->
                            <div class="fullscreen-slider-item full-height fl-wrap">
                                <div class="bg par-elem"  data-bg="{{asset('web/assets/images/bg/26.jpg')}}"></div>
                                <div class="overlay"></div>
                                <div class="half-hero-wrap">
                                    <h1>Hey there!<br>I'm  Martin Solonick<br>Independent <span> Digital  Designer </span></h1>
                                    <h4>I create web and graphic design</h4>
                                    <div class="clearfix"></div>
                                    <a href="{{url()->current()}}#sec2" class="custom-scroll-link btn float-btn flat-btn color-btn mar-top">Let's Start</a>
                                </div>
                            </div>
                            <!-- fullscreen-slider-item end-->
                            @endif
                            @empty
                            <!-- fullscreen-slider-item-->
                            <div class="fullscreen-slider-item full-height fl-wrap">
                                <div class="bg par-elem"  data-bg="{{asset('web/assets/images/bg/26.jpg')}}"></div>
                                <div class="overlay"></div>
                                <div class="half-hero-wrap">
                                    <h1>Hey there!<br>I'm  Martin Solonick<br>Independent <span> Digital  Designer </span></h1>
                                    <h4>I create web and graphic design</h4>
                                    <div class="clearfix"></div>
                                    <a href="{{url()->current()}}#sec2" class="custom-scroll-link btn float-btn flat-btn color-btn mar-top">Let's Start</a>
                                </div>
                            </div>
                            <!-- fullscreen-slider-item end-->
                          @endforelse     
                        </div>
                        <div class="sp-cont   sp-cont-prev"><i class="fal fa-arrow-left"></i></div>
                        <div class="sp-cont   sp-cont-next"><i class="fal fa-arrow-right"></i></div>
                        <div class="fullscreenslider-counter"></div>
                    </div>
                    <!-- fullscreen-slider-wrap end-->
                    <!--hero dec-->
                    {{--
                    <div class="hero-decor-numb"><span>40.7143528  </span><span>-74.0059731 </span> <a href="https://www.google.com.ua/maps/" target="_blank" class="hero-decor-numb-tooltip">Based In NewYork</a></div>
                --}}
                </div>
                <!-- hero-wrap end-->


