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
                            <h4 class="card-title">{{__('Add')}} {{ $album->title }} Image</h4>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.web_album_image.save') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="album_id" value="{{$album->id}}">
                                <div class="col-md-6 form-group">
                                    <label for="name">Title</label>
                                    <input type="text" name="title" value="{{old('title')}}" required="" class="form-control @error('title') is-invalid @enderror" autocomplete='off' placeholder="Enter Title" >
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="name">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" >{{old('description')}}</textarea>
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
                                    <a href="{{ route('admin.web_album_image',['album_slug'=>$album->url]) }}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
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
@endsection