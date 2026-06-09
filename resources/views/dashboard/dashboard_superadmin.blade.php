@extends('layouts.app')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Welcome {{ Auth::user()->name }}!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.superadmin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan statistik dashboard di sini --}}
<div class="row">
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Siswa</h6>
                        <h3>0</h3> {{-- Nanti diganti dengan dynamic count --}}
                    </div>
                    <div class="db-icon">
                        <img src="{{ asset('assets/img/icons/dash-icon-01.svg') }}" alt="Dashboard Icon" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Tambahkan kartu guru, kelas, tahun ajaran --}}
</div>
@endsection
