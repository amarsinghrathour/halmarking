@extends('admin.layouts.lte')
@section('style_css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

@endsection
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
              @can('slot-list')    
            <a href="{{ route('admin.slot') }}" class="btn btn-sm btn-primary processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-backward">&nbsp;</i>List
                
            </a>
              @endcan
              @can('slot-create')
                <a href="{{ route('admin.slot.add') }}" class="btn btn-sm btn-danger m-1" style="float: right;">
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                 </a>
              @endcan
            </div>
            </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.slot.save') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                            
                                <div class="col-md-6 form-group">
                                    <label for="name">Slot Date <span class="text-danger">*</span></label>
                                    <input type="date" name="slot_date" value="{{old('slot_date')}}" required="" class="form-control @error('slot_date') is-invalid @enderror" autocomplete='off' placeholder="Enter Date" >
                                    @error('slot_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Duration/Interval <span class="text-danger">*(Minutes)</span> </label>
                                    <input type="number" min="1" name="interval" value="{{old('interval')}}" class="form-control @error('interval') is-invalid @enderror" autocomplete='off' placeholder="Enter Appointment slot duration" >
                                    @error('interval')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Start Time <span class="text-danger">*</span> </label>
                                    <input id="datetimepicker2" type="text" timeformat="24h" name="start_time" value="{{old('start_time')}}" class="form-control @error('start_time') is-invalid @enderror" autocomplete='off' placeholder="Enter Appointment start time" >
                                    @error('start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="name">End Time <span class="text-danger">*</span> </label>
                                    <input type="text" id="datetimepicker3" name="end_time" value="{{old('end_time')}}" class="form-control @error('end_time') is-invalid @enderror" autocomplete='off' placeholder="Enter Appointment end time" >
                                    @error('end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                

                            </div>


                            <div class="clearfix">&nbsp;</div>
                            <div class="box-footer">
                                <div class="col-md-12" style="text-align: center">
                                     @can('slot-list') 
                                    <a href="{{route('admin.slot')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
                                    @endcan
                                    @can('slot-create')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

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


         $(function () {
             $('#datetimepicker3').datetimepicker({
                  format: 'HH:mm',
                   icons:
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            },
             });
             $('#datetimepicker2').datetimepicker({
                  format: 'HH:mm',
                   icons:
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            },
             });
         });
      

$('.select2').select2(); 
</script>

@endsection