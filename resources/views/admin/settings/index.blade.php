{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Settings')
@section('heading', 'Store settings')
@section('subheading', 'Branding, contact details, shipping and tax rules')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 md:grid-cols-2">
    @csrf @method('PUT')
    @foreach ($fields as $key => $label)
        <div>
            <label class="block text-sm font-medium text-slate-700">{{ $label }}</label>
            <input type="text" name="{{ $key }}" value="{{ old($key, $values[$key]) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
        </div>
    @endforeach
    <div class="md:col-span-2">
        <button class="rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Save settings</button>
    </div>
</form>
@endsection
