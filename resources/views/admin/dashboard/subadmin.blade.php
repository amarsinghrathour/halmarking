@extends('layouts.material')
@section('Mainheader')
<div class="navbar-wrapper">
            <div class="navbar-minimize">
               <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                  <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                  <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                  <div class="ripple-container"></div>
               </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
         </div>
         <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
         <span class="sr-only">Toggle navigation</span>
         <span class="navbar-toggler-icon icon-bar"></span>
         <span class="navbar-toggler-icon icon-bar"></span>
         <span class="navbar-toggler-icon icon-bar"></span>
         </button>
         <div class="collapse navbar-collapse justify-content-end">
           
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" href="javascript:;">
                     <i class="material-icons">dashboard</i>
                     <p class="d-lg-none d-md-block">
                        Stats
                     </p>
                  </a>
               </li>
               
               <li class="nav-item dropdown">
                  <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="material-icons">person</i>
                     <p class="d-lg-none d-md-block">
                        Account
                     </p>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                     
                     <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </div>
               </li>
            </ul>
         </div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">memory</i>
                    </div>
                    <p class="card-category">Total Machines</p>
                    <h3 class="card-title">{{App\Http\Models\MachineModel::count()}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons text-danger">delete_sweep</i> Deleted {{App\Http\Models\MachineModel::where('status','=','DELETED')->count()}}
                    </div>
                      <div class="stats">
                      <i class="material-icons text-warning">list</i> Inactive {{App\Http\Models\MachineModel::where('status','=','INACTIVE')->count()}}
                    </div>
                  </div>
                </div>
              </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">memory</i>
                    </div>
                    <p class="card-category">Assigned Machines</p>
                    <h3 class="card-title">{{$assignedMachineTotal}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons text-danger">delete_sweep</i> Deleted {{$assignedMachineDeleted}}
                    </div>
                      <div class="stats">
                      <i class="material-icons text-warning">list</i> Inactive {{$assignedMachineInactive}}
                    </div>
                  </div>
                </div>
              </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">equalizer</i>
                    </div>
                    <p class="card-category">Total Sale</p>
                    <h3 class="card-title">&#x20B9; {{$soldAmt}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">local_offer</i> Quantity - {{$soldQty}}
                    </div>
                  </div>
                </div>
              </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">equalizer</i>
                    </div>
                    <p class="card-category">Last 30 Days Sale</p>
                    <h3 class="card-title">&#x20B9; {{$soldAmtLast30}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">local_offer</i> Quantity - {{$soldQtyLast30}}
                    </div>
                  </div>
                </div>
              </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">equalizer</i>
                    </div>
                    <p class="card-category">Last 15 Days Sale</p>
                    <h3 class="card-title">&#x20B9; {{$soldAmtLast15}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">local_offer</i> Quantity - {{$soldQtyLast15}}
                    </div>
                  </div>
                </div>
              </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">equalizer</i>
                    </div>
                    <p class="card-category">Last 7 Days Sale</p>
                    <h3 class="card-title">&#x20B9; {{$soldAmtLast7}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">local_offer</i> Quantity - {{$soldQtyLast7}}
                    </div>
                  </div>
                </div>
              </div>
    <div class="clearfix">&nbsp;</div>
    <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-icon card-header-rose">
                    <div class="card-icon">
                      <i class="material-icons">insert_chart</i>
                    </div>
                    <h4 class="card-title">Product Sale
                      <small>- Analytics</small>
                    </h4>
                  </div>
                  <div class="card-body">
                    <div id="productAnalytics" class="ct-chart"></div>
                  </div>
                </div>
              </div>
    <div class="clearfix">&nbsp;</div>
    <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Machine Sale
                      <small> - Analytics</small>
                    </h4>
                  </div>
                  <div class="card-body">
                    <div id="machineSaleAnalytics" class="ct-chart">
                  </div>
                </div>
              </div>
    </div>
    <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">trending_up</i>
                  </div>
                  <h4 class="card-title">Latest Sales</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--                 -->
                  </div>
                  <div class="material-datatables">
                      @if(count($latesSale) > 0)
                      <table class="table table-bordered table-striped example1">
                  <thead>
                 <tr class="text-white bg-primary">
                   <th><strong>Product Name</strong></th>
                    <th><strong>Product Image</strong></th>
                    <th><strong>Machine</strong></th>
                    <th><strong>Quantity</strong></th>
                    <th><strong>Sale Amount</strong></th>
                    <th><strong>Sale Date</strong></th>
                   
                   
                  </tr>
                  </thead>
                  <tbody>
                     @foreach($latesSale as $value) 
                     <tr>
                         <td>{{ App\Http\Models\ProductModel::find($value->product_id)->name }}</td>
                         <td><img src="{{ url('').'/'.App\Http\Models\ProductModel::find($value->product_id)->image }}" width="130" height="80"></td>
                     <td>{{ App\Http\Models\MachineModel::find($value->machine_id)->name }}</td>
                     <td>
                       {{$value->quantity}}  
                     </td>
                     <td>
                       &#x20B9; {{$value->payable_amount}}  
                     </td>
                    <td>
                                {{\Carbon\Carbon::parse($value->created_date)->format('d/m/Y')}}
                     </td>
                            
                     
                     </tr>
                     @endforeach
                  </tbody>
                  <tfoot>
                 <tr class="text-white bg-primary">
                     
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Machine</th>
                     <th>Quantity</th>
                     <th>Sale Amount</th>
                    <th>Sale Date</th>
                    
                    
                  </tr>
                  </tfoot>
                </table>
                      @else
                      <h4>No Sales yet</h4>
                      @endif
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
              
            </div>
@endsection
@section('js')
<!-- jQuery -->

<!-- DataTables -->
<script src="{{ asset('material/assets/js/plugins/jquery.dataTables.min.js') }}"></script>

<!-- page script -->
<script>
  $(function () {
    $(".example1").DataTable({
     "pagingType": "full_numbers",
     
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        },
        "order": [], //Initial no order.
         "aaSorting": [],
    });
    
  });
</script>
<script>
    $(function() {
    var dataMultipleBarsChart = {
                labels: [
                    @foreach ($productList as $value)
                    [ "{{ $value->name }}"], 
                  @endforeach  
                ],
                series: [
                    @foreach ($productList as $value)
                    @php($cartData = App\Http\Controllers\Api\Models\CartModel::where('status','DISPENSED')->where('product_id',$value->id)->get())
                    [ "{{ $cartData->sum('payable_amount') }}"], 
                  @endforeach
                ]
            };

            var optionsMultipleBarsChart = {
                seriesBarDistance: 10,
                axisX: {
                    showGrid: false
                },
                height: '300px'
            };

            var responsiveOptionsMultipleBarsChart = [
                ['screen and (max-width: 640px)', {
                    seriesBarDistance: 5,
                    axisX: {
                        labelInterpolationFnc: function(value) {
                            return value[0];
                        }
                    }
                }]
            ];

            var multipleBarsChart = Chartist.Bar('#productAnalytics', dataMultipleBarsChart, optionsMultipleBarsChart, responsiveOptionsMultipleBarsChart);

            
            md.startAnimationForBarChart(multipleBarsChart);
            
      /*  **************** Coloured Rounded Line Chart - Line Chart ******************** */


            dataColouredBarsChart = {
                labels: [
                    @foreach ($machineList as $value)
                     "{{ $value->name }}", 
                  @endforeach 
                ],
                series: [
                    [
                        @foreach ($machineList as $value)
                    @php($cartData = App\Http\Controllers\Api\Models\CartModel::where('status','DISPENSED')->where('machine_id',$value->id)->get())
                     "{{ $cartData->sum('payable_amount') }}",
                  @endforeach
                    ],
                    
                ]
            };

            optionsColouredBarsChart = {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 10
                }),
                axisY: {
                    showGrid: true,
                    offset: 40
                },
                axisX: {
                    showGrid: false,
                },
                low: 0,
                high: 1000,
                showPoint: true,
                height: '300px'
            };


            var colouredBarsChart = new Chartist.Line('#machineSaleAnalytics', dataColouredBarsChart, optionsColouredBarsChart);

            md.startAnimationForLineChart(colouredBarsChart);



            });
    </script>
@endsection

