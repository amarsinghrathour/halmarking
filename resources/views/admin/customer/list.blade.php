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
              @can('customer-list')  
            <a href="{{ route('admin.customer') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
               @endcan
               {{--
                @can('customer-create')
                <a href="{{ route('admin.customer.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
                @endcan
                --}}
            </div>
            </div>
          </div>
                     
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Name</th>
                <th>Mobile No.</th>
                <th>Email</th>
                <th>User Name</th>
                <th>Action</th>
                <th>Status</th>
              </tr>
              </thead>
              <tbody>
                  @if(count($customerList) > 0)
                    @foreach($customerList as $value)
                      <tr>
                          <td>{{ $value->name }}</td>
                          <td>{{ $value->mobile }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->user_name }}</td>
                          <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          @can('customer-edit')
                                          <a class="dropdown-item" href="#" onclick="location.href = '{{route('admin.customer.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          @endcan
                                          @can('customer-create')
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'customers')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'customers')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'customers')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
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
<script>

              
          
 $('.select2').select2(); 
 
    
    
              
</script>
@endsection
