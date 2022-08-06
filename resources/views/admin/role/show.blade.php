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
                 
                  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="badge badge-success">{{ $v->name }},</label>
                @endforeach
            @endif
        </div>
    </div>
</div>

                
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