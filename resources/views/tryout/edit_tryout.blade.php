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
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block">Simpan</button</td>
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
@endpush
