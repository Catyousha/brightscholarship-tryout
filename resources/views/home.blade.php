@extends('layouts.main')
@section('title', "Dashboard")

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

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

    @can('isStudent')
    <div class="row">
        @foreach ($tryout as $t)
        @php
        $stat = $t->tryout_css( $t->tryout_status() )
        @endphp
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card {{$stat->border_pinggir}} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">{{$t->name}}</div>
                            <div class="text-xs font-weight-bold {{$stat->teks}} mb-1">
                                {{$t->time_start->translatedFormat('d/m/Y')}} {{$t->time_start->translatedFormat('H:i')}} WIB
                                <br>s/d<br>
                                {{$t->time_end->translatedFormat('d/m/Y')}} {{$t->time_end->translatedFormat('H:i')}} WIB
                            </div>
                            <span class="badge badge-pill {{$stat->badge}} mb-2">Status: {{$t->tryout_status()}}</span>
                            @if($t->tryout_status() == "Telah Diselesaikan")
                            <span class="badge badge-pill {{$stat->badge}} mb-2">Skor: {{$t->user_score() ?? 0}}/100</span>
                            @endif
                            @if($t->tryout_status() == "Sedang Berlangsung")
                            <a class="btn btn-sm {{$stat->btn}} btn-block" href="{{route('tryout.soal', ['id_tryout' => $t->id, 'no_soal' => 1])}}">Kerjakan</a>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endcan
@endsection
