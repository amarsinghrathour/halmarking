@extends('admin.layouts.lte')

@section('content')

    <!-- Main content -->
    <section class="content">
        @include('admin.layouts.feedback')
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
             @can('user-list')   
            <a href="{{ route('admin.user') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
             @endcan
             @can('user-create')
                <a href="{{ route('admin.user.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
             @endcan
            </div>
            </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                  @php $i=0; @endphp
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                   
                    <th>{{__('S. No')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('User Id')}}</th>
                    <th>{{__('Role')}}</th>
                    <th>{{__('Created Date')}}</th>
                     <th>Action</th>
                     <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($userListArray as $value)
                      @php ++$i; @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }} @can('user-edit')<button class="btn btn-sm btn-success btn-round pull-right" onclick="viewModalChangePwd({{$value->id}})">{{__('Change Password')}}</button>@endcan</td>
                            <td>{{$value->role->name}}</td>
                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y')}}</td>
                            <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                      Action
                                      <span class="sr-only">Toggle Dropdown</span>
                                      <div class="dropdown-menu" role="menu">
                                          @can('user-edit')
                                          <a class="dropdown-item" href="#" onclick="location.href = '{{route('admin.user.edit',['id'=>$value->id])}}';" ><i class="fas fa-edit">&nbsp;</i>Edit</a>
                                          @endcan
                                          @if($value->status != 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'ACTIVE', 'admins')"><i class="fas fa-check-square">&nbsp;</i>Activate</a>
                                          @endif
                                          @if($value->status == 'ACTIVE')
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'INACTIVE', 'admins')"><i class="fas fa-ban">&nbsp;</i>Deactivate</a>
                                          @endif
                                          @can('user-delete')
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->id }}', 'DELETED', 'admins')"><i class="fas fa-trash">&nbsp;</i>Delete</a>
                                          @endcan
                                      </div>
                                  </button>
                              </div>
                          </td>
                          <td>{!! getStatusLabel($value->status) !!}</td>
                        </tr>
                      @endforeach
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
    <!-- /.content -->
  


<div class="modal" id="changePwdmodal" tabindex="-1" role="dialog" aria-labelledby="changePwdmodalModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{ route('admin.user.updatepwd') }}" id="ChangePwdForm" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleTitle">{{__('Change Password')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                X
        </button>
      </div>
      <div class="modal-body">
          @csrf
          
          <div id="viewuserid">
          </div>
             <div class="col-sm-6 form-group">
                <label>{{__('Password')}} *</label>
                <input type="password" name="password" id="password" autocomplete="off" required="" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" >
                        @error('password')
                            <span class="error invalid-feedback">
                                *{{ $message }}
                            </span>
                        @enderror
              </div>
                       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn btn-warning submitBtn">{{__('Change')}}</button>
      </div>
        </form>
    </div>
  </div>
</div>


@endsection
@section('script_js')
<script>
    function viewModalChangePwd(id){
        $('#viewuserid').html('<input type="hidden" name="user_id" value="'+id+'">');
        $('#changePwdmodal').modal();
    }
</script>
@endsection
