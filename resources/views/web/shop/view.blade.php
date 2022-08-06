@extends('web.layout.master')
@section('css')
<meta property="og:title" content="{{ $productData->name }} Model - {{ $productData->product_id }}"/>
 <meta property="og:type" content="product" />
<meta property="og:url" content="{{url('').'/product/detail/'.$productData->slug}}" />
<meta property="og:image" content="{{url('').$productData->image}}" />
<meta property="og:image:width" content="200" />
  <meta property="og:image:height" content="200" />
<meta property="og:description" content="{{ $productData->description }}" />
<meta property="og:site_name" content="{{url('/')}}" />

<meta name="title" content="{{ $productData->meta_title }}"/>
<meta name="description" content="{{ $productData->meta_description}}"/>
      <meta name="keywords" content="{{ $productData->meta_key_word}}"/>
@endsection
@section('content')
<section class="breadcrumb_section">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-capitalize"><a href="{{route('home1')}}">Home</a> <i class="flaticon-arrows-4"></i></li>
                            <li class="breadcrumb-item active text-capitalize">Product</li>
                        </ol>
                    </nav>
                    <h1 class="title_h1 font-weight-normal text-capitalize">@if(!empty($productData->name)) {{ $productData->name }} @endif</h1>
                </div>
            </section>

<section class="padding-top-text-60 padding-bottom-60 product_detail_section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1300ms">
                        <div id="sync1" class="owl-carousel owl-theme">
                                <div class="item">
                                    <div class="product_img">
                                        <img src="{{asset($productData->image)}}" alt="{{$productData->name}}" class="vertical_middle img-fluid" />
                                    </div>
                                </div>
                            @foreach ($productData->productGallery as $obj) 
                                <div class="item">
                                    <div class="product_img">
                                        <img src="{{asset($obj->image)}}" alt="{{$productData->name}}" class="vertical_middle img-fluid"/>
                                    </div>
                                </div>
                                 @endforeach
                            </div> 
                            <div id="sync2" class="owl-carousel owl-theme">
                                
                                <div class="item">
                                    <div class="product_img">
                                        <img src="{{asset($productData->image)}}" alt="{{$productData->name}}" class="vertical_middle img-fluid"/>
                                    </div>
                                </div>
                                @php
                                            $extraImages = array();
                                           @endphp
                                        @foreach ($productData->productGallery as $obj) 
                                        @php
                                        $extra = asset($obj->image);
                                        array_push($extraImages,$extra);
                                        @endphp
                                <div class="item">
                                    <div class="product_img">
                                        <img src="{{asset($obj->image)}}" alt="{{$productData->name}}" class="vertical_middle img-fluid"/>
                                    </div>
                                </div>
                                 @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1300ms">
                            <div class="product_content">
                                <div class="product_title">
                                    <span class="product_price title_h4">MRP : {{ $productData->mrp }}</span>
                                    <p class="sku_text">MODEL: {{ $productData->product_id }}</p>
                                    <span class="posted_in">Category: <a
                                            href="#"
                                            rel="tag">@if(isset($productData->productCategory->title)){{$productData->productCategory->title}}@endif</a>
                                    </span>
                                </div>

                                    <div class="product_btns">
                                        <!-- <button type="submit" class="background-btn text-uppercase cart_btn">add to bag</button> -->
                                        <div class="product_share">
                                            <span>
                                       Share : <button class="web-share btn btn-sm btn-success" onclick="webShare('{{ $productData->product_id }}','{{asset($productData->image)}}','{{ $productData->name }}',`{{$productData->description}}`,`{{json_encode($extraImages)}}`);">share</button>
                                    </span>
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_description padding-top-60">
                        <div class="row">
                            <div class="col-md-12 wow fadeInRight" data-wow-duration="1300ms">
                                <h5 class="title_h5 text-capitalize">{!! $productData->name !!}</h5>
                                <div class="product_variant">
                                        {!! $productData->description !!}
                                    </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    {{-- similar --}}
                    @if(count($similarProductData) > 0)
                    <div class="featured_section padding-top-text-60 wow fadeIn">
                        <h2 class="text-center title_h3">You May Also like to buy</h2>
                        <div class="row">
                            @forelse($similarProductData as $productData)
                    @php
                     $extraImages = array();
                    @endphp
                    @foreach ($productData->productGallery as $obj)
                    @php
                    $extra = asset($obj->image);
                    array_push($extraImages,$extra);
                    @endphp
                    @endforeach
                            <div class="col-lg-3 col-md-4 col-6 wow fadeInLeft" data-wow-duration="1300ms">
                                <div class="featured_content">
                                    <div class="featured_img_content">
                                        <img src="{{asset($productData->image)}}" alt="f_product" class="img-fluid">
                                        <div class="featured_btn vertical_middle">
                                            <button class="web-share btn btn-sm btn-success" onclick="webShare('{{ $productData->product_id }}','{{asset($productData->image)}}','{{ $productData->name }}',`{{$productData->description}}`,`{{json_encode($extraImages)}}`);">share</button>
                                        </div>
                                    </div>
                                    <div class="featured_detail_content mt-4">
                                        <a href="{{ route('web.product.view',['slug'=>$productData->slug]) }}"><p class="featured_title  text-capitalize  text-center">{{Str::limit($productData->name, 20, $end='.......')}}</p></a>
                                        <p class="featured_price title_h5  text-center"><span>{{$productData->mrp}}</span></p>
                                        
                                    </div>
                                </div>
                            </div>
                            @empty
                  
                  @endforelse
                        </div>
                    </div>
                    @endif
                    
                </div>
            </section>

@endsection