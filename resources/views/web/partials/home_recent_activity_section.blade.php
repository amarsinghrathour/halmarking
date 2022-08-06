<!-- START BLOG SECTION -->
      <section id="blog" class="section-padding bg-gray">
         <div class="auto-container">
            <div class="row">
               <div class="col-lg-7 col-md-7 col-12 mx-auto text-center">
                  <div class="section-title">
                     <h6 class="theme-color">Sometime we want to share</h6>
                     <h2>Recent Activity</h2>
                  </div>
               </div>
            </div>
            <!-- end section title -->
            <div class="row mb-5">
            <div class="col">
                <div class="blog-slides owl-carousel owl-theme">
                    @php
                    $recentActivityHomeArray = \App\Models\RecentActivity::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->limit(6)->get();
                    @endphp
                    @forelse($recentActivityHomeArray as $value) 
                    <div class="blog-home-single">
                        <div class="blog-home-image">
                            <img class="img-fluid" src="{{asset($value->image)}}" alt=""/>
                            <div class="blog-home-post-date">
                                <i class="icofont-clock-time"></i>
                                <span>{{$value->activity_date->format('M d, Y')}}</span>
                            </div>
                        </div>
                        <div class="blog-home-des-wrap">

                            <div class="blog-home-des-right">
                               
                                <div class="blog-home-content">
                                    <h4><a href="{{route('web.recent_activity.view',['slug'=>$value->url])}}">{{$value->title}}</a></h4>
                                    {{ Illuminate\Support\Str::limit(strip_tags($value->description), 50, ' ...') }}
                                </div>
                                <div class="blog-home-btn">
                                    <a href="{{route('web.recent_activity.view',['slug'=>$value->url])}}"> Read More <i class="icofont-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="blog-home-single">
                        <div class="blog-home-image">
                            <img class="img-fluid" src="{{asset('web/assets/img/blog/1.jpg')}}" alt=""/>
                            <div class="blog-home-post-date">
                                <i class="icofont-clock-time"></i>
                                <span>May 18, 2021</span>
                            </div>
                        </div>
                        <div class="blog-home-des-wrap">

                            <div class="blog-home-des-right">
                               

                                <div class="blog-home-content">
                                    <h4><a href="#">Nice Designing Classroom</a></h4>
                                    <p>Pellentesque Sed ut perspiciatis unde omnis iste natus error sitre voluptatem accusantium udema…</p>
                                </div>
                                <div class="blog-home-btn">
                                    <a href="#"> Read More <i class="icofont-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforelse
                    <!--  end single item -->
                </div>
            </div>
        </div>
         </div>
         <!--- END CONTAINER -->
      </section>
      <!-- END BLOG SECTION -->