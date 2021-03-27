@extends('layouts.main')
@php  @endphp
@section('title', "Ranking Keseluruhan")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ranking Keseluruhan</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>Ranking</th>
                            <th>Nama Peserta</th>
                            @foreach (\App\Models\Mapel::all() as $m)
                                @if($m->name != "ISTIRAHAT")
                                    <th class="text-center">Skor {{$m->name}}</th>
                                @endif
                            @endforeach
                            <th>Rata-Rata</th>
                            @can('isAdmin')
                            <th>Opsi</th>
                            @endcan
                        </thead>
                        <tbody>
                            @php $rank = 0@endphp
                            @forelse ($peserta_tryout as $pt)
                            <tr>
                                @php $rank += 1@endphp
                                <td class="text-center">{{$rank}}</td>
                                <td>{{\App\Models\User::where('id', $pt->user_id)->first()->name}}</td>
                                @foreach(\App\Models\Mapel::all() as $m)
                                    @if($m->name != "ISTIRAHAT")
                                        <td class="text-center">
                                            {{\App\Models\UserTryout::where('user_id', $pt->user_id)->where('mapel_id', $m->id)->first()->score ?? "-"}}
                                        </td>
                                    @endif
                                @endforeach
                                <td class="text-center">
                                    {{$pt->avg_score}}
                                </td>
                                @can('isAdmin')
                                            <td>
                                                <a href="{{route('tryout.lembar', ['id_peserta' => $pt->user_id, 'id_tryout' => $pt->tryout_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-paste fa-fw"></i> Lembar Jawaban</a>
                                            </td>
                                @endcan
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @can('isAdmin')
                        <a class="btn btn-success" href="{{route('cetak',['type' => 'ALL'])}}"><i class="fa fa-print"></i> Cetak Ranking</a>
                    @endcan
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
@endpush
