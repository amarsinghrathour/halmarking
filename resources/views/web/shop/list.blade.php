@extends('web.layout.master')

@section('content')

<section class="breadcrumb_section">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-capitalize"><a href="{{route('home1')}}">Home</a> <i class="flaticon-arrows-4"></i></li>
                            <li class="breadcrumb-item active text-capitalize">{{$title}}</li>
                        </ol>
                    </nav>
                    <h1 class="title_h1 font-weight-normal text-capitalize">{{$title}}</h1>
                </div>
            </section>
<section class="padding-top-text-60 padding-bottom-60 featured_section product_list_section product_list_filter_section ">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <!-- START Collection Sorting-->
                            <div class="collection-sorting-row text-center">
                                <div class="filter_menu hidden-lg ">
                                    <a class="title_h5 text-capitalize">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16">
                                        <path id="Filter_Icon" data-name="Filter Icon" fill="#f74f2e" class="cls-1" d="M0,13H5v2H0V13Zm5-1h6v4H5V12Zm6,1H21v2H11V13Zm7-6h3V9H18V7ZM12,6h6v4H12V6ZM0,7H12V9H0V7ZM0,1H3V3H0V1ZM3,0H9V4H3V0ZM9,1H21V3H9V1Z"></path>
                                        </svg>                          filter
                                    </a>
                                </div>
                                
                                <div class="product_grid visible-lg d-none">
                                    <ul>
                                        <li class="grid_2 grid-list" data-column="column2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="30" viewBox="0 0 20 30">                                               
                                            <path id="Rectangle_21_copy_20" data-name="Rectangle 21 copy 20" fill="#aaa" class="cls-1" d="M12.008,11.006h7.986v8H12.008v-8Zm-12,0H7.994v8H0.008v-8Zm0,11H7.994v8H0.008v-8Zm12,0h7.986v8H12.008v-8Zm-12-22H8v8H0.009v-8ZM12,0.006h7.991v8H12v-8Z"></path>
                                            </svg>
                                        </li>
                                        <li class="grid_3 grid-list" data-column="column3 product">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" viewBox="0 0 32 30">                                                
                                            <path id="Rectangle_21_copy_22" data-name="Rectangle 21 copy 22" fill="#aaa" class="cls-1" d="M12.008,11.006h7.986v8H12.008v-8Zm-12,0H7.994v8H0.008v-8Zm0,11H7.994v8H0.008v-8Zm12,0h7.986v8H12.008v-8Zm-12-22H8v8H0.009v-8ZM12,0.006h7.991v8H12v-8Zm12,11h7.986v8H24.008v-8Zm0,11h7.986v8H24.008v-8Zm0-22h7.991v8H24v-8Z"></path>
                                            </svg>
                                        </li>
                                        <li class="grid_4 grid-list active" data-column="column4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="30" viewBox="0 0 41 30">
                                            <path id="Rectangle_21_copy_29" data-name="Rectangle 21 copy 29" fill="#aaa" class="cls-1" d="M11.008,11.006h7.986v8H11.008v-8Zm-11,0H7.994v8H0.008v-8Zm0,11H7.994v8H0.008v-8Zm11,0h7.986v8H11.008v-8Zm-11-22H8v8H0.008v-8ZM11,0.006h7.991v8H11v-8Zm11,11h7.986v8H22.008v-8Zm0,11h7.986v8H22.008v-8Zm0-22h7.991v8H22v-8Zm11,11h7.986v8H33.008v-8Zm0,11h7.986v8H33.008v-8Zm0-22h7.991v8H33v-8Z"></path>
                                            </svg>
                                        </li>
                                    </ul>
                                </div>
                                
                               {{-- <div class="short_by show_product text-right">
                                    <form>
                                        <div class="form-group">
                                            <label for="show" class="title_h5">show :</label>
                                            <select class="form-control" id="show" name="show"><option value="24">24</option></select>
                                        </div>
                                    </form>
                                </div>--}}
                            </div>
                            <!-- START Collection Sorting-->
                            <!-- START Products -->
                            <ul class="category-products  wow fadeIn row" style="visibility: visible; animation-name: fadeIn;">
                               @forelse($productList as $productData)
                                @php
                     $extraImages = array();
                    @endphp
                    @foreach ($productData->productGallery as $obj)
                    @php
                    $extra = asset($obj->image);
                    array_push($extraImages,$extra);
                    @endphp
                    @endforeach
                                <li class="col-lg-3 col-md-4 col-6 product wow fadeInLeft column4" data-wow-duration="1300ms" data-wow-delay="0.4s">
                                    <div class="featured_content">
                                        <div class="featured_img_content">
                                            <img src="{{asset($productData->image)}}" alt="f_product" class="img-fluid">
                                            <div class="featured_btn vertical_middle">
                                                <button class="web-share btn btn-sm btn-success" onclick="webShare('{{ $productData->product_id }}','{{asset($productData->image)}}','{{ $productData->name }}',`{{$productData->description}}`,`{{json_encode($extraImages)}}`);">share</button>
                                            </div>
                                        </div>
                                        <div class="featured_detail_content">
                                            <a href="{{ route('web.product.view',['slug'=>$productData->slug]) }}"><p class="featured_title  text-capitalize  text-center">{{Str::limit($productData->name, 20, $end='.......')}}</p></a>
                                            <p class="featured_price title_h5  text-center"><span>{{$productData->mrp}}</span></p>
                                            
                                        </div>
                                    </div>
                                </li>
                               @empty
                  <p>No data found try again</p>
                  @endforelse 
                            </ul>
                             
                            <!-- END Products -->
                            <!-- START Products Pagination -->
                            @if (count($productList) > 0)
                            <!-- content-nav -->
                                
                                <!-- content-nav end-->     
                <div class="align-self-center">
                    {{$productList->appends(request()->except('page'))->links('vendor.pagination.front')}}
                </div>
                @endif
                            <!-- END Products Pagination -->
                        </div>
                    </div>
                </div>
            </section>

@endsection