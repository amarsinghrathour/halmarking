
 <!-- section-->
 <section id="sec3" class="parallax-section dark-bg sec-half parallax-sec-half-right" data-scrollax-parent="true">
                        <div class="bg par-elem" data-bg="{{asset('web/assets/images/bg/6.jpg')}}" data-scrollax="properties: { translateY: '30%' }" style="background-image: url(&quot;{{asset('web/assets/images/bg/6.jpg')}}&quot;); transform: translateZ(0px) translateY(-3.34177%);"></div>
                        <div class="overlay"></div>
                        <div class="container">
                            <div class="section-title">
                                <h2>{!!SetttingValue('home_counter_title') ? SetttingValue('home_counter_title') : '' !!}</h2>
                                <p>{!!SetttingValue('home_counter_description') ? SetttingValue('home_counter_description') : '' !!} </p>
                                <div class="horizonral-subtitle"><span>Numbers</span></div>
                            </div>
                            <div class="fl-wrap facts-holder">
                                
                                <!-- inline-facts -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="{{SetttingValue('no_of_customers') ?? '145'}}">{{SetttingValue('no_of_customers') ?? '145'}}</div>
                                            </div>
                                        </div>
                                        <h6>Happy customers</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                                <!-- inline-facts -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="{{SetttingValue('no_of_awards') ?? '357'}}">{{SetttingValue('no_of_awards') ?? '357'}}</div>
                                            </div>
                                        </div>
                                        <h6>Awards</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                                
                                <!-- inline-facts -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="{{SetttingValue('no_of_trophy') ?? '825'}}">{{SetttingValue('no_of_trophy') ?? '825'}}</div>
                                            </div>
                                        </div>
                                        <h6>Trophy</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                                
                            </div>
                        </div>
                    </section>
                    <!-- section end-->
