@extends('layouts.app')
@section('content')
<div class="min-h-screen flex bg-slate-100">
    <aside class="w-64 bg-white border-r p-6">
        <h2 class="text-xl font-bold text-blue-600 mb-8">EkskulSMK</h2>
        <form action="/logout" method="POST">
            @csrf
            <button class="text-red-600 text-sm font-semibold hover:underline">Logout</button>
        </form>
    </aside>
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold">Selamat datang, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-500 mb-6">Kelas: {{ Auth::user()->kelas }} | NIS: {{ Auth::user()->nis }}</p>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h3 class="font-bold mb-2">Selamat datang di Dashboard Siswa.</h3>
            <p class="text-sm text-slate-600">Login dan Registrasi Anda sudah berhasil berfungsi 100%.</p>
        </div>
    </main>
</div>
@endsection