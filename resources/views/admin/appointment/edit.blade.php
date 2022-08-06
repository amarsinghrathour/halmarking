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
                            <h4 class="card-title">{{__('Edit')}} {{__('Appointment')}}</h4>
                            &nbsp;{!! getStatusLabel($data->status)!!}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('admin.appointment.update') }}" method="POST" id="saveProduct"  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label for="name">Appointment Date <span class="text-danger">*</span></label>
                                    <input type="date" name="appointment_date" required="" value="{{$data->appointment_date}}" class="form-control @error('appointment_date') is-invalid @enderror" autocomplete='off' required="" >
                                    @error('appointment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="name">Appointment Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="appointment_start_time" required="" value="{{$data->appointment_start_time}}" class="form-control @error('appointment_start_time') is-invalid @enderror datetimepicker3" autocomplete='off' required="" >
                                    @error('appointment_start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name">Appointment End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="appointment_end_time" required="" value="{{$data->appointment_end_time}}" class="form-control @error('appointment_end_time') is-invalid @enderror datetimepicker3" autocomplete='off' required="" >
                                    @error('appointment_end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               
                            </div>


                            <div class="clearfix">&nbsp;</div>
                            <div class="box-footer">
                                <div class="col-md-12" style="text-align: center">
                                    <a href="{{route('admin.appointment')}}" class="btn btn-primary"><i class="fa fa-backward"></i> {{__('Back')}}</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<script>


    $('#saveProduct').submit(function (e) {
        e.preventDefault();
        $('.submitBtn2').attr('disabled', true);
        $('.submitBtn2').html("<i class='fas fa-refresh fa-spin'></i> Updating...");


        $('#saveProduct').unbind('submit').submit();



    });
    
    $(function () {
             $('.datetimepicker3').datetimepicker({
                  format: 'HH:mm',
                   icons:
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            },
             });
             });
    </script>
@endsection