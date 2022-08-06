@extends('web.layout.master')

@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="page-banner page-banner-overlay" data-background="{{asset('web/assets/img/bg/banner-bg.jpg')}}" style="background-image: url(&quot;assets/img/bg/banner-bg.jpg&quot;);">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 my-auto">
                <div class="page-banner-content text-center">
                    <h2 class="page-banner-title">{{$pageDetail->title}}</h2>
                    <div class="page-banner-breadcrumb">
                        <p><a href="{{route('home1')}}">Home</a> {{$menu_detail->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-banner-shape"></div>
</div>
<section id="blogsingle" class="section-padding">
    <div class="auto-container">
        <div class="row">
            @include('web.layout.feedback')
        </div>
        <div class="row mb-lg-5 mb-0">
            
            @php
            $sidebarArray = array();
            $years = range(2000, date('Y')-1);
            if(!empty($pageDetail->sidebar)){
            $sidebarArray = explode(',',$pageDetail->sidebar);
            }
            @endphp

            <div class="col-lg-8 col-md-8 col-12">

                <div class="blog-single single-blog-post">
                    <div class="single-blog-post-wrap">
                        <div class="single-blog-post-content">
                            <h4 class="single-blog-post-title">
                                <a href="#">{{$pageDetail->title}}</a>
                            </h4>



                            <div class="blog-single-des mt-4">
                                {!!$pageDetail->description!!}
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <!-- end col -->
            <div class="col-lg-4 col-md-4 col-12 mt-lg-0 mt-md-0 mt-5 pl-lg-5 pl-md-5 pl-0">



                <div class="card rounded-0 mb-3">
                    <div class="card-header bg-white text-center">Alumni Registration</div>

                    <div class="card-body">
                        <form action="{{route('web.alumani.form.save')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" required="" class="form-control rounded-0 @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" placeholder="Name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                              
                            </div>
                            <div class="form-group">
                                <input type="text" name="designation" class="form-control rounded-0 @error('designation') is-invalid @enderror" placeholder="Designation">
                                @error('designation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                           
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" required="" class="form-control rounded-0 @error('email') is-invalid @enderror" placeholder="Email Id">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" required="" class="form-control rounded-0 @error('phone') is-invalid @enderror" name="phone" placeholder="Mobile No.">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select type="text" name="year_passout" required="" class="form-control select2 rounded-0 @error('year_passout') is-invalid @enderror" placeholder="Passout Year">
                                    <option value="">Select Year</option>
                                @foreach($years as $year)
                                  <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                                </select>
                                    @error('year_passout')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="passout_class" required="" class="form-control rounded-0 @error('passout_class') is-invalid @enderror" placeholder="Passout Class">
                                @error('passout_class')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="upload-image">Upload Image</label>
                                <input type="file" name="file" required="" class="form-control rounded-0 @error('file') is-invalid @enderror" id="upload-image">
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror	
                            </div>
                            <button type="submit" class="btn btn-dark">Submit</button>
                        </form>
                    </div>
                </div>

                @if(!empty($sidebarArray) && count($sidebarArray) > 0)	

                @forelse($sidebarArray as $value)
                @include("web.sidebar.$value")
                @empty
                @endforelse
                @endif
            </div>
            <!-- end col -->


        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $('.select2').select2();
    </script>
@endsection