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
                    <a href="{{route('tryout.edit', $sesi->tryout_id)}}" class="btn btn-primary btn-sm">	&#8592; Kembali Ke Tryout</a>
                </div>
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Sesi</h6>
                </div>
                <div class="card-body table-responsive ">

                    <table class="table">
                        @error('f_time_end')
                        <div class="alert alert-danger mt-2">
                            Waktu berakhirnya sesi haruslah setelah waktu sesi tersebut dimulai!
                        </div>
                        @enderror
                        <table class="table">
                            <form action="{{route('sesi.update', $sesi->id)}}" method="post" autocomplete="off">
                                @csrf
                                @method('put')
                                <input type="hidden" name="f_sesi_id" value="{{$sesi->id}}">
                                <tr>
                                    <th class="align-middle">Istirahat?</th>
                                    <td class="align-middle">
                                        <div class="form-check">
                                            <input type="checkbox" name="f_istirahat" class="form-check-input" id="istirahatCheck" @if($sesi->istirahat) checked="checked" @endif value="1">
                                            <label class="form-check-label" for="istirahatCheck">Checklist untuk menandai sesi ini sebagai waktu istirahat</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">Mata Pelajaran</th>
                                    <td class="align-middle">:</td>
                                    <td>
                                        <select class="custom-select" name="f_mapel" required>
                                            @foreach (\App\Models\Mapel::all() as $m)
                                            <option value="{{$m->id}}" @if($sesi->mapel_id == $m->id) selected @endif>
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
                                        min="{{date('Y-m-d\TH:i:s', strtotime(\App\Models\Sesi::where('tryout_id', $sesi->tryout_id)->where('id', $sesi->id - 1)->first()->time_end??$sesi->tryout->time_start))}}"
                                        max="{{date('Y-m-d\TH:i:s', strtotime(\App\Models\Sesi::where('tryout_id', $sesi->tryout_id)->where('id', $sesi->id + 1)->first()->time_start??$sesi->tryout->time_end))}}"
                                        step="any"
                                        name="f_time_start" value="{{date('Y-m-d\TH:i:s', strtotime($sesi->time_start))}}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">Waktu Berakhir</th>
                                    <td class="align-middle">:</td>
                                    <td><input class="form-control form-control-sm" type="datetime-local"
                                        min="{{date('Y-m-d\TH:i:s', strtotime($sesi->time_start??$sesi->tryout->time_start))}}"
                                        max="{{date('Y-m-d\TH:i:s', strtotime(\App\Models\Sesi::where('tryout_id', $sesi->tryout_id)->where('id', $sesi->id + 1)->first()->time_start??$sesi->tryout->time_end))}}"
                                        step="any"
                                        name="f_time_end" value="{{date('Y-m-d\TH:i:s', strtotime($sesi->time_end))}}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Simpan</button</td>
                                </tr>
                            </form>
                            <tr>
                                <td colspan="3"><button id="delete-sesi-btn" type="submit" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteSesiModal" data-id="{{$sesi->id}}"><i class="fa fa-trash fa-fw"></i> Hapus</button></td>
                            </tr>
                        </table>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Soal</h6>
                </div>
                <div class="card-body table-responsive ">
                    <a href="#tambah-soal" class="btn btn-primary btn-sm mx-3"><i class="fa fa-plus fa-fw"></i> Tambahkan Soal</a>
                    <table class="table">
                            <tr>
                                <th class="align-middle">No Soal</th>
                                <th class="align-middle">Teks Soal</th>
                                <th class="align-middle">Bobot Soal</th>
                                <th class="align-middle">Opsi</th>

                            </tr>
                            @forelse ($sesi->question as $q)
                                <tr>
                                    <td class="align-middle">{{$q->question_num}}</td>
                                    <td class="align-middle">{{\Illuminate\Support\Str::limit($q->question_text, 50, $end='...')}}</td>
                                    <td class="align-middle">{{$q->bobot->name}} (Bobot nilai: {{$q->bobot->nilai_bobot}})</td>
                                    <td class="align-middle">
                                        <a href="{{route('soal.edit', $q->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i> Edit</a>
                                        <a class="delete-soal-btn btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteSoalModal" data-id="{{$q->id}}"><i class="fa fa-trash fa-fw"></i> Hapus</a>
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

        <div class="col-lg-12 mb-4" id="tambah-soal">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Soal Nomor {{$sesi->question->count()+1}}</h6>
                </div>
                <div class="card-body table-responsive ">

                    @error('f_correct')
                        <div class="alert alert-danger mt-2">
                            Wajib ada satu jawaban yang benar!
                        </div>
                    @enderror
                    @error('f_question_text')
                        <div class="alert alert-danger mt-2">
                            Soal dan pilihan jawaban wajib diisi!
                        </div>
                    @enderror

                    <table class="table">
                        <form action="{{route('soal.store')}}" method="post" autocomplete="off">
                            @csrf
                            <tr>
                                <th class="align-middle" colspan="2">Teks Soal</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="hidden" name="f_tryout_id" value="{{$sesi->tryout->id}}">
                                    <input type="hidden" name="f_sesi_id" value="{{$sesi->id}}">
                                    <input type="hidden" name="f_mapel_id" value="{{$sesi->mapel->id}}">
                                    <input type="hidden" name="f_question_num" value="{{$sesi->question->count()+1}}">
                                    <textarea class="form-control @error('f_question_text') is-invalid @enderror"
                                     name="f_question_text" rows="5" required>
                                     {{old('f_question_text')}}
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle" colspan="2">Bobot Soal</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <select class="custom-select" name="f_bobot_id" required>
                                        @foreach (\App\Models\Bobot::where('has_deleted', "0")->get() as $b)
                                        <option value="{{$b->id}}">
                                            {{$b->name}} (Bobot nilai: {{$b->nilai_bobot}})
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle text-primary" colspan="2">
                                    Pilihan Jawaban
                                <p class="text-small">Check salah satu jawaban yang benar.</p>
                                </th>
                            </tr>
                            @php
                                $symbol = ['A', 'B', 'C', 'D', 'E']
                            @endphp
                            @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td class="p-0 m-0 align-middle text-center">
                                    <input class="form-check-input" type="radio" name="f_correct" id="{{ $symbol[$i] }}" @if(old('f_correct') == $symbol[$i] ) checked @endif value="{{$symbol[$i]}}">
                                    <label class="form-check-label" for="{{$symbol[$i]}}">{{$symbol[$i]}}.</label>
                                </td>
                                <td>
                                    <input type="hidden" name="f_choice_symbol[]" value="{{$symbol[$i]}}">
                                    <textarea id="{{$i}}" class="choice_editor form-control form-control-sm" type="text" name="f_choice_text[]" rows="1" required>{{old('f_choice_text.'.$i)}}</textarea>
                                </td>
                            </tr>
                            @endfor

                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Tambahkan</button</td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    <!-- End of Main Content -->


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
                <a class="btn btn-danger" href="#" onclick="event.preventDefault(); document.getElementById('delete-sesi-form').submit()">{{ __('Hapus Sesi') }}</a>
                <form action="{{route('sesi.destroy', $sesi->id)}}" method="post" id="delete-sesi-form">
                    @csrf
                    @method('delete')
                    <input type="hidden" id="delete_sesi_inp" name="f_delete_sesi" value="">
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
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script type="text/javascript">

    $(".delete-soal-btn").click(function () {
        var soal_id = $(this).attr('data-id');
        console.log(soal_id);
        document.getElementById('delete_soal_inp').value = soal_id;
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

    document.getElementById('confirm-delete-soal-btn').addEventListener('click', d_q);
</script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'f_question_text' );
    $('.choice_editor').each(function () {
        CKEDITOR.replace($(this).prop('id'));
    });
</script>
@endpush
