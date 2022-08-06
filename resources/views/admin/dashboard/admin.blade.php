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
                
            <a href="{{ route('admin.enquiry') }}" class="btn btn-sm btn-info processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-hand-right">&nbsp;</i>View More
                
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
                              Contact Info
                          </th>
                          <th>
                              Subject
                          </th>
                          <th>
                              Message
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
                      
                       @if(count($enquiryArray) > 0)
                        @php $i=0; @endphp
                    @foreach($enquiryArray as $value)
                    @php $i++; @endphp
                      <tr>
                          <td>
                              {{$i}}
                          </td>
                          <td>
                              Name : {{$value->name}}<br>
                              Mobile : {{$value->mobile}}<br>
                              Email : {{$value->email}}<br>
                              
                          </td>
                          <td>
                              {{$value->subject}}
                          </td>
                          <td>
                              {{$value->message}}
                          </td>

                          <td>{!! getStatusLabel($value->status)!!}</td>
                           <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'enquiries')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'enquiries')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'enquiries')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
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