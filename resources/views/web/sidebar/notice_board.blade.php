<div class="sidebar-widget cat_wid service-links mb-5">
                     <div class="sidebar-widget-inner">
                        <div class="sidebar-widget-title">
                           <h5>Latest Circulars</h5>
                        </div>
                        <ul>
                            @php
                            $noticeSidebarArray = \App\Models\NoticeBoard::where('status','ACTIVE')->orderBy('sort_order')->orderBy('id','desc')->limit(6)->get();
                            @endphp
                            @forelse($noticeSidebarArray as $value)
                          <li><a href="{{route('web.notice.view',['slug'=>$value->url])}}"><i class="text-info icofont-circled-right"></i> {{$value->title}} </a></li>
                            @empty
                          <li>Coming Soon</li>
                          @endforelse
                           
                        </ul>                                   
                     </div>
                  </div>