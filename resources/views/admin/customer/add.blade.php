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
                        <div class="row">
                  <div class="col-sm-8 col-lg-8 col-md-8">
            <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="col-sm-4 col-lg-4 col-md-4">
              @can('customer-list')    
            <a href="{{ route('admin.customer') }}" class="btn btn-sm btn-primary processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-backward">&nbsp;</i>List
                
            </a>
              @endcan
              @can('customer-create')
                <a href="{{ route('admin.customer.add') }}" class="btn btn-sm btn-danger m-1" style="float: right;">
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                 </a>
              @endcan
            </div>
            </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.customer.save') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                            
                                <div class="col-md-6 form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{old('name')}}" required="" class="form-control @error('name') is-invalid @enderror" autocomplete='off' placeholder="Enter Name" >
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">GSTIN </label>
                                    <input type="text" name="gstin" value="{{old('gstin')}}" class="form-control @error('gstin') is-invalid @enderror" autocomplete='off' placeholder="Enter GSTIN" >
                                    @error('gstin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="name">Mobile No. <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" value="{{old('mobile')}}" required="" class="form-control @error('mobile') is-invalid @enderror" autocomplete='off' placeholder="Enter Mobile" >
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="name">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Description" >{{old('address')}}</textarea>
                                   @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="name">Pin code <span class="text-danger">*</span></label>
                                    <input type="text" name="pin_code" value="{{old('pin_code')}}" required="" class="form-control @error('pin_code') is-invalid @enderror" autocomplete='off' placeholder="Enter Pin Code" >
                                    @error('pin_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                               <div class="col-md-6 form-group">
                                                <label for="name">State</label>
                                                <select class="form-control select2" style="width: 100%" name="state_id" required="">
                                                    <option value="">Select</option>
                                                    @foreach($stateList as $value)
                                                    <option value="{{$value->id}}" @if(old('state_id') == $value->id) selected="" @endif>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                            </div>


                            </div>


                            <div class="clearfix">&nbsp;</div>
                            <div class="box-footer">
                                <div class="col-md-12" style="text-align: center">
                                     @can('customer-list') 
                                    <a href="{{route('admin.customer')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    @endcan
                                    @can('customer-create')
                                    <button type="submit" class="btn btn-warning submitBtn2"><i class="fa fa-save"></i> {{__('Save')}}</button>
                                     @endcan
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
@endsection