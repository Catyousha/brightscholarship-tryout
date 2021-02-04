@extends('layouts.main')

@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="p-3">
                    <a href="{{route('tryout.index')}}" class="btn btn-primary btn-sm">	&#8592; Kembali Ke Daftar Tryout</a>
                </div>
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tryout</h6>
                    <!--<h6 class="m-0 font-weight-bold">Sisa Waktu: 00:30:00</h6>-->
                </div>
                <div class="card-body table-responsive ">
                    <table class="table">
                        <form action="{{route('tryout.update', $tryout->id)}}" method="post">
                            @method('put')
                            @csrf
                            <tr>
                                <th class="align-middle">Judul Tryout</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="text" name="f_name" value="{{$tryout->name}}"></td>
                            </tr>
                            <tr>
                                <th class="align-middle">Waktu Dimulai</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="datetime-local" name="f_time_start" value="{{date('Y-m-d\TH:i:s', strtotime($tryout->time_start))}}"></td>
                            </tr>
                            <tr>
                                <th class="align-middle">Waktu Berakhir</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="datetime-local" name="f_time_end" value="{{date('Y-m-d\TH:i:s', strtotime($tryout->time_end))}}"></td>
                            </tr>
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Simpan</button</td>
                            </tr>
                        </form>
                        <form action="{{route('tryout.destroy', $tryout->id)}}" method="post">
                            @method('delete')
                            @csrf
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash fa-fw"></i> Hapus</button</td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Soal</h6>
                    <!--<h6 class="m-0 font-weight-bold">Sisa Waktu: 00:30:00</h6>-->
                </div>
                <div class="card-body table-responsive ">
                    <table class="table">
                            <tr>
                                <th class="align-middle">No Soal</th>
                                <th class="align-middle">Teks Soal</th>
                                <th class="align-middle">Opsi</th>

                            </tr>
                            @forelse ($tryout->question as $q)
                                <tr>
                                    <td class="align-middle">{{$q->question_num}}</td>
                                    <td class="align-middle">{{\Illuminate\Support\Str::limit($q->question_text, 50, $end='...')}}</td>
                                    <td class="align-middle">
                                        <a href="{{route('soal.edit', $q->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i> Edit</a>
                                        <a href="{{route('soal.destroy', $q->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i> Hapus</a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="3" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse

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
