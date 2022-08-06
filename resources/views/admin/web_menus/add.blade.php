@extends('admin.layouts.lte')
@section('content')

<!-- Main content -->
<section class="content">
    @include('layouts.feedback')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">{{$title}}</h4>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                         <form action="{{route('admin.web_menu.save')}}" method="post" enctype="multipart/form-data">              
                         @csrf
                             <div class="form-group" hidden>
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Menu') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="parent_id">
                                                  <option value="0">Leave as Parent</option>
                                                  @foreach($menus as $menu)
                                                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ __('Choose Main Menu') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Name') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input required name="name" class="form-control menu">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Type') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select required id="select_id" onchange="showPageSelect()" class="form-control select2" style="width: 90%;" name="type">
                                                  <option>{{ __('Select Type') }}</option>
                                                  <option value="0">{{ __('External Link') }}</option>
                                                  <option value="1">{{ __('Link') }}</option>
                                                  <option value="2">{{ __('Content Page') }}</option>
                                                  <option value="3">{{ __('Post Category') }}</option>
                                                  
                                            </select>
                                          
                                          </div>
                                        </div>
                                        <div class="form-group external_link hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('External_Link') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="external_link" class="form-control menu">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group link hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Link') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="link" class="form-control menu">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group page hidden">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Content Page') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control select2" style="width: 90%;" name="page_id">
                                              <option value="">Select Page</option>
                                              @foreach($pages as $page)
                                                  <option value="{{$page->id}}">{{ $page->title}}</option>
                                              @endforeach
                                            </select>
                                          
                                          </div>
                                        </div>
                                        
                                        
                                        <div class="form-group category hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Category') }} </label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control select2" style="width: 90%;" name="category_slug">
                                                @foreach($category as $value)
                                                    <option value="{{$value->slug}}">{{ $value->title}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        

                                        

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Status') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                              <select class="form-control select2" style="width: 90%;" name="status">
                                                  <option value="ACTIVE">{{ __('Active') }}</option>
                                                  <option value="INACTIVE">{{ __('Inactive') }}</option>
                                            </select>
                                          
                                          </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                            <a href="{{ route('admin.web_menu')}}" type="button" class="btn btn-default">{{ __('back') }}</a>
                                        </div>
                                        <!-- /.box-footer -->
                    </form>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
    <!-- ./row -->
</section>


@endsection
@section('script_js')
<script>


    $('#saveProduct').submit(function (e) {
        e.preventDefault();
        $('.submitBtn2').attr('disabled', true);
        $('.submitBtn2').html("<i class='fas fa-refresh fa-spin'></i> Saving...");


        $('#saveProduct').unbind('submit').submit();



    });
    
$('.select2').select2();

</script>
<script>
                                          function showPageSelect(){
                                               var d = document.getElementById("select_id").value;
                                               if(d == 0){
                                                 jQuery('.external_link').removeClass("hidden");
                                                 jQuery('.link').addClass("hidden");
                                                 jQuery('.page').addClass("hidden");
                                                 jQuery('.category').addClass("hidden");
                                               }
                                               else if(d == 1) {
                                                 jQuery('.external_link').addClass("hidden");
                                                 jQuery('.link').removeClass("hidden");
                                                 jQuery('.page').addClass("hidden");    
                                                  jQuery('.category').addClass("hidden");
                                              }else if(d == 2) {
                                                 jQuery('.external_link').addClass("hidden");
                                                 jQuery('.link').removeClass("hidden");
                                                 jQuery('.page').removeClass("hidden");
                                                jQuery('.category').addClass("hidden");
                                              }
                                              else if(d == 3) {
                                                jQuery('.external_link').addClass("hidden");
                                                 jQuery('.link').addClass("hidden");
                                                 jQuery('.page').addClass("hidden");
                                                 jQuery('.category').removeClass("hidden");
                                              }
                                          }
                                        </script>
@endsection