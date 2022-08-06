@extends('admin.layouts.lte')
@section('content')

<!-- Main content -->
<section class="content">
    @include('admin.layouts.feedback')
    <div class="container-fluid">
        
             <form action="{{ route('admin.web_post.save') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
             <div class="row">
                 @csrf
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
                                <div class="col-md-6 form-group">
                                    <label for="name">Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control select2" required="" onchange="getSubCategory(this)">
                                        <option value="">Select</option>
                                        @foreach($categoryList as $value)
                                        <option value="{{$value->id}}">{{$value->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Sub Category</label>
                                    <select name="sub_category" disabled="" class="form-control select2" id="subCategory">
                                        <option value="">Select</option>

                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{old('title')}}" required="" class="form-control @error('title') is-invalid @enderror" autocomplete='off' placeholder="Enter Title" >
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               
                                <div class="col-md-12 form-group">
                                    <label for="name">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="editor1" required="" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" >{{old('description')}}</textarea>
                                   @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="name">Video Embed code</label>
                                    <textarea name="video_embed" class="form-control @error('video_embed') is-invalid @enderror" >{{old('video_embed')}}</textarea>
                                   @error('video_embed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="name">Audio Embed code</label>
                                    <textarea name="audio_embed" class="form-control @error('audio_embed') is-invalid @enderror" >{{old('audio_embed')}}</textarea>
                                   @error('audio_embed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                               <div class="col-md-6 form-group">
                                    <label for="name">Status</label>
                                    <select name="status" required="" class="form-control @error('status') is-invalid @enderror">
                                        <option value="ACTIVE">Active</option>
                                        <option value="INACTIVE">Inactive</option>
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
                            <h4 class="card-title">Featured Image(1200x800)</h4>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="form-group">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(this);" >
                                    <span>(Note: Allow Type: jpg,jpeg,png,bmp,tiff Max Size: 2mb, width: 1200px, Height: 800px)</span>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="col-sm-10 col-md-4 hidden previewImage">
                                    </div>
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
                        <input class="form-control" autocomplete="off" type="text" name="meta_title" value="{{old('meta_title')}}" placeholder="Enter Seo Tile">
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
                    <textarea name="meta_description" class="form-control">{{old('meta_description')}}</textarea>
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
                    <textarea name="meta_key_word" class="form-control">{{old('meta_key_word')}}</textarea>
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
                                    <a href="{{route('admin.web_post')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    <button type="submit" class="btn btn-warning submitBtn2"><i class="fa fa-save"></i> {{__('Save')}}</button>

                                </div>
                                </div>
        </div>          
  <!--/.col (right) -->
        </div>
                        </form>
             <div class="clearfix">&nbsp;</div>
             
        
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
          
          function previewImage(elem) {
        var inputId = elem;
        // set file link
        var res = window.URL.createObjectURL(elem.files[0]);
        $(inputId).parent().find('.previewImage').removeClass('hidden');
        var image = '<img class="img img-responsive img-thumbnail" width="200px" src=' + res + '>';
        $(inputId).parent().find('.previewImage').html(image);
    }
    
    function getSubCategory(elem){
        var category_id = $(elem).val();
        $.ajax({
                url:  "{{route('admin.web_post.ajax.subcategory')}}",
                type: "POST",
                data: { id:category_id},
                cache: false,
                success: function(data) {
                    console.log('data'+data);
                    if(data == "ERROR")
                    {
                        swal("Oops!", "Error while loading data !", "error");
                    }
                    else if(data == "NOT_FOUND")
                    {
                        
                        swal("Oops!", "Category not found !", "error");
                    }
                    else
                    {
                        var i;
					var showData = [];
                                        if(data.length > 0){
					for (i = 0; i < data.length; ++i) {
						var j = i + 1;
						showData[i] = "<option value='"+data[i].id+"'>"+data[i].title+"</option>";
					}
                                        $("#subCategory").attr('disabled',false);
					$("#subCategory").html(showData);
                                    }
                    }
              },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                if(textStatus == "timeout")
                {
                     swal("Timeout !", "We couldn't connect to the server ! ", "error");
                }
                else
                {
                     swal("Oops", "We couldn't connect to the server ! "+errorThrown, "error");
                }
              }
              });
        
    }  
            
    </script>
@endsection