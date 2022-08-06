<div class="sidebar-widget post_wid mb-5">
                     <div class="sidebar-widget-inner">
                        <div class="sidebar-widget-title">
                            <h5>Upcoming Events</h5>
                        </div>
                        @php
                            $upcomingEventSidebarArray = \App\Models\UpcomingEvent::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->limit(6)->get();
                            @endphp
                            @forelse($upcomingEventSidebarArray as $value)
                           
                            <div class="singleRecpost">
                           <img src="{{asset($value->image)}}" alt="" class="img-fluid">
                           <h6 class="recTitle"><a href="{{route('web.upcoming_event.view',['slug'=>$value->url])}}">{{$value->title}}</a></h6>
                           <p class="posted-on">{{$value->event_date->format('d M Y')}}</p>
                        </div>
                          @empty
                          <p>Coming Soon</p>
                          @endforelse
                     </div>
                  </div>