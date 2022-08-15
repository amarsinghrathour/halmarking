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
                
            <a href="{{ route('admin.job.list') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
                <a href="{{ route('admin.job.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
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
                              Job No
                          </th>
                          <th>
                              Product Type
                          </th>
                          <th>
                              Purity
                          </th>
                          <th>
                              No Of Product
                          </th>
                          <th>
                              Lot Size
                          </th>
                          <th>
                              Created Date
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
                      
                       @if(count($jobList) > 0)
                        @php $i=0; @endphp
                    @foreach($jobList as $value)
                    @php $i++; @endphp
                      <tr>
                          <td>
                              {{$i}}
                          </td>
                          <td>
                              {{$value->job_no}}
                          </td>
                          
                          <td>
                              {{$value->product_type}}
                          </td>
                          <td>
                              {{$value->purity}}
                          </td>
                          <td>
                              {{$value->no_of_products}}
                          </td>
                          <td>
                              {{$value->lot_size}}
                          </td>

                          <td>{{$value->created_at->format('d-M-Y')}}</td>
                          <td>{!! getStatusLabel($value->status)!!}</td>
                           <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          <a class="dropdown-item" onclick="location.href = '{{route('admin.job.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'jobs')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'jobs')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'jobs')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
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


@endsection