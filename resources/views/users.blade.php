<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Users</title>
    </head>
</html>

<?php
$users = DB::table('users')->where('status', 1)->whereNotNull('email_verified_at')->orderBy('id')->simplePaginate(5);
$user_count = DB::table('users')->where('status', 1)->whereNotNull('email_verified_at')->count();
$sessionvalue = session('searched');

if( $sessionvalue == 'true' )
{
    $users = session('data');
    session(['searched' => 'false']);
}
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Here, you can see all of the players of {{ config('app.name'); }}!
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="/search" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Username"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="position: relative; left: 5px;">
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
                <tr class="table-primary">
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                </tr>
            </thead>
            <tbody>
            
                @foreach($users as $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td>{{ $data->name }}</td>
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
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    There are currently <?php echo $user_count; ?> users on {{ config('app.name'); }}.
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
