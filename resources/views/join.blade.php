<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Joining Game...</title>
    </head>
</html>

<?php 
$id = Auth::user()->id;
$port = 53640;
$join_Token = "your_api_hash".$id;

$rainway_url = "rainway://".$join_Token.";".$port;
header("Location: $rainway_url");
exit();
?>
