<!-- START Collection Section -->
            <div class="home_collection_section padding-top-60 wow fadeIn">
                <div class="container">
                    <div class="row">
                        @php
                    $categoryList = \App\Models\Category::where('status','!=','DELETED')->where('is_top','Y')->orderBy('sort_order','asc')->orderBy('id','desc')->get();
                    @endphp
                        @forelse($categoryList as $categoryData)
                        <div class="col-md-3 wow fadeInLeft animated">
                            <div class="home_collection_content text-center">
                                <img src="{{asset($categoryData->image)}}" alt="women" class="img-fluid"/>
                                <form role="search" method="get" id="" action="{{route('web.shop')}}"
                                              >
                                             @csrf
                                             <input type="hidden" name="category" value="{{$categoryData->id}}">
                                             <a href="#" onclick="$(this).closest('form').submit()" class="vertical_middle text-capitalize">{{$categoryData->title}}
                                    <i class="flaticon-arrows"></i>
                                </a>
                                    </form>
                                
                            </div>
                        </div>
                        @empty
                  @endforelse
                    </div>
                </div>
            </div>
            <!-- END Collection Section -->