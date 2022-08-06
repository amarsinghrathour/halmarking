@extends('admin.layouts.lte')
@section('content')

<!-- Main content -->
<section class="content">
    @include('admin.layouts.feedback')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">{{__('Edit')}} {{__('Service')}}</h4>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.service.update') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{$data->title}}" required="" class="form-control @error('title') is-invalid @enderror" autocomplete='off' placeholder="Enter Title" >
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="name">Icon(150 X 100) </label>
                                    <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror" onchange="previewImage(this);" >
                                    <span>(Note: Allow Type: jpg,jpeg,png,bmp,tiff Max Size: 1mb, width: 150, Height: 100)</span>
                                    @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @if(!empty($data->icon))
                                    <div class="col-sm-10 col-md-4">
                                        <span class="text-danger">Old
                                        </span>
                                        <img src="{{url($data->icon)}}" class="img img-responsive img-thumbnail" width="200px">
                                    </div>
                                    @endif
                                    <div class="col-sm-10 col-md-4 hidden previewImage">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Price Range</label>
                                    <input type="text" name="price_range" value="{{$data->price_range}}" class="form-control @error('price_range') is-invalid @enderror" autocomplete='off' placeholder="Enter Price Range" >
                                    <small>Exp ₹ 2000 - ₹50000</small>
                                    @error('price_range')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="name">Description</label>
                                    <textarea name="description" id="editor1" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" >{{$data->description}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="clearfix">&nbsp;</div>
                            <div class="box-footer">
                                <div class="col-md-12" style="text-align: center">
                                    <a href="{{route('admin.service.list')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    <button type="submit" class="btn btn-warning submitBtn2"><i class="fa fa-save"></i> {{__('Update')}}</button>

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

    $('.select2').select2();


</script>
<script src="{{ asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('ckfinder/ckfinder.js')}}"></script>
<script>
    // Note: in this sample we use CKEditor with two extra plugins:
    // - uploadimage to support pasting and dragging images,
    // - image2 (instead of image) to provide images with captions.
    // Additionally, the CSS style for the editing area has been slightly modified to provide responsive images during editing.
    // All these modifications are not required by CKFinder, they just provide better user experience.
    if (typeof CKEDITOR !== 'undefined') {
        //CKEDITOR.disableAutoInline = true;
        CKEDITOR.addCss('img {max-width:100%; height: auto;}');
        var editor = CKEDITOR.replace('editor1',
                {
                    ckfinder: {
                        uploadUrl: "{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json')}}"
                    },
                    extraPlugins: 'uploadimage,image2',
                    removePlugins: 'image',
                    height: 300
                });
        CKFinder.setupCKEditor(editor);
    } else {
        document.getElementById('editor1').innerHTML =
                '<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor 4 from CDN.</div>'
    }




</script>
@endsection