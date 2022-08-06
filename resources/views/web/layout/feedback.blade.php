@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="fa fa-times-circle-o"></i>
                    </button>
    <span><i class="fa fa-check text-white"></i> <b>Success - </b> {{ $message }}</span>
    
    {{ session()->forget('success') }}
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="fa fa-times-circle-o"></i>
                    </button>
    <span><i class="fa fa-ban text-white"></i><b> Error - </b> {{ $message }}</span>
    {{ session()->forget('error') }}
</div>
@endif
   
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="fa fa-times-circle-o"></i>
                    </button>
    <span><i class="fa fa-exclamation-triangle text-white"></i> <b>Warning - </b> {{ $message }}</span>
    
    {{ session()->forget('warning') }}
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="fa fa-times-circle-o"></i>
                    </button>
    <span><i class="fa fa-info text-white"></i> <b>Info - </b> {{ $message }}</span>
    
    {{ session()->forget('info') }}
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="fa fa-times-circle-o"></i>
                    </button>
    <span><i class="fa fa-ban text-white"></i> <b>Danger - </b>Please check below errors</span>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif