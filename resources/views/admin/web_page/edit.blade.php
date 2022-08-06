@extends('admin.layouts.lte')
@section('content')

<!-- Main content -->
<section class="content">
    @include('layouts.feedback')
    <div class="container-fluid">
        <form action="{{ route('admin.web_page.update') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
             <div class="row">
                 @csrf
                 <input type="hidden" name="id" value="{{$data->id}}">
            <div class="col-md-8">
                <div class="card">
                     <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">General Data</h4>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                       
                            <div class="row">

                                <div class="col-md-12 form-group">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{$data->title}}" required="" class="form-control @error('title') is-invalid @enderror" autocomplete='off' placeholder="Enter Title" >
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               
                                <div class="col-md-12 form-group">
                                    <label for="name">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="editor1" required="" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" >{{$data->description}}</textarea>
                                   @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                               <div class="col-md-6 form-group">
                                    <label for="name">Status</label>
                                    <select name="status" required="" class="form-control @error('status') is-invalid @enderror">
                                        <option value="ACTIVE" @if($data->status == 'ACTIVE') selected='' @endif>Active</option>
                                        <option value="INACTIVE" @if($data->status == 'INACTIVE') selected='' @endif>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                            </div>


                            
                    </div>
                    
                </div>
                <!-- /.col-->
            </div>
               <div class="col-md-4">
                   <div class="card">
                   <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Page Url</h4>
                        </div>
                    </div>
                <div class="card-body">
                    <p>{{$data->url}}</p>
                </div>
                </div>
               <div class="card">
                   <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Template</h4>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="form-group">
                        <select name="template" required="" style="width: 100%;" class="form-control select2 @error('template') is-invalid @enderror">
                            <option value="">Select Template</option>
                            <option value="home" @if($data->template == 'home') selected='' @endif>Home</option>
                            <option value="contact" @if($data->template == 'contact') selected='' @endif>Contact</option>
                            <option value="gallery" @if($data->template == 'gallery') selected='' @endif>Gallery</option>
                            <option value="recent_activity" @if($data->template == 'recent_activity') selected='' @endif>Recent Activity</option>
                            <option value="upcoming_events" @if($data->template == 'upcoming_events') selected='' @endif>Upcoming Events</option>
                            <option value="notice_board" @if($data->template == 'notice_board') selected='' @endif>Notice Board</option>
                            <option value="service" @if($data->template == 'service') selected='' @endif>Service</option>
                            <option value="blog" @if($data->template == 'blog') selected='' @endif>Blog</option>
                            <option value="detail" @if($data->template == 'detail') selected='' @endif>Detail (Default page to view content)</option>
                        </select>
                        @error('template')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                    </div>
                </div>
                </div>
               
                   
                   <div class="card">
                   <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Seo Meta Title</h4>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" autocomplete="off" type="text" name="meta_title" value="{{$data->meta_title}}" placeholder="Enter Seo Tile">
                        @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                    </div>
                </div>
                </div>
               <div class="card">
                   <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Seo Meta Description</h4>
                        </div>
                    </div>
                <div class="card-body">
                    <textarea name="meta_description" class="form-control">{{$data->meta_description}}</textarea>
                        @error('meta_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                </div>
                </div>
                    
                <div class="card">
                   <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Seo Meta Key Words</h4>
                        </div>
                    </div>
                <div class="card-body">
                    <textarea name="meta_key_word" class="form-control">{{$data->meta_key_word}}</textarea>
                        @error('meta_key_word')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                </div>
                </div>
                   
                </div>
            <div class="clearfix">&nbsp;</div>
            <div class="card col-12">
                <div class="card-body">
                                <div class="col-md-12" style="text-align: center">
                                    <a href="{{route('admin.web_page')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    <button type="submit" class="btn btn-warning submitBtn2"><i class="fa fa-save"></i> {{__('Save')}}</button>

                                </div>
                                </div>
        </div>          
  <!--/.col (right) -->
        </div>
                        </form>
             <div class="clearfix">&nbsp;</div>
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
<script src="{{ asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('ckfinder/ckfinder.js')}}"></script>
<script>
            // Note: in this sample we use CKEditor with two extra plugins:
            // - uploadimage to support pasting and dragging images,
            // - image2 (instead of image) to provide images with captions.
            // Additionally, the CSS style for the editing area has been slightly modified to provide responsive images during editing.
            // All these modifications are not required by CKFinder, they just provide better user experience.
            if ( typeof CKEDITOR !== 'undefined' ) {
                    //CKEDITOR.disableAutoInline = true;
                    CKEDITOR.addCss( 'img {max-width:100%; height: auto;}' );
                    var editor = CKEDITOR.replace( 'editor1', 
                    {
                        ckfinder: {
                                uploadUrl: "{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json')}}"
                            },
                            extraPlugins: 'uploadimage,image2',
                    removePlugins: 'image',
                    height:300
                    } );
                    CKFinder.setupCKEditor( editor );
            }
            else {
            document.getElementById( 'editor1' ).innerHTML =
                    '<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor 4 from CDN.</div>'
            }
            
            
        $('.select2').select2();       
            
            
    </script>
@endsection