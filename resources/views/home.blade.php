@extends('layouts.main')
@section('title', "Dashboard")

@section('main-content')

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

    @can('isAdmin')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2 mr-3">
                            <i class="fas fa-copy fa-2x text-gray-300" style="font-size: 50px;"></i>
                        </div>
                        <div class="col md-10">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Manajemen Tryout</div>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.index')}}">Lihat Daftar Tryout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2 mr-3">
                            <i class="fas fa-user fa-2x text-gray-300" style="font-size: 50px;"></i>
                        </div>
                        <div class="col md-10">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Manajemen Peserta</div>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('peserta.index')}}">Lihat Daftar Peserta</a>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('peserta.tunggu')}}">Lihat Daftar Tunggu Validasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2 mr-3">
                            <i class="fas fa-balance-scale fa-2x text-gray-300" style="font-size: 50px;"></i>
                        </div>
                        <div class="col md-10">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Manajemen Pembobotan</div>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('bobot.index')}}">Lihat Daftar Pembobotan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2 mr-3">
                            <i class="fas fa-trophy fa-2x text-gray-300" style="font-size: 50px;"></i>
                        </div>
                        <div class="col md-10">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">Pemeringkatan</div>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.rank', ['name' => 'SAINTEK'])}}">Lihat Pemeringkatan SAINTEK</a>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.rank', ['name' => 'SOSHUM'])}}">Lihat Pemeringkatan SOSHUM</a>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.rank', ['name' => 'CAMPURAN'])}}">Lihat Pemeringkatan CAMPURAN</a>
                            <a class="btn btn-sm btn-primary btn-block" href="{{route('tryout.rank', ['name' => 'ALL'])}}">Lihat Semua Pemeringkatan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endcan

    @can('isStudent')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Selamat datang di BrightScholarship Tryout!') }}</h1>
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <a class="btn btn-sm btn-primary btn-block" href="https://zoom.us/j/94971570713?pwd=Q0VON0dLeVA1ZThid2NyOHRjaVl5QT09">Link Zoom</a>
                    <a class="btn btn-sm btn-success btn-block" href="https://drive.google.com/file/d/14oaJA49d-BT8EVK9XL-GqfSMXgIOcawz/view">Unduh Sertifikat</a>
                </div>
            </div>
        </div>
    </div>
    @if($peserta_tryout != null)
    <h1 class="h5 mb-4 text-gray-500">{{ __('Selamat kepada 3 besar {{Auth::user()->pilihan->name}}!') }}</h1>
    <div class="row">
        @php $rank = 1; @endphp
        @foreach($peserta_tryout as $pt)
        @php
        $user = \App\Models\User::where('id', $pt->user_id)->first();
        @endphp
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2 mr-3">
                            @if($user->foto_profil != null)
                            <img  class="img-profile rounded-circle avatar" src="{{url('storage/foto_profil/'.$user->foto_profil) }}" />
                            @else
                            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ $user->name[0] }}"></figure>
                            @endif
                        </div>
                        <div class="col md-10">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-1">{{$user->name}}</div>
                            <div class="text-sm font-weight-bold text-gray-700 mb-1">{{$user->asal_sekolah}}</div>
                            <div class="text-xs mb-1 font-weight-bold text-gray-700">Ranking #{{$rank}} {{$user->pilihan->name}}</div>
                            <div class="text-xs font-weight-bold text-primary mb-1">Skor rata-rata: {{round($pt->avg_score, 2)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $rank+=1; @endphp
        @endforeach
    </div>
    @endif

    <h1 class="h5 mb-4 text-gray-500">{{ __('Laman Tryout') }}</h1>
    <div class="row">
        @foreach ($tryout as $t)
        @php
        $stat = $t->tryout_css( $t->tryout_status() )
        @endphp
        <div class="col-xl-8 col-md-6 mb-4">
            <div class="card {{$stat->border_pinggir}} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2">
                            <i class="fas fa-calendar fa-2x text-gray-300" style="font-size: 50px;"></i>
                        </div>
                        <div class="col md-10 mr-2">
                            <div class="h5 mb-1 font-weight-bold text-gray-800 mb-3">{{$t->name}}</div>
                            <div class="text-xs font-weight-bold {{$stat->teks}} mb-1">
                                {{$t->time_start->translatedFormat('d/m/Y')}} {{$t->time_start->translatedFormat('H:i')}} WIB
                                <br>s/d<br>
                                {{$t->time_end->translatedFormat('d/m/Y')}} {{$t->time_end->translatedFormat('H:i')}} WIB
                            </div>
                            <span class="badge badge-pill {{$stat->badge}} mb-2">Status: {{$t->tryout_status()}}</span>
                            @if($t->tryout_status() == "Telah Diselesaikan")
                            <a class="btn btn-sm {{$stat->btn}} btn-block" href="{{route('tryout.lembar', ['id_tryout' => $t->id, 'id_peserta' => Illuminate\Support\Facades\Auth::user()->id])}}">Lihat Lembar Jawaban</a>
                            @endif
                            @if($t->tryout_status() == "Sedang Berlangsung")
                            <a class="btn btn-sm {{$stat->btn}} btn-block" href="{{route('tryout.soal', ['id_tryout' => $t->id, 'no_soal' => 1])}}">Kerjakan</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endcan
@endsection
