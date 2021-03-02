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
                <div class="card-header py-3 d-flex justify-content-between">
                    <a href="{{route('peserta.show', $usertryout[0]->user_id)}}" class="m-0 font-weight-bold text-primary">{{$usertryout[0]->user->name}}</a>
                </div>
            </div>
        </div>

        @foreach ($tryout->sesi as $s)
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card header p-3">
                        <div class="d-flex justify-content-between">
                            <a class="m-0 font-weight-bold text-primary">{{$s->mapel->name}}</a>
                            <a class="m-0 font-weight-bold badge-lg badge-success badge-pill p-2">
                                Skor: {{\App\Models\UserTryout::where('user_id', $usertryout[0]->user_id)
                                                              ->where('sesi_id', $s->id)->first()
                                                              ->score??0
                                       }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                @forelse (\App\Models\UserAnswer::where('tryout_id', $tryout->id)->where('user_id', $usertryout[0]->user_id)->where('sesi_id', $s->id)->orderBy('question_id')->get() as $jp)
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
                                    for="{{$c->id}}">{{$c->choice_symbol}}. {{$c->choice_text}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
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
