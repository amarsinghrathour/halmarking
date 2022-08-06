@if ($message = session()->get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Success!</h5>
    {{ $message }}
    {{ session()->forget('success') }}
</div>
@endif
  
@if ($message = session()->get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i> Danger!</h5>
    {{ $message }}
    {{ session()->forget('error') }}
</div>
@endif
   
@if ($message = session()->get('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-exclamation-triangle"></i> Warning!</h5>
    {{ $message }}
    {{ session()->forget('warning') }}
</div>
@endif
   
@if ($message = session()->get('info'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Info!</h5>
    {{ $message }}
    {{ session()->forget('info') }}
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <span><i class="fa fa-ban text-white"></i> <b>{{__('Danger')}} - </b>{{__('Please check below errors')}}</span>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif