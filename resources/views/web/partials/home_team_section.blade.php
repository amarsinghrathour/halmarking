<!-- START TEAM SECTION -->
      <section id="team" class="section-padding">
         <div class="auto-container">
            <div class="row">
               <div class="col-lg-7 col-md-7 col-12 mx-auto text-center">
                  <div class="section-title">
                     <h6 class="theme-color">We love what we do</h6>
                     <h2>Our Experts Teachers</h2>
                  </div>
               </div>
            </div>
            <!-- end section title -->
            <div class="row mb-5">
               <div class="col">
                  <div class="team-slides owl-carousel owl-theme">
                      
                     <div class="single-team-wrapper">
                         @php
                    $upcomingEventHomeArray = \App\Models\Faculty::where('status','!=','DELETED')->orderBy('id','desc')->limit(6)->get();
                    @endphp
                    @forelse($upcomingEventHomeArray as $value)
                    <div class="single-team-member">
                           <img class="img-fluid" src="{{asset($value->image)}}" alt="">
                           <div class="single-team-member-content">
                              <ul class="single-team-member-social">
                                 <li><a href="mailto:{{$value->email}}"><i class="icofont-email"></i></a></li>
                                 <li><a href="tel:{{$value->mobile}}"><i class="icofont-phone"></i></a></li>
                                
                              </ul>
                              <div class="single-team-member-text">
                                 <h4>{{$value->name}}</h4>
                                 <p>{{$value->designation}}</p>
                              </div>
                           </div>
                        </div>
                     @empty
                        <div class="single-team-member">
                           <img class="img-fluid" src="{{asset('web/assets/img/team/1.jpg')}}" alt="">
                           <div class="single-team-member-content">
                              <ul class="single-team-member-social">
                                 <li><a href="#"><i class="icofont-email"></i></a></li>
                                 <li><a href="#"><i class="icofont-phone"></i></a></li>
                                
                              </ul>
                              <div class="single-team-member-text">
                                 <h4>Jone Doe</h4>
                                 <p>Swimming Teacher</p>
                              </div>
                           </div>
                        </div>
                      @endforelse   
                     </div>
                    
                     <!-- End single team item -->
                     
                  </div>
               </div>
            </div>
         </div>
         <!--- END CONTAINER -->
      </section>
      <!-- END TEAM SECTION -->