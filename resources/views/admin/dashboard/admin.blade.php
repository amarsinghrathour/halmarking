@extends('admin.layouts.lte')
@section('style_css')

@endsection
@section('content')
<!-- Main content -->
<section class="content">
    @include('layouts.feedback')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
             <div class="col-12">

        <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-sm-8 col-lg-8 col-md-8">
                      <h3 class="card-title"><span class="text-info">Recent</span> Enquiry</h3>
            </div>
            <div class="col-sm-4 col-lg-4 col-md-4">
            
                
            </div>
            </div>
          </div>
         
        </div>
        <!-- /.card -->
      </div>
            
            
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('script_js')

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
@endsection