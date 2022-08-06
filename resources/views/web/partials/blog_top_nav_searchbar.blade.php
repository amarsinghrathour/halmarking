<!-- single-page-fixed-row-->
                    <div class="single-page-fixed-row blog-single-page-fixed-row">
                        <div class="scroll-down-wrap">
                            <div class="mousey">
                                <div class="scroller"></div>
                            </div>
                            <span>Scroll Down</span>
                        </div>
                        <!-- filter  -->
                        <div class="blog-filters">
                            @php
            $searchCategoryArray = \App\Models\Category::where('status','ACTIVE')->orderBy('sort_order')->orderBy('id','desc')->get();
            @endphp
            
                            <span>Filter by: </span>
                            
                            <!-- filter category    -->
                            <div class="category-filter blog-btn-filter">
                                <div class="blog-btn">Categories <i class="fa fa-list-ul" aria-hidden="true"></i></div>
                                <ul>
                                    @forelse($searchCategoryArray as $value)
                                    <li><a href="{{route('web.blog.category',['slug'=>$value->slug])}}">{{$value->title}}</a></li>
                                   @empty
                                   @endforelse
                                </ul>
                            </div>
                            
                            <!-- filter category end  -->
                            
                            <div class="blog-search">
                                <form action="{{route('web.blog.list')}}" class="searh-inner fl-wrap">
                                @csrf
                                    <input name="slug" id="se" type="text" class="search" placeholder="Search.." value="" />
                                    <button type="submit" class="search-submit color-bg" id="submit_btn"><i class="fa fa-search"></i> </button>
                                </form>
                            </div>
                            
                        </div>
                        <!-- filter end    -->
                    </div>
                    <!-- single-page-fixed-row end-->