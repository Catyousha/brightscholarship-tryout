@extends('layouts.main')

@push('css')
<style>
    ul {list-style-type: none;}
    .nav-soal {
        margin: 0;
    }

    .nav-soal li {
        list-style-type: none;
        display: inline-block;
        width: 20%;
        text-align: center;
        margin-bottom: 5px;
        font-size:12px;
        padding: 10px;
        border: 0.5px solid #4E73E1;
        color: #4E73E1;
        cursor: pointer;
    }

    .nav-soal .active {
        background-color: #4E73E1;
    }
    .nav-soal .active a {
        color: white !important;
    }
</style>
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Page Soal') }}</h1>

    <!-- Main Content goes here -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tryout 1: Soal No. 1</h6>
                    <h6 class="m-0 font-weight-bold">Sisa Waktu: 00:30:00</h6>
                </div>
                <div class="card-body">
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.
                        Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
                        A small river named Duden flows by their place and supplies it with the necessary regelialia.
                        It is a paradisematic country, in which roasted parts of sentences fly into your mouth.
                        Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life.
                    </p>

                    <div class="mt-4 d-flex flex-column">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mr-3" type="radio" name="answer" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">A. Lorem ipsum dolor sit amet</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mr-3" type="radio" name="answer" id="inlineRadio2" value="option1">
                            <label class="form-check-label" for="inlineRadio2">B. Lorem ipsum dolor sit amet</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mr-3" type="radio" name="answer" id="inlineRadio3" value="option1">
                            <label class="form-check-label" for="inlineRadio3">C. Lorem ipsum dolor sit amet</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mr-3" type="radio" name="answer" id="inlineRadio4" value="option1">
                            <label class="form-check-label" for="inlineRadio4">D. Lorem ipsum dolor sit amet</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mr-3" type="radio" name="answer" id="inlineRadio5" value="option1">
                            <label class="form-check-label" for="inlineRadio5">E. Lorem ipsum dolor sit amet</label>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a class="btn btn-primary">Sebelumnya</a>
                        <a class="btn btn-primary">Selanjutnya</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Navigasi Soal</h6>
                </div>
                <div class="card-body">
                    <ul class="nav-soal">
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#">7</a></li>
                        <li><a href="#">8</a></li>
                        <li><a href="#">9</a></li>
                        <li><a href="#">10</a></li>
                    </ul>
                    <div class="text-center mt-3">
                        <small class="text-danger">Pastikan semua soal sudah dijawab!</small>
                        <a class="btn btn-success">Submit Pengerjaan</a>
                    </div>
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
