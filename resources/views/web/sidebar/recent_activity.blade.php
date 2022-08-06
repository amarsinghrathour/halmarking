<div class="sidebar-widget post_wid mb-5">
                     <div class="sidebar-widget-inner">
                        <div class="sidebar-widget-title">
                            <h5>Recent Activity</h5>
                        </div>
                         @php
                            $recentActivitySidebarArray = \App\Models\RecentActivity::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->limit(6)->get();
                            @endphp
                            @forelse($recentActivitySidebarArray as $value)
                           
                            <div class="singleRecpost">
                           <img src="{{asset($value->image)}}" alt="" class="img-fluid">
                           <h6 class="recTitle"><a href="{{route('web.recent_activity.view',['slug'=>$value->url])}}">{{$value->title}}</a></h6>
                           <p class="posted-on">{{$value->activity_date->format('d M Y')}}</p>
                        </div>
                          @empty
                          <p>Coming Soon</p>
                          @endforelse
                        
                        
                     </div>
                  </div>