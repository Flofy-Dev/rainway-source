<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Item Page</title>
    </head>
</html>

<x-app-layout>
    <?php
        if(isset($_GET['id']))
            $itemid = $_GET['id'];
        else
            $itemid = 0;

        $name = DB::table('shop')->where('itemid', $itemid)->value('name');
        $description = DB::table('shop')->where('itemid', $itemid)->value('description');
        $thumbnail = DB::table('shop')->where('itemid', $itemid)->value('thumbnail');
        $price = DB::table('shop')->where('itemid', $itemid)->value('price');
        $type = DB::table('shop')->where('itemid', $itemid)->value('type');
        $robloxid = DB::table('shop')->where('itemid', $itemid)->value('robloxid');
        $creatorid = DB::table('shop')->where('itemid', $itemid)->value('creator');
        $creator = DB::table('users')->where('id', $creatorid)->value('name');
        $username = Auth::user()->name; 
        $rainbux = Auth::user()->rainbux;
        $id = Auth::user()->id;
        $itemowned = DB::table('owneditems')->where('user', $id)->where('itemid', $itemid)->value('itemid');
    ?>
    @if (!empty($name))
    <div class="col d-flex justify-content-center" style="padding:10px;">
        <div class="card">
            <a> <img src="<?php echo $thumbnail; ?>"> </a>
        </div>
        <div class="card" style="width:20rem;">
                    <div class="card-body">
                        <a> <h5 class="card-title font-weight-bold border-bottom" style="font-size: 25px;"><?php echo $name; ?></h5> </a>
                        <h5 class="card-title font-weight-medium" style="font-size: 18px;">By <a class="card-title" href="/profile?id=<?php echo $creatorid; ?>"> <?php echo $creator; ?> </a> </h5> 
                        
                        <div class="card-text">
                            <p class="text-capitalize" style="font-size: 20;"> <a class="font-weight-bold">Type: </a> <?php echo $type; ?></p>
                            <p style="font-size: 20;"><a class="font-weight-bold"> Description: </a> <?php echo $description; ?></p>
                        
                            <div style="position:relative; left:2px; padding:8px;" class="row sm:items-center">
                                <p style="font-size: 20; padding:5px;"><a class="font-weight-bold">Price: </a> </p>
                                <x-moneyicon style="position:relative; left:5px;"></x-moneyicon>    
                                <p style="position:relative; left:4px;"> <?php echo $price; ?> </p>
                            </div>

                            @if (empty($itemowned) && $rainbux >= $price)
                            <form action="/public/buyitem" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" id="itemid" name="itemid" value="<?php echo $itemid; ?>">
                                <input type="hidden" id="robloxid" name="robloxid" value="<?php echo $robloxid; ?>">
                                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
                                <input type="hidden" id="price" name="price" value="<?php echo $price; ?>">

                                <button type="submit" class="btn btn-success">
                                    Buy
                                </button>
                            </form>
                            @elseif ($rainbux < $price)
                                <button type="button" class="btn btn-danger disabled">
                                    Not enough Rainbux
                                </button>
                            @else
                                <button type="button" class="btn btn-success disabled">
                                    Owned
                                </button>
                            @endif
                        </div>
                     </div>
        </div>
    </div>
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Item not found.
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
