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
                                <th class="align-middle">Pilihan</th>
                                <td class="align-middle">:</td>
                                <td>
                                    <select class="custom-select" name="f_pilihan">
                                        @foreach (\App\Models\Pilihan::all() as $p)
                                        <option value="{{$p->id}}" @if($tryout->pilihan_id == $p->id) selected @endif>{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
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
                            <tr>
                                <td colspan="3"><button id="delete-tryout-btn" type="submit" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteTryoutModal" data-id="{{$tryout->id}}"><i class="fa fa-trash fa-fw"></i> Hapus</button></td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <a class="btn btn-block btn-success m-0 font-weight-bold" href="{{route('tryout.peserta', $tryout->id)}}"><i class="fa fa-user fa-fw"></i> Daftar Peserta Tryout</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Sesi</h6>
                </div>
                <div class="card-body table-responsive ">
                    <a href="#tambah-soal" class="btn btn-primary btn-sm mx-3"><i class="fa fa-plus fa-fw"></i> Tambahkan Sesi</a>
                    <table class="table">
                            <tr>
                                <th class="align-middle">Mata Pelajaran</th>
                                <th class="align-middle">Waktu Dimulai</th>
                                <th class="align-middle">Waktu Berakhir</th>
                                <th class="align-middle">Opsi</th>

                            </tr>
                            @forelse ($tryout->sesi as $s)
                                <tr>
                                    <td class="align-middle">{{$s->mapel->name}}</td>
                                    <td class="align-middle">{{$s->time_start->translatedFormat('d M Y H:i')}}</td>
                                    <td class="align-middle">{{$s->time_end->translatedFormat('d M Y H:i')}}</td>
                                    <td>
                                        <a href="{{route('sesi.edit', $s->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i> Edit</a>
                                        <a class="delete-soal-btn btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteSesiModal" data-id="{{$s->id}}"><i class="fa fa-trash fa-fw"></i> Hapus</a>
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

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mb-2">Tambah Sesi</h6>
                </div>
                <div class="card-body table-responsive">
                    @error('f_time_end')
                    <div class="alert alert-danger mt-2">
                        Waktu berakhirnya sesi haruslah setelah waktu sesi tersebut dimulai!
                    </div>
                    @enderror
                    <table class="table">
                        <form action="{{route('sesi.store')}}" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="f_tryout_id" value="{{$tryout->id}}">
                            <tr>
                                <th class="align-middle">Mata Pelajaran</th>
                                <td class="align-middle">:</td>
                                <td>
                                    <select class="custom-select" name="f_mapel" required>
                                        @foreach (\App\Models\Mapel::all() as $m)
                                        <option value="{{$m->id}}" @if(old('f_mapel') == $m->id) selected @endif>
                                            {{$m->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">Waktu Dimulai</th>
                                <td class="align-middle">:</td>
                                <td>
                                    <input class="form-control form-control-sm" type="datetime-local"
                                    min="{{date('Y-m-d\TH:i:s', strtotime($tryout->sesi()->latest()->first()->time_end??$tryout->time_start))}}"
                                    max="{{date('Y-m-d\TH:i:s', strtotime($tryout->time_end))}}"
                                    step="any"
                                    name="f_time_start" value="{{old('f_time_start')}}" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">Waktu Berakhir</th>
                                <td class="align-middle">:</td>
                                <td><input class="form-control form-control-sm" type="datetime-local"
                                    min="{{date('Y-m-d\TH:i:s', strtotime($tryout->time_start))}}"
                                    max="{{date('Y-m-d\TH:i:s', strtotime($tryout->time_end))}}"
                                    step="any"
                                    name="f_time_end" value="{{old('f_time_end')}}" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Simpan</button</td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    <!-- End of Main Content -->

<!--Modal-->
<div class="modal fade" id="deleteTryoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ingin menghapus tryout?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Perhatian: Tryout beserta soal dan pilihan jawaban yang telah dihapus tidak dapat dikembalikan lagi! Masih ingin menghapus tryout?</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="#" onclick="event.preventDefault(); document.getElementById('delete-tryout-form').submit();">{{ __('Hapus Tryout') }}</a>
                <form id="delete-tryout-form" action="{{route('tryout.destroy', $tryout->id)}}" method="post" style="display: none;">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="f_delete_tryout" value="">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSoalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ingin menghapus soal?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Perhatian: Soal beserta pilihan jawaban yang telah dihapus tidak dapat dikembalikan lagi! Masih ingin menghapus soal?</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a id="confirm-delete-soal-btn" class="btn btn-danger" href="#" onclick="event.preventDefault();">{{ __('Hapus Soal') }}</a>
                <input type="hidden" id="delete_soal_inp" name="f_delete_soal" value="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSesiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ingin menghapus sesi?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Perhatian: Sesi beserta soal dan pilihan jawaban yang telah dihapus tidak dapat dikembalikan lagi! Masih ingin menghapus sesi?</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="#" onclick="event.preventDefault();">{{ __('Hapus Sesi') }}</a>
                <input type="hidden" id="delete_sesi_inp" name="f_delete_sesi" value="">
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
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script type="text/javascript">
    $("#delete-tryout-btn").click(function () {
        var tryout_id = $(this).attr('data-id');
        document.getElementsByName('f_delete_tryout').value = tryout_id;
    });

    $(".delete-soal-btn").click(function () {
        var soal_id = $(this).attr('data-id');
        console.log(soal_id);
        document.getElementById('delete_soal_inp').value = soal_id;
    });

    $(".delete-sesi-btn").click(function () {
        var sesi_id = $(this).attr('data-id');
        console.log(sesi_id);
        document.getElementById('delete_sesi_inp').value = sesi_id;
    });

    function d_q(event){
        var soal_id = document.getElementById('delete_soal_inp').value;
        console.log(soal_id);
        $.ajax({
            type:'POST',
            url:'/soal/'+soal_id,
            data:{_token: "{{ csrf_token() }}", _method: 'delete'},
            success:function(data) {
                location.reload();
                //window.location.href = window.location.href;
                //console.log(data.data);
            },
            error: function(err){
                console.log(err)
            }
        });
    }

    function d_s(event){
        var sesi_id = document.getElementById('delete_sesi_inp').value;
        console.log(sesi_id);
        $.ajax({
            type:'POST',
            url:'/sesi/'+sesi_id,
            data:{_token: "{{ csrf_token() }}", _method: 'delete'},
            success:function(data) {
                location.reload();
                //window.location.href = window.location.href;
                //console.log(data.data);
            },
            error: function(err){
                console.log(err)
            }
        });
    }
    document.getElementById('confirm-delete-sesi-btn').addEventListener('click', d_s);
    document.getElementById('confirm-delete-soal-btn').addEventListener('click', d_q);
</script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'f_question_text' );
</script>
@endpush
