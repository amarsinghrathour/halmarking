@extends('admin.layouts.lte')
@section('style_css')
<!-- Font Awesome -->
<link href="{!! asset('css/menu.css') !!} " media="all" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<section class="content">
    @include('layouts.feedback')
    <script>
    var _BASE_URL = "{{url('/admin')}}";
    var current_group_id = 1;
    </script>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-sm-8 col-lg-8 col-md-8">
            <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="col-sm-4 col-lg-4 col-md-4">
                
            <a href="{{ route('admin.web_menu') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
                <a href="{{ route('admin.web_menu.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
            </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              <form method="post" id="form-menu" action="{{route('admin.web_menu.position')}}">
                  @csrf
                        @if(!empty($dataArray))
                            {!! $dataArray !!}
                        @endif

                        <div class="box-header">
                            <div class="col-lg-6 form-inline" id="contact-form">
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            
                            <div class="pull-right">
                                <button type="submit" id="btn-save-menu" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                     </form>
                  
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<div class="modal fade" id="deleteMenumodal" tabindex="-1" role="dialog" aria-labelledby="deleteMenumodalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Menu</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="{{route('admin.web_menu.delete')}}">
                            @csrf
                            <input type="hidden" name="id" id="menu_id" value="">
                        <div class="modal-body">
                            <p>Are You Sure?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteProduct">{{ __('Delete') }}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


@endsection
@section('script_js')
    <script src="{!! asset('plugins/sort/jquery-ui-1.10.3.custom.min.js') !!}"></script>
    <script src="{!! asset('plugins/sort/jquery.ui.touch-punch.min.js') !!}"></script>
    <script src="{!! asset('plugins/sort/jquery.mjs.nestedSortable.js') !!}"></script>
    <script src="{!! asset('plugins/sort/menu.js') !!}"></script>

    <script>
        
          function deleteMenu(menu_id){
              
            $("#menu_id").val(menu_id);
            $('#deleteMenumodal').modal('show');
        }  
            
      
        
        </script>
    
    
@endsection