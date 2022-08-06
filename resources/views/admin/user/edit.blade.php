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
                    <div class="row">
                  <div class="col-sm-8 col-lg-8 col-md-8">
            <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="col-sm-4 col-lg-4 col-md-4">
             @can('user-list')   
            <a href="{{ route('admin.user') }}" class="btn btn-sm btn-primary processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-backward">&nbsp;</i>Back
                
            </a>
             @endcan
             
            </div>
            </div>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 {!! Form::model($user, ['method' => 'POST','route' => ['admin.user.update', $user->id]]) !!}
                 <input type="hidden" name="id" value="{{$user->id}}">
                 <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:<span class="text-danger">*</span></strong>
            <select name="role" class="form-control select2" style="width: 100%;" required="">
                <option value="">select Role</option>
                @foreach($roleListArray as $value)
                <option value="{{$value->id}}" @if($user->role_id == $value->id) selected='' @endif>{{$value->name}}</option>
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
@section('js')
<script>
    $(function () {

                                    $('.select2').select2();
                                    });
      </script>
@endsection