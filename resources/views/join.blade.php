<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Joining Game...</title>
    </head>
</html>

<?php 
$name = Auth::user()->name;
$verified = DB::table('users')->where('name', $name)->value('email_verified_at');
$verified = urlencode($verified);

$rainway_url = "rainway://".$verified;
header("Location: $rainway_url");
exit();
?>