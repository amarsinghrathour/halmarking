@extends('admin.layouts.lte')
@section('style_css')
<!-- Font Awesome -->

@endsection
@section('content')
<section class="content">
    @include('layouts.feedback')
    
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
             @can('category-list')   
            <a href="{{ route('admin.category.list') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
             @endcan
             @can('category-create')
                <a href="{{ route('admin.category.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
             @endcan
            </div>
            </div>
          </div>
                     
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Is Top</th>
                <th>Sort Order</th>
                <th>Action</th>
                <th>Status</th>
              </tr>
              </thead>
              <tbody>
                  @if(count($categoryList) > 0)
                    @foreach($categoryList as $value)
                      <tr>
                          <td>{{ $value->title }}</td>
                          <td>{{ $value->description }}</td>
                          <td>@if(!empty($value->image))<img src="{{asset($value->image)}}" class="img img-thumbnail" width="70px">@endif</td>
                          <td> <input type="checkbox" value="{{ $value->id }}" name="my-checkbox" @if($value->is_top =='Y') checked='' @endif data-bootstrap-switch data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="NO">
                          </td> 
                          <td><input type="number" value="{{ $value->sort_order }}" onchange="changeSortOrder('{{$value->id}}',this);"></td>
                          <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          @can('category-edit')
                                          <a class="dropdown-item" href="#" onclick="location.href = '{{route('admin.category.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          @endcan
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'categories')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'categories')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          @can('category-delete')
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'categories')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
                                          @endcan
                                      </div>
                                  </button>
                              </div>
                          </td>
                          <td>@php echo getStatusLabel($value->status); @endphp</td>
                      </tr>
                    @endforeach
                  @endif
              </tbody>
              
            </table>
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
<!-- Modal -->


@endsection
@section('script_js')
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script>

              
          
 $('.select2').select2(); 
 
     $("input[data-bootstrap-switch]").bootstrapSwitch({
                onSwitchChange: function(e, state) {
                    var id = $(this).val();
             var is_top = 'N';
               if ($(this).prop('checked')==true){ 
               is_top = 'Y';
               }
            changeTopView(id,is_top);
                  }
                  });
     
    function changeTopView(id,is_top){
        //$(elm).bootstrapSwitch('state', $(elm).prop('checked'));
        
         console.log('called');
        $.ajax({
           
            type: "post",
            url: "{{route('admin.category.update.is_top')}}",
            dataType: "json",
            data: { id:id, is_top:is_top },
            cache: false,
            success: function(data) {
                if(data.status === "success")
                {
                    
                      swal({
                    title: "Success",
                    text: data.message,
                    type:'success',
                    timer: 2000
                  }); 
                   
                }
                else if(data.status === "expired")
                { swal("OOps!!!", "Session Expired!", "error"), function () {
                        location.reload();
                    };
                }
                else
                {
                   swal("OOps!!!", data.message, "error"), function () {
                        location.reload();
                    };
                }
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                if(textStatus == "timeout")
                {
                     swal("Timeout !", "We couldn't connect to the server ! ", "error");
                }
                else
                {
                     swal("Oops", "We couldn't connect to the server ! "+errorThrown, "error");
                }
              }
        });
        
    }
    
    function changeSortOrder(id,elm){
        //$(elm).bootstrapSwitch('state', $(elm).prop('checked'));
        var order = $(elm).val();
         
        $.ajax({
           
            type: "post",
            url: "{{route('admin.category.update.sort_order')}}",
            dataType: "json",
            data: { id:id, sort_order:order },
            cache: false,
            success: function(data) {
                if(data.status === "success")
                {
                    swal({
                    title: "Success",
                    text: data.message,
                    type:'success',
                    timer: 2000
                  });
                   
                }
                else if(data.status === "expired")
                {
                    
                    swal("OOps!!!", "Session Expired!", "error"), function () {
                        location.reload();
                    };
                }
                else
                {
                    swal("OOps!!!", data.message, "error"), function () {
                        location.reload();
                    };
                }
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                if(textStatus == "timeout")
                {
                     swal("Timeout !", "We couldn't connect to the server ! ", "error");
                }
                else
                {
                     swal("Oops", "We couldn't connect to the server ! "+errorThrown, "error");
                }
              }
        });
        
    }
              
</script>
@endsection
