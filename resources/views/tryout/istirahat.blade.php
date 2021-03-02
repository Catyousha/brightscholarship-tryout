@extends('layouts.main')
@section('title', "{$sesi->mapel->name}")
@push('css')
<style>
    ul {list-style-type: none;}
    .nav-soal {
        margin: 0;
    }

    .nav-soal li {
        list-style-type: none;
        display: inline-block;
        width: 20%;
        text-align: center;
        margin-bottom: 5px;
        font-size:12px;
        padding: 10px;
        border: 0.5px solid #4E73E1;
        color: #4E73E1;
        cursor: pointer;
    }

    .nav-soal .active {
        background-color: #4E73E1;
    }
    .nav-soal .active a {
        color: white !important;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script>
    var eventTime= {{$sesi->time_end->getTimestamp()}};
    var currentTime = {{\Carbon\Carbon::now()->getTimestamp()}};
    var diffTime = eventTime - currentTime;
    var duration = moment.duration(diffTime*1000, 'milliseconds');
    var interval = 1000;

    var i = setInterval(function(){
      duration = moment.duration(duration - interval, 'milliseconds');
      if(duration < 0){
        window.location.href = "{{ route('tryout.soal', ['id_tryout' => $tryout->id, 'no_soal' => 1])}}";
        clearInterval(i);
      }

        $('#countdown').text(duration.hours() + " jam " + duration.minutes() + " menit " + duration.seconds() + " detik ")
        //$('#coundown').text(moment(duration).format("HH:mm", { trim: false }))
    }, interval);
    </script>
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Waktunya Beristirahat!') }}</h1>

    <!-- Main Content goes here -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{$tryout->name}}: {{$sesi->mapel->name}}</h6>
                    <h6 class="m-0 font-weight-bold">Sisa Waktu Istirahat: <span id="countdown"><script>moment().format('MMMM Do YYYY, h:mm:ss a');</script></span></h6>
                </div>
                <div class="card-body">
                    <h1 class="text-center align-middle p-5">
                        <span>
                            <i class="fa fa-mug-hot" style="font-size:72px; margin-bottom: 20px;"></i>
                        </span>
                        <br>
                        ISTIRAHAT
                    </h1>
                </div>
            </div>

        </div>

    </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
    <div class="alert alert-success border-left-success" role="alert">
        {{ session('status') }}
    </div>
@endif
@endpush

@push('js')
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous">
</script>
@endpush
