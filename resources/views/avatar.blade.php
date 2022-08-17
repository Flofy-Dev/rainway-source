<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Avatar</title>
    </head>
</html>

<x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Avatar') }}
        </h2>
    </x-slot>
        
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome to the avatar page! Here you can customize your character to your liking!
                </div>
            </div>

            <?php 
                $itemerror = false;
                if(isset($_GET["error"]))
                    $itemerror = $_GET["error"];
            ?>

            @if($itemerror)
            <div style="margin-top:10px;" class="alert alert-danger" role="alert">
                Wearing too many items of this type!
            </div>
            @endif
            
            <div class="col d-flex justify-content py-12">
                <div class="card">
                    <img class="card-img-top" src="<?php echo Auth::user()->avatar; ?>">
                    <div class="card-body col d-flex justify-content-center">
                        <a style="height: 38px; position: relative; right: 8px;" href="{{ route('redraw') }}" class="btn btn-info">Redraw</a>
                        <button style="height: 38px;" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bodycolors" style="position: relative; left: 6.5px;">
                            Body Colors
                        </button>
                    </div>
                </div>
                <div class="card" style="width:60rem;">
                    <div class="col d-flex justify-content py-12">
                    <div class="list-group">
                    <button style="pointer-events: none;" class="list-group-item list-group-item-action active">
                        Category
                    </button>
                    <a href="/avatar" class="list-group-item list-group-item-action">All</a>
                    <a href="/avatar?filter=hat" class="list-group-item list-group-item-action">Hats</a>
                    <a href="/avatar?filter=face" class="list-group-item list-group-item-action">Faces</a>
                    <a href="/avatar?filter=gear" class="list-group-item list-group-item-action">Gear</a>

                    <div class="btn-group">
                        <a href="/avatar?filter=clothing" type="button" class="list-group-item list-group-item-action btn bg-white">Clothing</a>
                        <button type="button" class="list-group-item list-group-item-action btn bg-white dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/avatar?filter=shirt">Shirts</a>
                            <a class="dropdown-item" href="/avatar?filter=t-shirt">T-Shirts</a>
                            <a class="dropdown-item" href="/avatar?filter=pants">Pants</a>
                        </div>
                    </div>
                    </div>
                    <div class="container">
                    <form action="/avatarsearch" method="GET" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q"
                                placeholder="Search for an item"> <span class="input-group-btn">
                            <button style="position: relative; left:5px;" type="submit" class="btn btn-primary">
                                Search
                            </button>
                            </span>
                            <?php if(isset($_GET['filter'])){ ?>
                                <input type="hidden" class="form-control" name="filter" id="filter" value="<?php echo $_GET['filter']; ?>">
                            <?php } ?>
                        </div>
                    </form>
 
                    <?php
                        $userid = Auth::user()->id;
                        
                        if(isset($_GET['filter']))
                        {
                            $filterset = true;
                            $filterquery = $_GET['filter'];
                        }
                        else
                        {
                            $filterset = false;
                            $filterquery = "";
                        }

                        if(isset($_GET['filter']))
                        {
                            $filter = $_GET['filter'];
                            if($filter == "clothing")
                            {
                                $items = DB::table('owneditems')->where('user', $userid)->where(function ($q) {
                                    $q->where('type',"shirt")->orWhere('type',"t-shirt")->orWhere('type',"pants");
                                })->paginate(3);
                            }
                            else
                                $items = DB::table('owneditems')->where('user', $userid)->where('type', $filter)->paginate(3);
                            $items->setPath('/avatar?filter='.$filter);
                        }
                        else
                            $items = DB::table('owneditems')->where('user', $userid)->paginate(3);

                            $sessionvalue = session('avatarsearched');
                            if($sessionvalue == 'true')
                            {
                                $items = session('avatardata');
                                session(['avatarsearched' => 'false']);
                            }
                    ?>

                        @if (!empty($items))
                        <div class="container">
                        <div class="mt-3">
                            @foreach($items as $data)
                            <div class="container-fluid col d-flex justify-content">
                                <div class="row">
                                    <div class="card" style="width: 10rem; height: 20rem;">
                                    <?php 
                                        $itemid = $data->itemid;
                                        $thumbnail = DB::table('shop')->where('itemid', $itemid)->value('thumbnail'); 
                                        $wearing = DB::table('owneditems')->where('user', $userid)->where('itemid', $itemid)->value('wearing');
                                    ?>

                                    <a href="/item?id={{ $data->itemid }}"> <img class="card-img-top" src="<?php echo $thumbnail; ?>"> </a>
                                    <div class="card-body">
                                        <a href="/item?id={{ $data->itemid }}"> <h5 class="card-title font-weight-bold">{{ $data->itemname }}</h5> </a>
                                        <div class="card-text">
                                            <form class="form-group" action="/wearitem" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="id" name="id" value="{{ $data->itemid }}">
                                                <input type="hidden" id="robloxid" name="robloxid" value="{{ $data->robloxid }}">
                                                <input type="hidden" id="filter" name="filter" value="<?php echo $filterset; ?>">
                                                <input type="hidden" id="filtervalue" name="filtervalue" value="<?php echo $filterquery; ?>">

                                                @if ($wearing == 0)
                                                    <button type="submit" class="btn btn-info btn" role="button" style="padding: 10px;">Wear</button>
                                                @else
                                                    <button type="submit" class="btn btn-danger btn" role="button" style="padding: 10px;">Remove</button>
                                                @endif
                                            </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center" style="margin-top:25px;">
                                {!! $items->onEachSide(2)->links() !!}
                            </div>
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

