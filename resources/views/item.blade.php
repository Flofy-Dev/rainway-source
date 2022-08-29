<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Item Page</title>
    </head>
</html>

<x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
        $sales = DB::table('owneditems')->where('itemid', $itemid)->count();
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
                            
                            <p style="margin-bottom:15px;" ><a class="font-weight-bold"> Sales: </a> <?php echo $sales; ?></p>
                            
                            @if (empty($itemowned) && $rainbux >= $price)
                            <form action="/buyitem" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" id="itemid" name="itemid" value="<?php echo $itemid; ?>">

                                <button type="submit" class="btn btn-success">
                                    Buy
                                </button>
                            </form>
                            @elseif ($rainbux < $price)
                            <form>
                                <button type="button" class="btn btn-danger disabled">
                                    Not enough Rainbux
                                </button>
                            </form>
                            @else
                            <form>
                                <button type="button" class="btn btn-success disabled">
                                    Owned
                                </button>
                            </form>
                            @endif
                            
                            @if (Auth::user()->admin == 1)
                            <button style="margin-top:25px;" type="button" data-bs-toggle="modal" data-bs-target="#item" class="btn btn-info">
                                Edit Item
                            </button>

                            <form action="/edititem" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="itemid" name="itemid" value="<?php echo $itemid; ?>">
                            <!-- Modal -->
                            <div class="modal fade" id="item" tabindex="-1" aria-labelledby="item" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="title">Item Editor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Name</span>
                                        <input required="true" type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>" placeholder="" aria-label="name" aria-describedby="basic-addon1">
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Description</span>
                                        <textarea required="true" type="text" name="desc" id="desc" class="form-control" placeholder="" aria-label="desc" aria-describedby="basic-addon1" rows="3"><?php echo $description; ?></textarea>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Price</span>
                                        <input required="true" type="number" name="price" id="price" class="form-control" value="<?php echo $price; ?>" placeholder="" aria-label="price" aria-describedby="basic-addon1">
                                    </div>
        
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Roblox Asset ID</span>
                                        <input required="true" type="number" name="id" id="id" class="form-control" value="<?php echo $robloxid; ?>" placeholder="" aria-label="id" aria-describedby="basic-addon1">
                                    </div>

                                    <style>
                                    fieldset {
                                     display: none;
                                    }

                                    .show_fieldset {
                                      display: inline;
                                    }
                                    </style>
                            
                                    <script>
                                    function showFieldset(fieldsetToShow) {
                                      if(fieldsetToShow == "hat")
                                        fieldsetToHide = "imageitems";
                                      else
                                      {
                                        fieldsetToHide = "hat";
                                        fieldsetToShow = "imageitems";
                                      }
                                      fieldsetToShow = document.getElementById(fieldsetToShow);
                                      fieldsetToHide = document.getElementById(fieldsetToHide);
                              
                                      var userInput = fieldsetToShow.querySelector("input");
                                      fieldsetToShow.classList.add("show_fieldset");
                                      fieldsetToHide.classList.remove("show_fieldset");
        
                                      setTimeout(function () {
                                        userInput.focus();
                                      }, 500);
                                    }
                                    </script>
                            
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Type</span>
                                        <select value="hat" onchange="showFieldset(value)" required="true" name="type" id="type" class="form-control" placeholder="" aria-label="type" aria-describedby="basic-addon1">
                                            <option value="hat">Hat</option>
                                            <option value="face">Face</option>
                                            <option value="shirt">Shirt</option>
                                            <option value="t-shirt">T-Shirt</option>
                                            <option value="pants">Pants</option>
                                        </select>
                                    </div>
                                    
                                    <fieldset class="" id="imageitems">
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Upload image of item (.png only)</span>
                                        <input style="margin-top:10px;" type="file" name="item_png" id="item_png">
                                        </div>
                                    </fieldset>
                            
                                    <fieldset class="show_fieldset" id="hat">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Upload .rbxm file of the item</span>
                                            <input style="margin-top:10px;" type="file" name="rbxm" id="rbxm">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Upload .mesh of the item</span>
                                            <input style="margin-top:10px;" type="file" name="mesh" id="mesh">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Upload texture of item (.png only)</span>
                                            <input style="margin-top:10px;" type="file" name="texture" id="texture">
                                        </div>
                                    </fieldset>
                                    
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button id="querybutton" name="querybutton" type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </div>
                                </div>
                            </form>
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
