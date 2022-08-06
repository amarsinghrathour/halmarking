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
              @can('web_post-list')  
            <a href="{{ route('admin.web_post') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
              @endcan
              @can('web_post-create') 
                <a href="{{ route('admin.web_post.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
              @endcan
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
                              Url
                          </th>
                          <th>
                              Category
                          </th>
                          <th>
                              Status
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
                          <td>
                              {{$value->url}}
                          </td>
                          <td>
                              {{$value->category->title}}
                          </td>

                          <td>{!! getStatusLabel($value->status)!!}</td>
                           <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          @can('web_post-edit')
                                          <a class="dropdown-item" onclick="location.href = '{{route('admin.web_post.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          @endcan
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'web_contents')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'web_contents')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          @can('web_post-delete')
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'web_contents')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
                                          @endcan
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
                                 
                                    
                                    

                                    
                                                                    </script>

@endsection