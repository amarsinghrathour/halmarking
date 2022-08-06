<!-- START Featured Products -->
            <section class="padding-top-text-60 featured_section wow fadeIn">
                <div class="container">
                    <h3 class="title_h3  text-capitalize home_title_h3 text-center">Latest Arrivals</h3>
                    <div class="row">
                        @php
                    $categoryList = \App\Models\Product::where('status','!=','DELETED')->orderBy('id','desc')->paginate(20);
                    @endphp
                        @forelse($categoryList as $value)
                        <div class="col-lg-3 col-md-4 col-6 wow fadeInLeft animated" data-wow-duration="1300ms">
                            <div class="featured_content">
                                <div class="featured_img_content">
                                    <img src="{{$value->image}}" alt="f_product" class="img-fluid"/>
                                    <div class="product-label  text-uppercase  new-label ">new<span class="diamond_shape"></span></div>
                                </div>
                                <div class="featured_detail_content">
                                    <a href="{{route('web.product.view',['slug'=>$value->slug])}}"><p class="featured_title  text-capitalize  text-center">{{$value->name}}</p></a>
                                    <p class="featured_price title_h5  text-center"><span>{{$value->mrp}}</span></p>
                                    
                                </div>
                            </div>
                        </div>
                         @empty
                  @endforelse
                        
                    </div>
                </div>
            </section>
            <!-- END Featured Products -->