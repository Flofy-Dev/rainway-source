<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Profile</title>
    </head>
</html>

<x-app-layout> 
    <?php
        if(isset($_GET['id']))
            $profileid = $_GET['id'];
        else
            $profileid = 0;
        $user = DB::table('users')->where('id', $profileid)->whereNotNull('email_verified_at')->value('avatar');
        $status = DB::table('users')->where('id', $profileid)->whereNotNull('email_verified_at')->value('status');
        $name = DB::table('users')->where('id', $profileid)->whereNotNull('email_verified_at')->value('name');
        $description = DB::table('users')->where('id', $profileid)->whereNotNull('email_verified_at')->value('blurb');
    ?>
    @if (!empty($user) && $status == 1)
    <div class="col d-flex justify-content-center" style="padding:10px;">
        <div class="card" style="width:420px;">
            <div class="card-body">
                <div class="card-block text-center">
                    <p class="card-title font-weight-bold" style="font-size: 26px;"><?php echo $name; ?></p>
                    <img width=420 height=420 src="<?php echo $user; ?>">
                    <p style="font-size: 20;"><?php echo $description; ?></p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-block text-center" style="position:relative; left:3px;">
                    <p class="card-title font-weight-bold" style="font-size: 26px;">Places</p>
                    <p class="card-title font-weight-bold" style="font-size: 26px;">Coming soon..</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col d-flex justify-content-center" style="padding:10px;">
    <div class="card">
            <div class="card-body">
                <div class="card-block text-center">
                    <p class="card-title font-weight-bold" style="font-size: 26px;">Inventory</p>
                    <?php
                        $items = DB::table('owneditems')->where('user', $profileid)->paginate(3);
                        $itemscheck = DB::table('owneditems')->where('user', $profileid)->value("itemname");
                        $items->setPath('/profile?id='.$profileid);
                    ?>

                    @if (!empty($itemscheck))
                        <div class="container">
                        <div class="mt-3">
                            @foreach($items as $data)
                            <div class="container-fluid col d-flex justify-content">
                                <div class="row">
                                    <div class="card" style="width: 15rem; height: auto;">
                                    <?php 
                                        $itemid = $data->itemid;
                                        $thumbnail = DB::table('shop')->where('itemid', $itemid)->value('thumbnail'); 
                                    ?>

                                    
                                    <div class="card-body">
                                        <a href="/item?id={{ $data->itemid }}"> <img class="card-img-top" src="<?php echo $thumbnail; ?>"> </a>
                                        <div class="card-text">
                                            <a href="/item?id={{ $data->itemid }}"> <h5 class="card-title font-weight-bold">{{ $data->itemname }}</h5> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                        </div>
                        {{-- Pagination --}}
                            <div class="d-flex justify-content-center">
                                {!! $items->links() !!}
                            </div>
                        @else
                            <div class="py-12">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-6 bg-white border-b border-gray-200">
                                            Items not found.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Player not found.
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
