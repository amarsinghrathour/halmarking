<div class="sidebar-widget gal_wid mb-5">
                     <div class="sidebar-widget-inner">
                        <div class="sidebar-widget-title">
                           <h5>Gallery</h5>
                        </div>
                        <div class="single-gallery-wrap">
                            @php
                            $albumSidebarArray = \App\Models\WebAlbum::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->limit(6)->get();
                            @endphp
                            @forelse($albumSidebarArray as $value)
                           <div class="single-gallery">
                               <a href="{{route('web.gallery.view',['slug'=>$value->url])}}"><img class="img-fluid" src="{{asset($value->image)}}" alt=""></a>
                              <a href="{{route('web.gallery.view',['slug'=>$value->url])}}" class="icon"><i class="icofont-link"></i></a>                         
                           </div>
                          @empty
                          <p>Coming Soon</p>
                          @endforelse
                        </div>         
                     </div>
                  </div>
                  <!-- end sidebar widget -->