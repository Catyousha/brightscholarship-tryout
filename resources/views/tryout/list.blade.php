@extends('layouts.main')

@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tryout</h6>
                    <!--<h6 class="m-0 font-weight-bold">Sisa Waktu: 00:30:00</h6>-->
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>Judul Tryout</th>
                            <th>Waktu Dimulai</th>
                            <th>Waktu Berakhir</th>
                            <th>Jumlah Peserta Mengerjakan</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @forelse ($tryout as $t)
                            <tr>
                                <td>{{$t->name}}</td>
                                <td>{{$t->time_start->translatedFormat('d M Y H:i')}}</td>
                                <td>{{$t->time_end->translatedFormat('d M Y H:i')}}</td>
                                <td>{{$t->user_tryout->count()}}</td>
                                <td><a href="{{route('tryout.edit', $t->id )}}" class="btn btn-primary btn-sm">Detail</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $tryout->links() }}
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
