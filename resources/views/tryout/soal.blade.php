@extends('layouts.main')
@section('title', "{$sesi->mapel->name} - Soal No.{$soal->question_num}")
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
        alert("Waktu Pengerjaan Telah Habis!");
        document.getElementById('submit-jawaban').submit();
        clearInterval(i);
      }

        $('#countdown').text(duration.hours() + " jam " + duration.minutes() + " menit " + duration.seconds() + " detik ")
        //$('#coundown').text(moment(duration).format("HH:mm", { trim: false }))
    }, interval);
    </script>
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Selamat Mengerjakan!') }}</h1>

    <!-- Main Content goes here -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{$tryout->name}}: {{$sesi->mapel->name}} Soal No. {{$soal->question_num}}</h6>
                    <h6 class="m-0 font-weight-bold">Sisa Waktu: <span id="countdown"><script>moment().format('MMMM Do YYYY, h:mm:ss a');</script></span></h6>
                </div>
                <div class="card-body">
                    <p>{!! $soal->question_text !!}</p>
                    <div class="mt-4 d-flex flex-column">
                        @foreach ($soal->choice as $c)
                        <div class="form-check mb-2">
                            <input class="await-answer form-check-input mr-3"
                            type="radio"
                            name="ans_{{$soal->question_num}}"
                            id="{{$c->id}}"
                            value="{{$c->id}}"
                            @if(Session::get("tryout_{$tryout->id}_sesi_{$sesi->id}.{$soal->id}") == $c->id)
                                checked
                            @endif>
                            <label class="form-check-label" for="{{$c->id}}">
                                {{$c->choice_symbol}}. {{$c->choice_text}}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex @if($soal->question_num == 1)justify-content-end @else justify-content-between @endif">
                        @if($soal->question_num != 1)
                        <a href="{{route('tryout.soal', ['id_tryout' => $tryout->id, 'no_soal' => $soal->question_num-1])}}" class="await-answer btn btn-primary">Sebelumnya</a>
                        @endif
                        @if(!$soal->terakhir)
                        <a href="{{route('tryout.soal', ['id_tryout' => $tryout->id, 'no_soal' => $soal->question_num+1])}}" class="await-answer btn btn-primary">Selanjutnya</a>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Navigasi Soal</h6>
                </div>
                <div class="card-body">
                    <ul class="nav-soal">
                        @foreach ($sesi->question as $q)
                        <li class="@if($q->question_num == $soal->question_num) active @endif">
                            <a href="{{route('tryout.soal', ['id_tryout' => $tryout->id, 'no_soal' =>$q->question_num])}}">
                                {{$q->question_num}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">

                        <p id="test">@php /*var_dump(Session::get("$tryout->id"))*/@endphp</p>
                        <form action="{{route('answer.submit')}}" method="POST" id="submit-jawaban">
                        @csrf
                        <input type="hidden" name="t_id" value="{{$tryout->id}}"/>
                        <input type="hidden" name="s_id" value="{{$sesi->id}}"/>
                        <!--small class="text-danger">Pastikan semua soal sudah dijawab!</small-->
                        <input type="submit" class="await-answer btn btn-success" value="Submit Pengerjaan">
                        </form>
                    </div>
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
<script>
    const answ = document.getElementsByName('{{"ans_$soal->question_num"}}');
    function s_ans(event){
        var await_comp = document.getElementsByClassName('await-answer');
        Array.from(await_comp).forEach((el) => {
            el.classList.add("disabled");
            el.disabled = true;
        });
        $.ajax({
            type:'POST',
            url:'/answer',
            data:{_token: "{{ csrf_token() }}",
                    t_id: {{$tryout->id}},
                    q_id: {{$soal->id}},
                    s_id: {{$sesi->id}},
                    c_id: event.target.value
                },
            success:function(data) {
                if(data.data != "timeout"){
                    Array.from(await_comp).forEach((el) => {
                    el.classList.remove("disabled");
                    el.disabled = false;
                });
                    console.log("200")
                }
                else{
                    alert("Waktu Pengerjaan Telah Habis!");
                    document.getElementById('submit-jawaban').submit();
                }
            },
            error: function(err){
                console.log(err)
                Location.reload()
            }
        });
    }
    Array.prototype.forEach.call(answ, function(radio) {
        radio.addEventListener('change', s_ans);
    });
</script>


@endpush
