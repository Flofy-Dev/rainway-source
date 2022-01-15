<?php 
$name = Auth::user()->name; 
$adminstatus = Auth::user()->admin; 

if( $adminstatus == 1 ){ 
    
$users = DB::table('users')->orderBy('id')->simplePaginate(5);
$sessionvalue = session('adminsearched');

if( $sessionvalue == 'true' )
{
    $users = session('admindata');
    session(['adminsearched' => 'false']);
}

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Admin Panel</title>
    </head>
</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome to the {{ config('app.name'); }} Admin Panel!
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <form action="/adminsearch" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Username"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-dark" style="position: relative; left: 5px;">
                        Search
                    </button>
                </span>
            </div>
        </form>
    </div>
    
    @if (!empty($users))
    <div class="container mt-5">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td>
                    <div class="form-inline">
                    <div class="form-group">{{ $data->name }}</div>
                    @if ($data->status == 1 && $data->name != $name && $data->id != 1)
                        <form class="form-group" action="/banuser" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" id="username_ban" name="username_ban" value="{{ $data->name }}">
                            <button type="submit" class="btn btn-danger btn" role="button" style="position: relative; left: 6.5px;">Ban user</button>
                        </form>
                        
                        @if ($data->admin == 0)
                        <form class="form-group" action="/adminpromote" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" id="username_promote" name="username_promote" value="{{ $data->name }}">
                            <button type="submit" class="btn btn-info btn" role="button" style="position: relative; left: 13px;">Promote to admin</button>
                        </form>
                        @else
                        <form class="form-group" action="/admindemote" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" id="username_demote" name="username_demote" value="{{ $data->name }}">
                            <button type="submit" class="btn btn-warning btn" role="button" style="position: relative; left: 13px;">Demote from admin</button>
                        </form>
                        @endif
                    @else
                        @if ($data->name != $name && $data->id != 1)
                        <form class="form-group" action="/unbanuser" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" id="username_unban" name="username_unban" value="{{ $data->name }}">
                            <button type="submit" class="btn btn-success btn" role="button" style="position: relative; left: 6.5px;">Unban user</button>
                        </form>
                        @endif
                    @endif
                    </div>
                    </td>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $users->links() !!}
        </div>
    </div>
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Player not found. Try searching again!
                </div>
            </div>
        </div>
    </div>
    @endif
    
</x-app-layout>

<?php } 
else{
    header("Location: /dashboard");
    exit;
}
?>
