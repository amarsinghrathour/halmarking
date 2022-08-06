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
                            <h4 class="card-title">{{__('Add')}} {{__('Activity')}}</h4>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.recent_activity.save') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{old('title')}}" required="" class="form-control @error('title') is-invalid @enderror" autocomplete='off' placeholder="Enter Title" >
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Activity Date <span class="text-danger">*</span></label>
                                    <input type="date" name="activity_date" value="{{old('activity_date')}}" required="" class="form-control @error('activity_date') is-invalid @enderror" autocomplete='off' placeholder="Enter Date" >
                                    @error('activity_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="name">Description</label>
                                    <textarea name="description" id="editor1" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" >{{old('description')}}</textarea>
                                   @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Image(1200x800) <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(this);" required="">
                                    <span>(Note: Allow Type: jpg,jpeg,png,bmp,tiff Max Size: 2mb, width: 1200px, Height: 800px)</span>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="col-sm-10 col-md-4 hidden previewImage">
                                    </div>
                                </div>
                               <div class="col-md-6 form-group">
                                    <label for="name">Sort Order</label>
                                    <input type="number" name="sort_order" value="{{old('sort_order') ?? 1}}" class="form-control @error('sort_order') is-invalid @enderror" autocomplete='off' placeholder="Enter Sort Order" >
                                    <small>To Appear at first place enter 1 as sort order</small>
                                    @error('sort_order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                            </div>


                            <div class="clearfix">&nbsp;</div>
                            <div class="box-footer">
                                <div class="col-md-12" style="text-align: center">
                                    <a href="{{route('admin.recent_activity')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    <button type="submit" class="btn btn-warning submitBtn2"><i class="fa fa-save"></i> {{__('Save')}}</button>

                                </div>
                            </div>

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
    function previewImage(elem) {
        var inputId = elem;
        // set file link
        var res = window.URL.createObjectURL(elem.files[0]);
        $(inputId).parent().find('.previewImage').removeClass('hidden');
        var image = '<img class="img img-responsive img-thumbnail" width="200px" src=' + res + '>';
        $(inputId).parent().find('.previewImage').html(image);
    }


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
            
            
            
            
            
    </script>
@endsection