@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 10px">
            <div class="card-body">
            @foreach ($pics as $pic)
                <div class="float-left" style="margin-right: 20px; margin-bottom: 10px">
                    <img src="{{ $pic['url'] }}" class="rounded img-thumbnail" style="width: 200px; height: 130px">
                    <figcaption class="figure-caption" style="text-align: center;color: #FF0066; margin-top: 10px">{{ $pic['datetime'] }}</figcaption>
                </div>
            @endforeach
            <div style="clear: both"></div>
            </div>
            
        </div>
        
    </div>
    
</div>
@endsection
@push('scripts')
@endpush