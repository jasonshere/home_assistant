@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://d3q5poti6uedt7.cloudfront.net/js/gcal.js"></script>
<script>
   $(function() {
    $('#calendar').fullCalendar({
        googleCalendarApiKey: 'AIzaSyCIrfAjU4pSXQ0m67dlY6sQY4ITei2qPpA',
        events: {
        googleCalendarId: 'mrjasonedu@gmail.com',
        className: 'gcal-event' // an option!
        }
    });
    });
</script>
@endpush