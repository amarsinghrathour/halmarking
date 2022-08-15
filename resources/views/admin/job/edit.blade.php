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
                            <h4 class="card-title">{{__('Edit')}} {{__('Job')}}</h4>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.job.update') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label for="name">Job Number <span class="text-danger">*</span></label>
                                    <input type="text" name="job_number" value="{{$data->job_no}}" required="" class="form-control @error('job_number') is-invalid @enderror" autocomplete='off' placeholder="Enter Job Number" >
                                    @error('job_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                    @php
                                        $productType = getProductType();
                                        $productPurity = getProductPurity();
                                        $productLot = getProductLot();
                                        @endphp                            
                               <div class="col-md-6 form-group">
                                    <label for="name">Product type <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="product_type">
                                        <option value="">Select</option>
                                        
                                        @foreach($productType as $key => $value)
                                        <option value="{{$key}}" @if($data->product_type == $key) selected="" @endif>{{$value}}</option>
                                        @endforeach
                                        
                                    </select>                                    
                                    @error('product_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                        
                                        <div class="col-md-6 form-group">
                                    <label for="name">Product Purity <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="product_purity">
                                        <option value="">Select</option>
                                        
                                        @foreach($productPurity as $key => $value)
                                        <option value="{{$key}}" @if($data->purity == $key) selected="" @endif>{{$value}}</option>
                                        @endforeach
                                        
                                    </select>                                    
                                    @error('product_purity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                        
                                <div class="col-md-6 form-group">
                                    <label for="name">No Of Product <span class="text-danger">*</span></label>
                                    <input type="number" name="no_of_product" value="{{$data->no_of_products}}" required="" class="form-control @error('no_of_product') is-invalid @enderror" autocomplete='off' placeholder="Enter No Of Product" >
                                    @error('no_of_product')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="name">Product Lot <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="product_lot">
                                        <option value="">Select</option>
                                        
                                        @foreach($productLot as $key => $value)
                                        <option value="{{$key}}" @if($data->lot_size == $key) selected="" @endif>{{$value}}</option>
                                        @endforeach
                                        
                                    </select>                                    
                                    @error('product_lot')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                            </div>


                            <div class="clearfix">&nbsp;</div>
                            <div class="box-footer">
                                <div class="col-md-12" style="text-align: center">
                                    <a href="{{route('admin.job.list')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    <button type="submit" class="btn btn-warning submitBtn2"><i class="fa fa-send-o"></i> {{__('Update')}}</button>

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
        $('.submitBtn2').html("<i class='fas fa-refresh fa-spin'></i> Updating...");


        $('#saveProduct').unbind('submit').submit();



    });
   


</script>

@endsection