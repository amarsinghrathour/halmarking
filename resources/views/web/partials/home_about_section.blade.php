<!-- section-->
                    <section data-scrollax-parent="true" id="sec2">
                        <div class="section-subtitle" data-scrollax="properties: { translateY: '-250px' }" style="transform: translateZ(0px) translateY(-237.514px); font-size: 144.588px;"> <span>//</span>Words About  </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="collage-image fl-wrap">
                                        <div class="collage-image-title" data-scrollax="properties: { translateY: '150px' }" style="transform: translateZ(0px) translateY(142.509px);">{{SetttingValue('buisness_name') ? SetttingValue('buisness_name') : config('app.app_name') }}.</div>
                                        <img src="{{SetttingValue('home_about_image') ? asset(SetttingValue('home_about_image')) : asset('web/assets/images/all/1.jpg') }}" class="respimg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="main-about fl-wrap">
                                        <div class="row">
            <div class="col-2 text-white align-self-center">Latest</div>
            <div class="col-10 align-self-center">
                <marquee scrollamount="3" scrolldelay="40" onmouseover="this.stop();" onmouseout="this.start();">
                    <a href="#">
                        <ul style="margin-top: 15px;">                
                            <li class="text-white">{!!SetttingValue('welcome_marquee')!!} </li>
                        </ul>
                    </a>
                </marquee>
            </div>
        </div>
                                        <h2>{!!SetttingValue('home_about_title') ? SetttingValue('home_about_title') :  ''!!}</h2>
                                        <p>{!!SetttingValue('home_about_description') ? SetttingValue('home_about_description') : '' !!}</p>
                                        <!-- features-box-container -->
                                        <div class="features-box-container fl-wrap">
                                            <div class="row">
                                                @php
            $homeOurServicesArray = \App\Models\Service::where('status','ACTIVE')->where('status','ACTIVE')->orderBy('id','desc')->get();
            
            @endphp
            @if(count($homeOurServicesArray) > 0)
                                    @foreach($homeOurServicesArray as $value)
                                                <!--features-box -->
                                                <div class="features-box col-md-6">
                                                    @if(!empty($value->icon))
                                                    <div class="time-line-icon" style="left: -102px;">
                                    <img class="" width="20%" src="{{asset($value->icon)}}" alt="{{$value->title}}">
                                    </div>
                                                    @endif
                                                    <h3>{{$value->title}}</h3>
                                                    {!!Str::limit($value->description, 150, $end='.......')!!}
                                                </div>
                                                <!-- features-box end  -->
                                                @endforeach
                                    @endif 
                                                
                                            </div>
                                        </div>
                                        <!-- features-box-container end  -->
                                        {{--<a href="portfolio.html" class="btn float-btn flat-btn color-btn">My Portfolio</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-parallax-module" data-position-top="90" data-position-left="25" data-scrollax="properties: { translateY: '-250px' }" style="transform: translateZ(0px) translateY(-237.514px); top: 90%; left: 25%;"></div>
                        <div class="bg-parallax-module" data-position-top="70" data-position-left="70" data-scrollax="properties: { translateY: '150px' }" style="transform: translateZ(0px) translateY(142.509px); top: 70%; left: 70%;"></div>
                        <div class="sec-lines"><div class="container full-height"><div class="line-item"></div><div class="line-item"></div><div class="line-item"></div><div class="line-item"></div><div class="line-item"></div></div></div>
                    </section>
                    <!-- section end-->