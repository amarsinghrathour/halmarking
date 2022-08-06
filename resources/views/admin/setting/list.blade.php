@extends('admin.layouts.lte')
@section('style_css')
<!-- Font Awesome -->

@endsection
@section('content')
<section class="content">
    @include('layouts.feedback')
    
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <a href="{{ route('settings') }}" style="float: right;">
                <button class="btn btn-sm btn-danger processing_btn">
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                </button> &nbsp; 
            </a>
            
                      </div>
          <!-- /.card-header -->
          <div class="card-body">
              <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data">
                  @csrf
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">General Setting</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-homepage-tab" data-toggle="pill" href="#custom-content-below-homepage" role="tab" aria-controls="custom-content-below-homepage" aria-selected="true">Home Page Setting</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-contact-tab" data-toggle="pill" href="#custom-content-below-contact" role="tab" aria-controls="custom-content-below-contact" aria-selected="true">Contact Setting</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-social-content-tab" data-toggle="pill" href="#custom-content-social-content" role="tab" aria-controls="custom-content-social-content" aria-selected="true">Social Setting</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">{{__('Custom')}} {{__('CSS')}} {{__('Codes')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">{{__('Custom')}} {{__('Js')}} {{__('Codes')}}</a>
              </li>
            </ul>
              <div class="tab-content" id="custom-content-below-tabContent">
              <div class="tab-content" id="custom-content-below-tabContent">
              <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                  <div class="row">
                      
                  <div class="form-group col-sm-6">
                      <label for="address">Site name</label>
                      <input type="text" class="form-control" name="buisness_name" autocomplete="off" @if(!empty(SetttingValue('buisness_name'))) value="{{SetttingValue('buisness_name')}}" @endif>
                  </div>
                  
                  <div class="form-group col-sm-6">
                      <label>{{__('Website Url')}}</label>
                      <input type="text" class="form-control" name="website" autocomplete="off" @if(!empty(SetttingValue('website'))) value="{{SetttingValue('website')}}" @endif>
                  </div>
                  
                  <div class="form-group col-sm-6">
                      <label>Description</label>
                      <textarea class="form-control" autocomplete="off" rows="3" name="description">@if(!empty(SetttingValue('description'))) {{SetttingValue('description')}} @endif</textarea>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>GEO Location <small> Only google map embed url</small></label>
                      <textarea class="form-control" autocomplete="off" rows="3" name="map_url">@if(!empty(SetttingValue('map_url'))) {{SetttingValue('map_url')}} @endif</textarea>
                  </div>  
                  <div class="form-group col-sm-6">
                      <label>Footer Short Text</label>
                      <textarea class="form-control" autocomplete="off" rows="3" name="footer_short_text">@if(!empty(SetttingValue('footer_short_text'))) {{SetttingValue('footer_short_text')}} @endif</textarea>
                  </div>  
                  <div class="form-group col-sm-6">
                      <label>{{__('No. of Happy Customers')}}</label>
                      <input type="text" class="form-control" name="no_of_customers" autocomplete="off" @if(!empty(SetttingValue('no_of_customers'))) value="{{SetttingValue('no_of_customers')}}" @endif>
                  </div>
                  
                  <div class="form-group col-sm-6">
                      <label>{{__('No. of Awards')}}</label>
                      <input type="text" class="form-control" name="no_of_awards" autocomplete="off" @if(!empty(SetttingValue('no_of_awards'))) value="{{SetttingValue('no_of_awards')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('No. of Trophy')}}</label>
                      <input type="text" class="form-control" name="no_of_trophy" autocomplete="off" @if(!empty(SetttingValue('no_of_trophy'))) value="{{SetttingValue('no_of_trophy')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Opening Hours')}} <small class="text-warning"> Like - Mon - Sun : 09:00 - 16:00</small></label>
                      <input type="text" class="form-control" name="opening_hours" autocomplete="off" @if(!empty(SetttingValue('opening_hours'))) value="{{SetttingValue('opening_hours')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Header Logo')}}<small> ({{__('Size 304x60')}})</small></label>
                      <input type="file" class="form-control" name="header_logo" onchange="previewImage(this);" autocomplete="off">
                      <div class="col-sm-10 col-md-4 previewImage">
                          @if(!empty(SetttingValue('header_logo')))
                          <img class="img img-responsive img-thumbnail" width="200px" src="{{asset(SetttingValue('header_logo'))}}">
                          @endif
                      </div>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Header Logo Diamond')}}<small> ({{__('Size 100x116 png')}})</small></label>
                      <input type="file" class="form-control" name="header_logo_diamond" onchange="previewImage_diamond(this);" autocomplete="off">
                      <div class="col-sm-10 col-md-4 previewImage_diamond">
                          @if(!empty(SetttingValue('header_logo_diamond')))
                          <img class="img img-responsive img-thumbnail" width="200px" src="{{asset(SetttingValue('header_logo_diamond'))}}">
                          @endif
                      </div>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Footer Logo')}}<small> ({{__('Size 304x60')}})</small></label>
                      <input type="file" class="form-control" name="footer_logo" onchange="previewImage2(this);" autocomplete="off">
                      <div class="col-sm-10 col-md-4 previewImage2">
                          @if(!empty(SetttingValue('footer_logo')))
                          <img class="img img-responsive img-thumbnail" width="200px" src="{{asset(SetttingValue('footer_logo'))}}">
                          @endif
                      </div>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Favicon')}}<small> ({{__('Size 16x16')}})</small></label>
                      <input type="file" class="form-control" name="favicon" onchange="previewImage3(this);" autocomplete="off">
                      <div class="col-sm-10 col-md-4 previewImage3">
                          @if(!empty(SetttingValue('favicon')))
                          <img class="img img-responsive img-thumbnail" width="200px" src="{{asset(SetttingValue('favicon'))}}">
                          @endif
                      </div>
                  </div>
                  <div class="form-group col-sm-12">
                      <label>{{__('Welcome Marquee Message')}}</label>
                      <input type="text" class="form-control" name="welcome_marquee" autocomplete="off" @if(!empty(SetttingValue('welcome_marquee'))) value="{{SetttingValue('welcome_marquee')}}" @endif>
                  </div>
                      <div class="form-group col-sm-12">
                          <label>Copyright</label>      
                          <textarea class="form-control" rows="3" name="copyright" autocomplete="off">@if(!empty(SetttingValue('copyright'))) {{SetttingValue('copyright')}} @endif</textarea>
                      </div>

                  </div>
              
              </div>
                <div class="tab-pane fade" id="custom-content-below-homepage" role="tabpanel" aria-labelledby="custom-content-below-homepage-tab">
              <div class="row mt-3">
                  <div class="form-group col-sm-12 col-md-12">
                  <h3>About us Section</h3>
                  <hr>
                  <div class="row">
                  <div class="col-sm-4">
                  <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="homeAboutSectionShow" name="home_about_section" value="Y" @if(!empty(SetttingValue('home_about_section')) && SetttingValue('home_about_section') == 'Y')checked=''@endif>
                                                       <label for="homeAboutSectionShow" class="custom-control-label">Show</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="homeAboutSectionHide" name="home_about_section" value="N" @if(!empty(SetttingValue('home_about_section')) && SetttingValue('home_about_section') == 'N')checked=''@endif>
                                                       <label for="homeAboutSectionHide" class="custom-control-label">Hide</label>
                                            </div>
                  </div>
                      
                      <div class="col-sm-4">
                      <label>{{__('Home About us Image')}}<small> ({{__('Size 282X395')}})</small></label>
                      <input type="file" class="form-control" name="home_about_image" onchange="previewImage4(this);" autocomplete="off">
                      <div class="col-sm-10 col-md-4 previewImage4">
                          @if(!empty(SetttingValue('home_about_image')))
                          <img class="img img-responsive img-thumbnail" width="200px" src="{{asset(SetttingValue('home_about_image'))}}">
                          @endif
                      </div>
                  </div>
                      
                      <div class="form-group col-sm-4">
                          <label>About Us Title</label>      
                          <input type="text" class="form-control" name="home_about_title" autocomplete="off" @if(!empty(SetttingValue('home_about_title'))) value="{{SetttingValue('home_about_title')}}" @endif>
                      </div>
                      <div class="form-group col-sm-12">
                          <label>About Us Description</label>      
                          <textarea class="form-control" rows="3" name="home_about_description" autocomplete="off">@if(!empty(SetttingValue('home_about_description'))) {{SetttingValue('home_about_description')}} @endif</textarea>
                      </div>
                  
                 </div>
                 </div>
                  <div class="form-group col-sm-12 col-md-12">
                  <h3>Counter Section</h3>
                  <hr>
                  <div class="row">
                  <div class="col-sm-2">
                  <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="homeCounterSectonShow" name="home_counter_section" value="Y" @if(!empty(SetttingValue('home_counter_section')) && SetttingValue('home_counter_section') == 'Y')checked=''@endif>
                                                       <label for="homeCounterSectonShow" class="custom-control-label">Show</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="homeCounterSectonHide" name="home_counter_section" value="N" @if(!empty(SetttingValue('home_counter_section')) && SetttingValue('home_counter_section') == 'N')checked=''@endif>
                                                       <label for="homeCounterSectonHide" class="custom-control-label">Hide</label>
                                            </div>
                 </div>
                 <div class="form-group col-sm-4">
                          <label>Counter Title</label>      
                          <input type="text" class="form-control" name="home_counter_title" autocomplete="off" @if(!empty(SetttingValue('home_counter_title'))) value="{{SetttingValue('home_counter_title')}}" @endif>
                      </div>
                      <div class="form-group col-sm-6">
                          <label>Counter Description</label>      
                          <textarea class="form-control" rows="3" name="home_counter_description" autocomplete="off">@if(!empty(SetttingValue('home_counter_description'))) {{SetttingValue('home_counter_description')}} @endif</textarea>
                      </div>
                      
                 </div>
                 </div>
              
                  <div class="form-group col-sm-12 col-md-12">
                  <h3>Video Presentation Section</h3>
                  <hr>
                  <div class="row">
                  <div class="col-sm-4">
                  <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="homeVideoSectonShow" name="home_video_section" value="Y" @if(!empty(SetttingValue('home_video_section')) && SetttingValue('home_video_section') == 'Y')checked=''@endif>
                                                       <label for="homeVideoSectonShow" class="custom-control-label">Show</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="homeVideoSectonHide" name="home_video_section" value="N" @if(!empty(SetttingValue('home_video_section')) && SetttingValue('home_video_section') == 'N')checked=''@endif>
                                                       <label for="homeVideoSectonHide" class="custom-control-label">Hide</label>
                                            </div>
                 </div>
                      
                      <div class="col-sm-8">
                      <label>{{__('Home Video Image')}}<small> ({{__('Size 591X395')}})</small></label>
                      <input type="file" class="form-control" name="home_video_image" onchange="previewImage5(this);" autocomplete="off">
                      <div class="col-sm-10 col-md-4 previewImage5">
                          @if(!empty(SetttingValue('home_video_image')))
                          <img class="img img-responsive img-thumbnail" width="200px" src="{{asset(SetttingValue('home_video_image'))}}">
                          @endif
                      </div>
                  </div>
                 <div class="form-group col-sm-6">
                          <label>Video Link</label>      
                          <input type="text" class="form-control" name="home_video_embed_link" autocomplete="off" @if(!empty(SetttingValue('home_video_embed_link'))) value="{{SetttingValue('home_video_embed_link')}}" @endif>
                      </div>
                 <div class="form-group col-sm-6">
                          <label>Video Title</label>      
                          <input type="text" class="form-control" name="home_video_title" autocomplete="off" @if(!empty(SetttingValue('home_video_title'))) value="{{SetttingValue('home_video_title')}}" @endif>
                      </div>
                      <div class="form-group col-sm-12">
                          <label>Video Description</label>      
                          <textarea class="form-control" rows="3" name="home_video_description" autocomplete="off">@if(!empty(SetttingValue('home_video_description'))) {{SetttingValue('home_video_description')}} @endif</textarea>
                      </div>
                      
                 </div>
                 </div>
                  
                 </div>
              </div>   
                <div class="tab-pane fade" id="custom-content-below-contact" role="tabpanel" aria-labelledby="custom-content-below-contact-tab">
                  <div class="row">
                  
                  <div class="form-group col-sm-6">
                      <label for="address">Contact Person</label>
                      <input type="text" class="form-control" name="contact_person" autocomplete="off" @if(!empty(SetttingValue('contact_person'))) value="{{SetttingValue('contact_person')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Phone')}} <small>({{__('Comma Seperated Values For More Than One')}})</small></label>
                      <input type="text" class="form-control" name="contact_phone" autocomplete="off" @if(!empty(SetttingValue('contact_phone'))) value="{{SetttingValue('contact_phone')}}" @endif>
                  </div>
                   <div class="form-group col-sm-6">
                      <label>{{__('Fax')}} </label>
                      <input type="text" class="form-control" name="fax" autocomplete="off" @if(!empty(SetttingValue('fax'))) value="{{SetttingValue('fax')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Email')}} <small>({{__('Comma Seperated Values For More Than One')}})</small></label>
                      <input type="text" class="form-control" name="contact_email" autocomplete="off" @if(!empty(SetttingValue('contact_email'))) value="{{SetttingValue('contact_email')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>Address</label>
                      <textarea class="form-control" autocomplete="off" rows="3" name="contact_address">@if(!empty(SetttingValue('contact_address'))) {{SetttingValue('contact_address')}} @endif</textarea>
                  </div>
              </div>
              </div>
                  <div class="tab-pane fade" id="custom-content-social-content" role="tabpanel" aria-labelledby="custom-content-social-content-tab">
              <div class="row">
                  <div class="form-group col-sm-6">
                      <label>{{__('Facebook Url')}}</label>
                      <input type="text" class="form-control" name="facebook" autocomplete="off" @if(!empty(SetttingValue('facebook'))) value="{{SetttingValue('facebook')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Whatsapp Number')}}</label>
                      <input type="text" class="form-control" name="whatsapp" autocomplete="off" @if(!empty(SetttingValue('whatsapp'))) value="{{SetttingValue('whatsapp')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Twitter Url')}}</label>
                      <input type="text" class="form-control" name="twitter" autocomplete="off" @if(!empty(SetttingValue('twitter'))) value="{{SetttingValue('twitter')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Instagram Url')}}</label>
                      <input type="text" class="form-control" name="instagram" autocomplete="off" @if(!empty(SetttingValue('instagram'))) value="{{SetttingValue('instagram')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Linkedin Url')}}</label>
                      <input type="text" class="form-control" name="linkedin" autocomplete="off" @if(!empty(SetttingValue('linkedin'))) value="{{SetttingValue('linkedin')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Youtube Url')}}</label>
                      <input type="text" class="form-control" name="youtube" autocomplete="off" @if(!empty(SetttingValue('youtube'))) value="{{SetttingValue('youtube')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Twitter screenName')}}</label>
                      <input type="text" class="form-control" name="twitter_screen_name" autocomplete="off" @if(!empty(SetttingValue('twitter_screen_name'))) value="{{SetttingValue('twitter_screen_name')}}" @endif>
                  </div>
                  <div class="form-group col-sm-6">
                      <label>{{__('Twitter Max Tweet Fetch')}}</label>
                      <input type="text" class="form-control" name="twitter_max_tweets" autocomplete="off" @if(!empty(SetttingValue('twitter_max_tweets'))) value="{{SetttingValue('twitter_max_tweets')}}" @endif>
                  </div>
                  
              </div>
              </div>
              <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
              <div class="form-group col-12">
                                        <small>({{__('These codes will be added to the header of the site')}})</small>
                                        
                                        <textarea class="form-control" rows="10" name="custom_css_codes" autocomplete="off">@if(!empty(SetttingValue('custom_css_codes'))) {{SetttingValue('custom_css_codes')}} @endif</textarea>
                                        <small>(Exp. <code>&lt;style&gt; body {background-color: #00a65a;} &lt;/style&gt;</code>)</small>
                                    </div>
              </div>
              <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
              <div class="form-group col-12">
                                        <small>({{__('These codes will be added to the footer of the site')}})</small>
                                        <textarea class="form-control" rows="10" name="custom_js_codes" autocomplete="off">@if(!empty(SetttingValue('custom_js_codes'))) {{SetttingValue('custom_js_codes')}} @endif</textarea>
                                        <small>(Exp. <code>&lt;script&gt; alert(&#039;Hello!&#039;); &lt;/script&gt;</code>)</small>
                                    </div>
              </div>
            </div>
                  
            <div class="card-footer">
               
                @can('settings-edit')
                <button type="submit" class="btn btn-primary pull-right processing_btn"><i class="fa fa-save"></i> save</button>
                @endcan
            </div>      
                  
              </form>    
                  
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>



@endsection
@section('script_js')


<script>
    $('.select2').select2();
                                    
                                    function previewImage(elem){
                                       var inputId = elem;
                                    // set file link
                                        var res = window.URL.createObjectURL(elem.files[0]);
                                        $(inputId).parent().find('.previewImage').removeClass('hidden');
                                                var image = '<img class="img img-responsive img-thumbnail" width="200px" src='+res+'>';
                                        $(inputId).parent().find('.previewImage').html(image);
                                    }
                                    function previewImage_diamond(elem){
                                       var inputId = elem;
                                    // set file link
                                        var res = window.URL.createObjectURL(elem.files[0]);
                                        $(inputId).parent().find('.previewImage_diamond').removeClass('hidden');
                                                var image = '<img class="img img-responsive img-thumbnail" width="200px" src='+res+'>';
                                        $(inputId).parent().find('.previewImage_diamond').html(image);
                                    }
                                    function previewImage2(elem){
                                       var inputId = elem;
                                    // set file link
                                        var res = window.URL.createObjectURL(elem.files[0]);
                                        $(inputId).parent().find('.previewImage2').removeClass('hidden');
                                                var image = '<img class="img img-responsive img-thumbnail" width="200px" src='+res+'>';
                                        $(inputId).parent().find('.previewImage2').html(image);
                                    }
                                    function previewImage3(elem){
                                       var inputId = elem;
                                    // set file link
                                        var res = window.URL.createObjectURL(elem.files[0]);
                                        $(inputId).parent().find('.previewImage3').removeClass('hidden');
                                                var image = '<img class="img img-responsive img-thumbnail" width="200px" src='+res+'>';
                                        $(inputId).parent().find('.previewImage3').html(image);
                                    }
                                    
                                    function previewImage4(elem){
                                       var inputId = elem;
                                    // set file link
                                        var res = window.URL.createObjectURL(elem.files[0]);
                                        $(inputId).parent().find('.previewImage4').removeClass('hidden');
                                                var image = '<img class="img img-responsive img-thumbnail" width="200px" src='+res+'>';
                                        $(inputId).parent().find('.previewImage4').html(image);
                                    }
                                    
                                    function previewImage5(elem){
                                       var inputId = elem;
                                    // set file link
                                        var res = window.URL.createObjectURL(elem.files[0]);
                                        $(inputId).parent().find('.previewImage5').removeClass('hidden');
                                                var image = '<img class="img img-responsive img-thumbnail" width="200px" src='+res+'>';
                                        $(inputId).parent().find('.previewImage5').html(image);
                                    }

                                    
                                                                    </script>

@endsection