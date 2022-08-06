@extends('admin.layouts.lte')

@section('content')

    <!-- Main content -->
    <section class="content">
        @include('layouts.feedback')
      <div class="row col-lg-12">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-rose card-header-text">
                  <div class="row">
                  <div class="col-sm-8 col-lg-8 col-md-8">
            <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="col-sm-4 col-lg-4 col-md-4">
             @can('role-create')   
            <a href="{{ route('admin.roles.add') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
             @endcan
             @can('role-list')
                <a href="{{ route('admin.roles') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-backward">&nbsp;</i>Back
                 </a>
             @endcan
            </div>
            </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                  {!! Form::open(array('route' => 'admin.roles.save','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        
            <h4>Permissions:</h4>
            <hr>
            </div>
            @foreach($permissionListArray as $value)
            <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="custom-control custom-checkbox">
                <input name="permission[]" value="{{$value->id}}" class="custom-control-input custom-control-input-success" checked="" type="checkbox" id="customCheckbox{{$value->id}}">
            <label for="customCheckbox{{$value->id}}" class="custom-control-label">
                {{ $value->name }}</label>
             </div>
             </div>
            @endforeach
       
    
    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-5 mb-3">
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
@section('js')
<script>
    $(function () {

                                    $('.select2').select2();
                                    });
      </script>
@endsection