@extends('layouts.main')
@section('title', "Daftar Peserta Tryout")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="p-3">
                    <a href="{{route('tryout.edit', $tryout->id)}}" class="btn btn-primary btn-sm">	&#8592; Kembali Ke Tryout</a>
                </div>
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta Tryout: {{$tryout->name}}</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>Nama Peserta</th>
                            @foreach ($tryout->sesi as $s)
                            <th class="text-center">Skor {{$s->mapel->name}}</th>
                            @endforeach
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @forelse ($peserta_tryout->unique('user_id') as $pt)
                            @php
                            $user = \App\Models\User::find($pt->user_id)
                            @endphp
                            <tr>
                                <td>{{$user->name}}</td>
                                @foreach($tryout->sesi as $s)
                                <td class="text-center">{{\App\Models\UserTryout::where('sesi_id', $s->id)->where('user_id', $user->id)->first()->score ?? 0}}</td>
                                @endforeach
                                <td>
                                    <a href="{{route('tryout.lembar', ['id_peserta' => $pt->user_id, 'id_tryout' => $tryout->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-paste fa-fw"></i> Lembar Jawaban</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

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
