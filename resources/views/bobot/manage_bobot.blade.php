@extends('layouts.main')
@section('title', "Pembobotan")
@push('css')
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Pembobotan</h6>
                </div>
                <div class="card-body table-responsive ">
                    <table class="table">
                            <tr>
                                <th class="align-middle">Jenis Bobot</th>
                                <th class="align-middle">Nilai Pembobotan</th>
                                <th class="align-middle">Opsi</th>

                            </tr>
                            @forelse ($bobot as $b)
                            @if($b->has_deleted != 1)
                            <form action="{{route('bobot.update', $b->id)}}" method="post" autocomplete="off">
                                @method('put')
                                @csrf
                                <tr>
                                    <td class="align-middle">
                                        <input class="form-control form-control-sm" type="text" name="f_name" value="{{$b->name}}"/>
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control form-control-sm" type="number" name="f_nilai_bobot" value="{{$b->nilai_bobot}}"/>
                                    </td>
                                    <td class="align-middle">
                                        <input class="btn btn-info btn-sm" type="submit" value="Simpan">
                                        <a class="delete-bobot-btn btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBobotModal" data-id="{{$b->id}}">
                                            <i class="fa fa-trash fa-fw"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            </form>
                            @endif
                            @empty
                            <tr>
                                <td colspan="3" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse

                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4" id="tambah-bobot">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Bobot</h6>
                </div>
                <div class="card-body table-responsive ">

                    <table class="table">
                        <form action="{{route('bobot.store')}}" method="post" autocomplete="off">
                            @csrf
                            <tr>
                                <th class="align-middle" colspan="2">Jenis Bobot</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="form-control form-control-sm" type="text" name="f_name" value="{{old('f_name')}}">
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle" colspan="2">Nilai Bobot</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="form-control form-control-sm" type="number" name="f_nilai_bobot" value="{{old('f_nilai_bobot')}}"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-save fa-fw"></i> Tambahkan
                                </button</td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    <!-- End of Main Content -->


<div class="modal fade" id="deleteBobotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ingin menghapus bobot?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Perhatian: Bobot yang telah dihapus tidak dapat dikembalikan lagi! Masih ingin menghapus bobot?</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a id="confirm-delete-bobot-btn" class="btn btn-danger" href="#" onclick="event.preventDefault();">{{ __('Hapus Bobot') }}</a>
                <input type="hidden" id="delete_bobot_inp" name="f_delete_bobot" value="">
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

    $(".delete-bobot-btn").click(function () {
        var bobot_id = $(this).attr('data-id');
        console.log(bobot_id);
        document.getElementById('delete_bobot_inp').value = bobot_id;
    });

    function d_q(event){
        var bobot_id = document.getElementById('delete_bobot_inp').value;
        console.log(bobot_id);
        $.ajax({
            type:'POST',
            url:'/bobot/'+bobot_id,
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

    document.getElementById('confirm-delete-bobot-btn').addEventListener('click', d_q);
</script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'f_question_text' );
</script>
@endpush
