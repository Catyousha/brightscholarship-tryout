@extends('layouts.main')
@section('title', "Edit Tryout")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="p-3 d-flex justify-content-between">
                    <a href="{{route('peserta.index')}}" class="btn btn-primary btn-sm">	&#8592; Kembali Ke Daftar Peserta</a>
                    <button id="delete-peserta-btn" type="submit" class="btn btn-danger btn-sm"
                    data-toggle="modal" data-target="#deletePesertaModal" data-id="{{$peserta->id}}">
                        <i class="fa fa-trash fa-fw"></i> Hapus Peserta
                    </button>
                </div>
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Peserta</h6>
                </div>
                <div class="card-body table-responsive ">

                    <table class="table">
                            <tr>
                                <th class="align-middle">Nama Peserta</th>
                                <td class="align-middle">:</td>
                                <td class="align-middle">{{$peserta->name}}</td>
                            </tr>
                            <tr>
                                <th class="align-middle">Pilihan</th>
                                <td class="align-middle">:</td>
                                <td class="align-middle">{{$peserta->pilihan->name}}</td>
                            </tr>
                            <tr>
                                <th class="align-middle">Email Peserta</th>
                                <td class="align-middle">:</td>
                                <td class="align-middle">{{$peserta->email}}</td>
                            </tr>
                            <tr>
                                <th class="align-middle">Tanggal Registrasi</th>
                                <td class="align-middle">:</td>
                                <td class="align-middle">{{$peserta->created_at->translatedFormat('d M Y H:i')}}</td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tryout Yang Diikuti</h6>
                </div>
                <div class="card-body table-responsive ">
                    <table class="table">
                            <thead>
                                <th>Judul Tryout</th>
                                <th>Skor Rata-Rata</th>
                                <th>Opsi</th>
                            </thead>
                            <tbody>
                                @forelse ($tryout_peserta->unique('tryout_id') as $tp)
                                <tr>
                                    <td>{{$tp->tryout->name}}</td>
                                    <td>{{\App\Models\UserTryout::where('tryout_id', $tp->tryout_id)
                                        ->where('user_id', $peserta->id)
                                        ->sum('score')/$tp->tryout->sesi->where('istirahat', 0)->count()}}
                                    </td>
                                    <td><a class="btn btn-primary btn-sm" href="{{route('tryout.lembar', ['id_peserta'=>$peserta->id, 'id_tryout'=>$tp->tryout->id])}}">
                                        <i class="fa fa-paste fa-fw"></i> Lembar Jawaban
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                                </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </div>



    <!-- End of Main Content -->
<div class="modal fade" id="deletePesertaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ingin menghapus peserta?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Perhatian: Data peserta yang telah dihapus tidak dapat dikembalikan lagi! Masih ingin menghapus peserta?</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a id="confirm-delete-soal-btn" class="btn btn-danger" href="#" onclick="event.preventDefault(); document.getElementById('hapus-peserta-form').submit();">{{ __('Hapus Peserta') }}</a>
                <form id="hapus-peserta-form" action="{{route('peserta.destroy', $peserta->id)}}" method="post">
                @method('delete')
                @csrf
                </form>
            </div>
        </div>
    </div>
</div>
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
