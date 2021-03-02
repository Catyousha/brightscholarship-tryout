@extends('layouts.main')
@section('title', "Daftar Tryout")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <div class="col-lg-6 col-md-12">
                        <h6 class="m-0 font-weight-bold text-primary mb-2">Daftar Tryout</h6>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <form action="{{route('tryout.index')}}" method="GET" autocomplete="off">
                            <div class="input-group">
                                <input name="name" type="text" class="form-control bg-light border-1 small" placeholder="Cari tryout...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>Judul Tryout</th>
                            <th>Pilihan</th>
                            <th>Waktu Dimulai</th>
                            <th>Waktu Berakhir</th>
                            <th>Jumlah Peserta Mengerjakan</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @forelse ($tryout as $t)
                            <tr>
                                <td>{{$t->name}}</td>
                                <td>{{$t->pilihan->name}}</td>
                                <td>{{$t->time_start->translatedFormat('d M Y H:i')}}</td>
                                <td>{{$t->time_end->translatedFormat('d M Y H:i')}}</td>
                                <td>{{$t->user_tryout->unique('user_id')->count()}}</td>
                                <td colspan="2">
                                    @can('isAdmin')<a href="{{route('tryout.edit', $t->id )}}" class="btn btn-primary btn-sm">Detail</a>@endcan
                                    <a href="{{route('tryout.peserta', $t->id )}}" class="btn btn-info btn-sm">Pemeringkatan</a>
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
                        {{ $tryout->links() }}
                    </div>
                </div>
            </div>
        </div>

        @can('isAdmin')
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mb-2">Tambah Tryout</h6>
                </div>
                <div class="card-body table-responsive">
                    @error('f_time_end')
                    <div class="alert alert-danger mt-2">
                        Waktu berakhirnya tryout haruslah setelah waktu tryout dimulai!
                    </div>
                    @enderror
                    <table class="table">
                        <form action="{{route('tryout.store')}}" method="post" autocomplete="off">
                            @csrf
                            <tr>
                                <th class="align-middle">Judul Tryout</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="text" name="f_name" value="{{old('f_name')}}" required></td>
                            </tr>
                            <tr>
                                <th class="align-middle">Pilihan</th>
                                <td class="align-middle">:</td>
                                <td>
                                    <select class="custom-select" name="f_pilihan" required>
                                        @foreach (\App\Models\Pilihan::all() as $p)
                                        <option value="{{$p->id}}" @if(old('f_pilihan') == $p->id) selected @endif>{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">Waktu Dimulai</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="datetime-local" name="f_time_start" value="{{old('f_time_start')}}" required></td>
                            </tr>
                            <tr>
                                <th class="align-middle">Waktu Berakhir</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="datetime-local" name="f_time_end" value="{{old('f_time_end')}}" required></td>
                            </tr>
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Simpan</button</td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
        @endcan
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
