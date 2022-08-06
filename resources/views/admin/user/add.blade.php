@extends('admin.layouts.lte')

@section('content')

    <!-- Main content -->
    <section class="content">
        @include('layouts.feedback')
      <div class="row col-lg-12">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-rose card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">{{__('Add')}} {{__('User')}}</h4>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 {!! Form::open(array('route' => 'admin.user.save','method'=>'POST')) !!}
                <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:<span class="text-danger">*</span></strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required'=>true)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:<span class="text-danger">*</span></strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','required'=>true)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Mobile:</strong>
            {!! Form::text('mobile', null, array('placeholder' => 'Mobile Number','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:<span class="text-danger">*</span></strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','required'=>true)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:<span class="text-danger">*</span></strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control','required'=>true)) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:<span class="text-danger">*</span></strong>
            <select name="role" class="form-control select2" style="width: 100%;" required="">
                <option value="">select Role</option>
                @foreach($roleListArray as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
              </div>
        </div>
        <!-- /.col-->
      </div>
      </div>
      <!-- ./row -->
    </section>
    
 
@endsection
@section('script_js')
<script>
    $(function () {

                                    $('.select2').select2();
                                    });
      </script>
@endsection