<style>
.btn-square-sm {
width: 50px !important;
max-width: 100% !important;
max-height: 100% !important;
height: 50px !important;
text-align: center;
padding: 0px;
font-size:7px;
}
</style>
            <!-- Modal -->
            <div class="modal fade" id="bodycolors" tabindex="-1" aria-labelledby="bodycolorsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bodycolorsLabel">Body Colors Editor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <script> var num = 0, bodypart = ""; </script>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="all" onclick="bodypart='all';">
                                <label class="form-check-label" for="all">
                                    All
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="head" onclick="bodypart='Head';">
                                <label class="form-check-label" for="head">
                                    Head
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="torso" onclick="bodypart='Torso';">
                                <label class="form-check-label" for="torso">
                                    Torso
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="leftarm" onclick="bodypart='LeftArm';">
                                <label class="form-check-label" for="leftarm">
                                    Left Arm
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="rightarm" onclick="bodypart='RightArm';">
                                <label class="form-check-label" for="rightarm">
                                    Right Arm
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="leftleg" onclick="bodypart='LeftLeg';">
                                <label class="form-check-label" for="leftleg">
                                    Left Leg
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="rightleg" onclick="bodypart='RightLeg';">
                                <label class="form-check-label" for="rightleg">
                                    Right Leg
                                </label>
                        </div>
                       
                    </div>
                    <hr>
                    <div class="modal-body">
                        <button type="button" style="background-color: #5A4C42;" class="btn btn-secondary btn-square-sm" id="364" onclick="num = 364;"></button>
                        <button type="button" style="background-color: #7C5C46;" class="btn btn-secondary btn-square-sm" id="217" onclick="num = 217;"></button>
                        <button type="button" style="background-color: #AF9483;" class="btn btn-secondary btn-square-sm" id="359" onclick="num = 359;"></button>
                        <button type="button" style="background-color: #CC8E69;" class="btn btn-secondary btn-square-sm" id="18" onclick="num = 18;"></button>
                        <button type="button" style="background-color: #EAB892;" class="btn btn-secondary btn-square-sm" id="125" onclick="num = 125;"></button>
                        <button type="button" style="background-color: #564236;" class="btn btn-secondary btn-square-sm" id="361" onclick="num = 361;"></button>
                        <button type="button" style="background-color: #694028;" class="btn btn-secondary btn-square-sm" id="192" onclick="num = 192;"></button>
                        <button type="button" style="background-color: #BC9B5D;" class="btn btn-secondary btn-square-sm" id="351" onclick="num = 351;"></button>
                        <button type="button" style="background-color: #C7AC78;" class="btn btn-secondary btn-square-sm" id="352" onclick="num = 352;"></button>
                        <button type="button" style="background-color: #D7C59A;" class="btn btn-secondary btn-square-sm" id="5" onclick="num = 5;"></button>
                        <button type="button" style="background-color: #957977;" class="btn btn-secondary btn-square-sm" id="153" onclick="num = 153;"></button>
                        <button type="button" style="background-color: #A34B4B;" class="btn btn-secondary btn-square-sm" id="1007" onclick="num = 1007;"></button>
                        <button type="button" style="background-color: #DA867A;" class="btn btn-secondary btn-square-sm" id="101" onclick="num = 101;"></button>
                        <button type="button" style="background-color: #FFC9C9;" class="btn btn-secondary btn-square-sm" id="1025" onclick="num = 1025;"></button>
                        <button type="button" style="background-color: #FF98DC;" class="btn btn-secondary btn-square-sm" id="330" onclick="num = 330;"></button>
                        <button type="button" style="background-color: #74869D;" class="btn btn-secondary btn-square-sm" id="135" onclick="num = 135;"></button>
                        <button type="button" style="background-color: #527CAE;" class="btn btn-secondary btn-square-sm" id="305" onclick="num = 305;"></button>
                        <button type="button" style="background-color: #80BBDC;" class="btn btn-secondary btn-square-sm" id="11" onclick="num = 11;"></button>
                        <button type="button" style="background-color: #B1A7FF;" class="btn btn-secondary btn-square-sm" id="1026" onclick="num = 1026;"></button>
                        <button type="button" style="background-color: #A75E9B;" class="btn btn-secondary btn-square-sm" id="321" onclick="num = 321;"></button>
                        <button type="button" style="background-color: #008F9C;" class="btn btn-secondary btn-square-sm" id="107" onclick="num = 107;"></button>
                        <button type="button" style="background-color: #5B9A4C;" class="btn btn-secondary btn-square-sm" id="310" onclick="num = 310;"></button>
                        <button type="button" style="background-color: #7C9C6B;" class="btn btn-secondary btn-square-sm" id="317" onclick="num = 317;"></button>
                        <button type="button" style="background-color: #A1C48C;" class="btn btn-secondary btn-square-sm" id="29" onclick="num = 29;"></button>
                        <button type="button" style="background-color: #E29B40;" class="btn btn-secondary btn-square-sm" id="105" onclick="num = 105;"></button>
                        <button type="button" style="background-color: #F5CD30;" class="btn btn-secondary btn-square-sm" id="24" onclick="num = 24;"></button>
                        <button type="button" style="background-color: #F8D96D;" class="btn btn-secondary btn-square-sm" id="334" onclick="num = 334;"></button>
                        <button type="button" style="background-color: #635F62;" class="btn btn-secondary btn-square-sm" id="199" onclick="num = 199;"></button>
                        <button type="button" style="background-color: #CDCDCD;" class="btn btn-secondary btn-square-sm" id="1002" onclick="num = 1002;"></button>
                        <button type="button" style="background-color: #F8F8F8;" class="btn btn-secondary btn-square-sm" id="1001" onclick="num = 1001;"></button>
                        <button type="button" style="background-color: #1B2A35;" class="btn btn-secondary btn-square-sm" id="26" onclick="num = 26;"></button>
                        <button type="button" style="background-color: #FF66CC;" class="btn btn-secondary btn-square-sm" id="1016" onclick="num = 1016;"></button>
                        <button type="button" style="background-color: #FF0000;" class="btn btn-secondary btn-square-sm" id="1004" onclick="num = 1004;"></button>
                        <button type="button" style="background-color: #C4281C;" class="btn btn-secondary btn-square-sm" id="21" onclick="num = 21;"></button>
                        <button type="button" style="background-color: #AA00AA;" class="btn btn-secondary btn-square-sm" id="1015" onclick="num = 1015;"></button>
                        <button type="button" style="background-color: #80BBDC;" class="btn btn-secondary btn-square-sm" id="11" onclick="num = 11;"></button>
                        <button type="button" style="background-color: #0000FF;" class="btn btn-secondary btn-square-sm" id="1010" onclick="num = 1010;"></button>
                        <button type="button" style="background-color: #2154B9;" class="btn btn-secondary btn-square-sm" id="1012" onclick="num = 1012;"></button>
                        <button type="button" style="background-color: #FDEA8D;" class="btn btn-secondary btn-square-sm" id="226" onclick="num = 226;"></button>
                        <button type="button" style="background-color: #4B974B;" class="btn btn-secondary btn-square-sm" id="37" onclick="num = 37;"></button>
                    </div>
                <div class="modal-footer">

                <script>
                function redirect() {   
                    if(bodypart != "" && num != 0)
                        window.location.replace("<?php echo env('APP_URL')."/bodycolors"; ?>?bpart="+bodypart+"&color="+num);   
                }  
                </script>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="redirect()">Save changes</button>
                </div>
            </div>  
        </div>
    </div>
</x-app-layout>
