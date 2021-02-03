@extends('layouts.main')

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

    <div class="row">
        @foreach ($tryout as $t)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">{{$t->name}}</div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{$t->time_start->translatedFormat('d M Y')}}<br>{{$t->time_start->translatedFormat('H:m')}} - {{$t->time_end->translatedFormat('H:m')}}</div>
                            <span class="badge badge-pill badge-primary mb-2">Status: {{$t->tryout_status()}}</span>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.index')}}">Kerjakan</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Try Out 1</div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">27 Februari 2021<br>08:00 - 09:00</div>
                            <span class="badge badge-pill badge-primary mb-2">Status: Sedang Berlangsung</span>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.index')}}">Kerjakan</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Try Out 2</div>
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">28 Februari 2021<br>08:00 - 09:00</div>
                            <span class="badge badge-pill badge-secondary mb-2">Status: Dijadwalkan</span>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Try Out 3</div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">02 Februari 2021<br>08:00 - 09:00</div>
                            <span class="badge badge-pill badge-success mb-2">Status: Telah Selesai</span>
                            <span class="badge badge-info mb-2">Skor: 90/100</span>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
