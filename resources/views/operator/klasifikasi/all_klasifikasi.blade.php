@extends('layouts.layout')
@section('title', 'Manajemen Klasifikasi Berkas')
@section('login_as', 'Operator')
@section('user-login')
    @if (Auth::check())
    {{ Auth::user()->nm_user }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::check())
    {{ Auth::user()->nm_user }}
    @endif
@endsection
@section('sidebar-menu')
    @include('operator/sidebar')
@endsection
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Arsip Dokumen Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row" style="margin-right:-15px; margin-left:-15px;">
                <div class="col-md-12">
                    <div class="alert alert-success alert-block" id="keterangan">
                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua klasifikasi berkas yang tersedia!!
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Klasifikasi</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($klasifikasis as $klasifikasi)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $klasifikasi->nm_klasifikasi }} </td>
                                    <td> {{ $klasifikasi->keterangan }} </td>
                                    <td>
                                        @if ($klasifikasi->status == "aktif")
                                            <label for="" class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp;Aktif</label>
                                            @else
                                            <label for="" class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp;TidakAktif</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a onclick="hapusklasifikasi({{ $klasifikasi->id }})" class="btn btn-danger btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );
    </script>
@endpush
