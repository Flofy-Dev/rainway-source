<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Download</title>
    </head>
</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Download') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Here you can download the client of {{ config('app.name'); }}!
                </div>
            </div>
        </div>
    </div>
    
    <div class="col d-flex justify-content-center">
    <div class="card">
        <div class="card-body">
            <a href="/downloadfile" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Download</a>
            <a href="https://www.virustotal.com/gui/file/0719ac33340b5c5ce633d06a3633c4e8c15623948b500737aa29ea53847cff52?nocache=1" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">VirusTotal Scan</a>
        </div>
    </div>
    </div>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Take into account the fact that VirusTotal can report false positives, as it uses a lot of AV engines to validate its data. Less known antivirus engines tend to have more false positives, so keep that in mind when analyzing the Rainway client on VirusTotal.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
