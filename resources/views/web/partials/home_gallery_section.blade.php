<!-- START PORTFOLIO SECTION -->
<section id="portfolio" class="section-padding">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-12 mx-auto text-center">
                <div class="section-title">
                    <h6 class="theme-color">We love our work</h6>
                    <h2>Image Gallery</h2>
                </div>
            </div>
        </div>

        <!-- end portfolio menu list -->
        <div class="row project-list">
            @php
            $albumHomeSectionArray = \App\Models\WebAlbum::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->limit(6)->get();
            @endphp
            @forelse($albumHomeSectionArray as $value)
            <div class="col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-4 mb-4">
                <figure class="portfolio-sin-item">
                    <img class="img-fluid" src="{{asset($value->image)}}" alt="" />
                    <figcaption>
                        <h3>{{$value->title}}</h3>
                        <div class="port-icon mt-3">
                            <a class="icon-ho venobox" href="{{asset($value->image)}}" data-title="{{$value->title}}" data-gall="gall1"><i class="icofont-eye"></i></a>
                            <a class="icon-ho" href="{{route('web.gallery.view',['slug'=>$value->url])}}"><i class="icofont-link"></i></a>
                        </div>
                    </figcaption>
                </figure>
            </div>
            @empty
            <div class="col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-4 mb-4">
                <figure class="portfolio-sin-item">
                    <img class="img-fluid" src="{{asset('web/assets/img/gallery/5.jpg')}}" alt="" />
                    <figcaption>
                        <h3>Portfolio Title</h3>
                        <div class="port-icon mt-3">
                            <a class="icon-ho venobox" href="{{asset('web/assets/img/gallery/5.jpg')}}" data-title="PORTFOLIO TITTLE" data-gall="gall1"><i class="icofont-eye"></i></a>
                            <a class="icon-ho" href="#"><i class="icofont-link"></i></a>
                        </div>
                    </figcaption>
                </figure>
            </div>
            @endforelse
        </div>

    </div>
    <!--- END CONTAINER -->
</section>
<!-- END PORTFOLIO SECTION -->