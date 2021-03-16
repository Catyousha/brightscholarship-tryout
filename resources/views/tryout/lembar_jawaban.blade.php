@extends('layouts.main')
@section('title', "Lembar Jawaban")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                @can('isAdmin')
                <div class="p-3">
                    <a href="{{route('tryout.peserta', $tryout->id)}}" class="btn btn-primary btn-sm">	&#8592; Kembali Ke Daftar Peserta</a>
                </div>
                @endcan
                <div class="card-header py-3">
                    <p class="h5 font-weight-bold text-gray-800 mb-3">Hasil Tryout</p>
                    <a @can('isAdmin') href="{{route('peserta.show', $usertryout[0]->user_id)}}" @endcan class="m-0 font-weight-bold text-primary">
                        {{\App\Models\User::where('id',$usertryout[0]->user_id)->first()->name}}
                    </a>
                    <p class="mt-3 font-weight-bold ">Skor rata-rata: {{round($usertryout[0]->avg_score, 1)}}</p>
                </div>
            </div>
        </div>

        @foreach ($tryout->sesi as $s)
            @if($s->istirahat != 1)
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card header p-3"  data-toggle="collapse" data-target="#collapse{{$s->id}}" aria-expanded="true" aria-controls="collapse{{$s->id}}">
                        <div class="d-flex justify-content-between">
                            <p class="m-0 font-weight-bold text-primary">{{$s->mapel->name}}</p>
                            <p class="m-0 font-weight-bold badge-lg badge-success badge-pill p-2">
                                Skor: {{$usertryout->firstWhere('sesi_id', $s->id)->score??0}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapse{{$s->id}}" class="collapse hide">
                @forelse (\App\Models\UserAnswer::where('tryout_id', $tryout->id)
                                                ->where('user_id', $usertryout[0]->user_id)
                                                ->where('sesi_id', $s->id)
                                                ->orderBy('question_id')
                                                ->get() as $jp)
                <div class="col-lg-12 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Soal No.{{$jp->question->question_num}}</h6>
                        </div>
                        <div class="card-body">
                            <div>
                                {!! $jp->question->question_text !!}
                            </div>
                            <div class="mt-4 d-flex flex-column">
                                @foreach ($jp->question->choice as $c)
                                <div class="form-check mb-2">
                                    <input class="await-answer form-check-input mr-3" type="radio" id="{{$c->id}}" value="{{$c->id}}" disabled  @if($jp->choice->id == $c->id) checked @endif>
                                    <label class="form-check-label
                                        @if($jp->choice->id == $c->id && !$c->correct) text-danger font-weight-bold
                                        @elseif($c->correct) text-success font-weight-bold
                                        @endif"
                                    for="{{$c->id}}">{{$c->choice_symbol}}. {!! $c->choice_text !!}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
            @endif
        @endforeach


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
@endpush
