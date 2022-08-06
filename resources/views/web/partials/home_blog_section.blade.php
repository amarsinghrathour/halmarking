 <!-- START Home Bolg Section -->
            <section class="blog_section padding-top-text-60 wow fadeIn">
                <div class="container">
                    <h3 class="title_h3  text-capitalize home_title_h3 text-center">Latest Blog</h3>
                    <div class="row">
                        @php
                    $categoryList = \App\Models\Post::where('status','!=','DELETED')->orderBy('id','desc')->paginate(10);
                    @endphp
                        @forelse($categoryList as $categoryData)
                        <div class="col-md-6 wow fadeInLeft" data-wow-duration="1300ms" >
                            <div class="blog_content">
                                <a href="blog_list_detail.html"><img src="{{$value->image}}" alt="blog" class="img-fluid"></a>
                                <span class="article__date">
                                    March 21, 2018 | Posted By Admin
                                    <span class="diamond_shape"></span>
                                </span>
                                <a href="blog_list_detail.html">
                                    <h5  class="article__title title_h5">Sed ut perspiciatis unde omnis iste</h5>
                                </a>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in som...</p>
                            </div>
                        </div>
                        @empty
                  @endforelse
                    </div>
                </div>
            </section>
            <!-- END Home Bolg Section -->