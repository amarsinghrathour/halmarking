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

                        <form action="{{route('admin.web_menu.update')}}" method="post" enctype="multipart/form-data">              
                         @csrf
                         <input type="hidden" name="id" value="{{$data->id}}">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Name') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input required name="name" value="{{$data->name}}" class="form-control menu">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Type') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select required id="select_id" onchange="showPageSelect()" class="form-control" name="type">
                                                  <option>{{ __('Select Type') }}</option>
                                                  <option value="0" @if($data->type == 0) selected @endif>{{ __('External Link') }}</option>
                                                  <option value="1" @if($data->type == 1) selected @endif>{{ __('Link') }}</option>
                                                  <option value="2" @if($data->type == 2) selected @endif>{{ __('Content Page') }}</option>
                                                  <option value="2" @if($data->type == 3) selected @endif>{{ __('Post Category') }}</option>
                                                  
                                            </select>
                                          
                                          </div>
                                        </div>
                                        <div class="form-group external_link @if($data->type != 0) hidden @endif">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('External_Link') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="external_link" class="form-control menu">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group link @if(empty($data->link)) hidden @endif">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Link') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="link" class="form-control menu" value="{{$data->link}}">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group page @if($data->type != 2) hidden @endif">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Content Page') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="page_id">
                                              <option value="">Select Page</option>
                                              @foreach($pages as $page)
                                                  <option value="{{$page->id}}" @if($data->page_id == $page->id) selected=''@endif>{{ $page->title}}</option>
                                              @endforeach
                                            </select>
                                          
                                          </div>
                                        </div>
                                        
                                        
                                        <div class="form-group category @if($data->type != 3) hidden @endif">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Category') }} </label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control select2" style="width: 90%;" name="category_slug">
                                                @foreach($category as $value)
                                                    <option value="{{$value->slug}}" @if($data->link == $value->slug) selected=''@endif>{{ $value->title}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>

                                        

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ __('Status') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="status">
                                                  <option value="ACTIVE" @if($data->status == "ACTIVE") selected=''@endif>{{ __('Active') }}</option>
                                                  <option value="INACTIVE" @if($data->status == "INACTIVE") selected=''@endif>{{ __('Inactive') }}</option>
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
        $('.submitBtn2').html("<i class='fas fa-refresh fa-spin'></i> Updating...");


        $('#saveProduct').unbind('submit').submit();



    });
    


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