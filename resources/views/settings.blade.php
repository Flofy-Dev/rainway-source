<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Settings</title>
    </head>
</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <form action="/changeblurb" method="POST">
    {{ csrf_field() }}
    <div class="col d-flex justify-content-center" style="padding:10px;">
    <div style="width:600px"; class="card">
        <div class="card-header">
            Settings
        </div>
        <div class="card-body">
            <h5 class="card-title">Blurb</h5>
            <textarea class="form-control card-title" rows="6" id="blurb" name="blurb">{{ Auth::user()->blurb }}</textarea>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
    </div>
    </form>
</x-app-layout>
