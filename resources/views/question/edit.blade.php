@extends('layouts.main')
@section('title', "Edit Soal")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="p-3">
                    <a href="{{route('sesi.edit', $soal->sesi_id)}}" class="btn btn-primary btn-sm">	&#8592; Kembali Ke Sesi</a>
                </div>
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Soal No. {{$soal->question_num}}</h6>
                </div>
                <div class="card-body table-responsive ">
                    <table class="table">
                        <form action="{{route('soal.update', $soal->id)}}" method="post" autocomplete="off">
                            @method('put')
                            @csrf
                            <tr>
                                <th class="align-middle" colspan="2">Teks Soal</th>
                            </tr>
                            <tr>
                                <td colspan="2"><textarea class="form-control @error('f_question_text') is-invalid @enderror" name="f_question_text" rows="5">{{$soal->question_text}}</textarea></td>
                            </tr>
                            <tr>
                                <th class="align-middle" colspan="2">Bobot Soal</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <select class="custom-select" name="f_bobot_id" required>
                                        @foreach (\App\Models\Bobot::all() as $b)
                                        <option value="{{$b->id}}" @if($soal->bobot_id == $b->id) selected @endif>
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

                            @foreach ($soal->choice as $c)
                            <tr>
                                <td class="p-0 m-0 align-middle text-center">
                                    <input type="hidden" name="f_choice_id[]" value="{{$c->id}}">
                                    <input class="form-check-input" type="radio" name="f_correct" id="{{$c->choice_symbol}}" @if($c->correct) checked @endif value="{{$c->choice_symbol}}">
                                    <label class="form-check-label" for="{{$c->choice_symbol}}">{{$c->choice_symbol}}.</label>
                                </td>
                                <td>
                                    <input class="form-control form-control-sm" type="text" name="f_choice_text[]" value="{{$c->choice_text}}">
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Simpan</button</td>
                            </tr>
                        </form>
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
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'f_question_text' );
</script>
@endpush
