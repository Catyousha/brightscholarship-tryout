@extends('layouts.main')
@section('title', "Daftar Peserta Terdaftar")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h6 class="m-0 font-weight-bold text-primary mb-2">Daftar Peserta Terdaftar</h6>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <form action="{{route('peserta.index')}}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input name="name" type="text" class="form-control bg-light border-1 small" placeholder="Cari peserta...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Pilihan</th>
                            <th>Asal Sekolah</th>
                            <th>Tryout Diikuti</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @forelse ($peserta as $p)
                            <tr>
                                <td>{{$p->name}}</td>
                                <td>{{$p->email}}</td>
                                <td>{{$p->asal_sekolah}}</td>
                                <td>{{$p->pilihan->name}}</td>
                                <td class="pl-5">{{$p->user_tryout->count()}}</td>
                                <td>
                                    <a href="{{route('peserta.show', $p->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-user fa-fw"></i> Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $peserta->links() }}
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
@endpush
