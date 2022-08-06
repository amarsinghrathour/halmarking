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
                
            <a href="{{ route('admin.web_album') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
                <a href="{{ route('admin.web_album.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
            </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                          <th>
                              Sr.No
                          </th>
                          <th>
                              Title
                          </th>
                          <th>
                              Image
                          </th>
                          <th>
                              Sort Order
                          </th>
                          <th>
                              Status
                          </th>
                          <th>
                              Add Image
                          </th>
                          <th>
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      
                       @if(count($dataArray) > 0)
                        @php $i=0; @endphp
                    @foreach($dataArray as $value)
                    @php $i++; @endphp
                      <tr>
                          <td>
                              {{$i}}
                          </td>
                          <td>
                              {{$value->title}}
                          </td>
                          
                            <td>@if(!empty($value->image))<img src="{{asset($value->image)}}" class="img img-thumbnail" width="70px">@endif</td>

                          <td><input type="number" value="{{ $value->sort_order }}" onchange="changeSortOrder('{{$value->id}}',this);"></td>
                          <td>{!! getStatusLabel($value->status)!!}</td>
                          <td><a href="{{ route('admin.web_album_image',['album_slug'=>$value->url]) }}" class="btn btn-sm btn-info processing_btn">
                
                    <i class="fas fa-plus-circle">&nbsp;</i>Add Image
                
            </a></td>
                           <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          <a class="dropdown-item" onclick="location.href = '{{route('admin.web_album.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'web_albums')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'web_albums')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'web_albums')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
                                      </div>
                                  </button>
                              </div>
                          </td>
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



@endsection
@section('script_js')


<script>
    function changeSortOrder(id,elm){
        //$(elm).bootstrapSwitch('state', $(elm).prop('checked'));
        var order = $(elm).val();
         
        $.ajax({
           
            type: "post",
            url: "{{route('admin.web_album.sort_order.update')}}",
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