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
             @can('role-list')   
            <a href="{{ route('admin.roles') }}" class="btn btn-sm btn-danger processing_btn m-1" style="float: right;">
                
                    <i class="fas fa-sync">&nbsp;</i>Refresh
                
            </a>
             @endcan
             @can('role-create')
                <a href="{{ route('admin.roles.add') }}" class="btn btn-sm btn-info m-1" style="float: right;">
                    <i class="fas fa-plus-circle">&nbsp;</i>Add
                 </a>
             @endcan
            </div>
            </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                  @php $i=0;@endphp
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                   
                    <th>{{__('Sr. No')}}</th>
                    <th>{{__('Role')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($userListArray as $value)
                        <tr>
                             <td>{{ ++$i }}</td>
                             <td>{{ $value->name }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('admin.roles.show',$value->id) }}"><i class="fa fa-eye"></i></a> 
                            @can('role-edit')
                                <a class="btn btn-primary" href="{{ route('admin.roles.edit',$value->id) }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('role-delete')
                                {!! Form::open(['method' => 'get','route' => ['admin.roles.destroy', $value->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                {!! Form::close() !!}
                            @endcan
                        </td>
                        </tr>
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Role Id')}}</th>
                    <th>{{__('Created Date')}}</th>
                   
                  </tr>
                  </tfoot>
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
  




@endsection
@section('js')


@endsection
