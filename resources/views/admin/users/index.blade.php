{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Users')
@section('heading', 'User accounts')
@section('subheading', 'Administrators, sellers and customers')

@section('content')
<form method="GET" class="mb-5 flex flex-wrap gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name" class="rounded-lg border-slate-300 text-sm">
    <select name="role" class="rounded-lg border-slate-300 text-sm">
        <option value="">Any role</option>
        @foreach (['admin','vendor','customer'] as $role)<option value="{{ $role }}" @selected(request('role') === $role)>{{ ucfirst($role) }}</option>@endforeach
    </select>
    <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">Filter</button>
</form>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Name</th><th class="px-6 py-3">Email</th><th class="px-6 py-3">Role</th><th class="px-6 py-3">Joined</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $user->email }}</td>
                    <td class="px-6 py-3">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex items-center gap-2">@csrf @method('PATCH')
                            <select name="role" class="rounded-lg border-slate-300 text-xs">
                                @foreach (['admin','vendor','customer'] as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>@endforeach
                            </select>
                            <label class="flex items-center gap-1 text-xs text-slate-500"><input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="rounded border-slate-300"> active</label>
                            <button class="rounded-lg border border-slate-300 px-2 py-1 text-xs font-semibold">Save</button>
                        </form>
                    </td>
                    <td class="px-6 py-3 text-slate-500">{{ optional($user->created_at)->format('M j, Y') }}</td>
                    <td class="px-6 py-3 text-right">
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')
                            <button class="text-xs font-semibold text-rose-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $users->links() }}</div>
@endsection
