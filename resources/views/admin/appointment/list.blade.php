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
                @can('appointment-list') 
            <a href="{{ route('admin.appointment') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
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
                              Date
                          </th>
                          <th>
                              Info
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
                              {{$value->appointment_date}}
                          </td>
                          <td>
                             Name : {{$value->customer->name}}<br>
                              Mobile : {{$value->customer->mobile}}<br>
                              Start : {{$value->appointment_start_time}}<br>
                              End : {{$value->appointment_end_time}}<br>
                          </td>

                          <td>{!! getStatusLabel($value->status)!!}</td>
                           <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          <a class="dropdown-item" onclick="location.href = '{{route('admin.appointment.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          
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