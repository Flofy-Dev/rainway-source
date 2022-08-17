<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name'); }} - Shop</title>
    </head>
</html>

<x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome to the shop! Here you can buy items to customize your avatar!
                </div>
            </div>
            <div style="margin-top:25px;" class="container">
                <form action="/itemsearch" method="GET" role="search">
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
            </div>
            <div class="col d-flex justify-content py-12">
            <div class="list-group">
            @if (Auth::user()->admin == 1)
                <div style="padding:10px;" class="list-group">
                    <button data-bs-toggle="modal" data-bs-target="#item" class="list-group-item list-group-item-action active">
                        Create item
                    </button>
                </div>

                <form action="/createitem" method="POST">
                {{ csrf_field() }}
                <!-- Modal -->
                <div class="modal fade" id="item" tabindex="-1" aria-labelledby="item" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title">Item Creator</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Name</span>
                                <input required="true" type="text" name="name" id="name" class="form-control" placeholder="" aria-label="name" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Description</span>
                                <input required="true" type="text" name="desc" id="desc" class="form-control" placeholder="" aria-label="desc" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Price</span>
                                <input required="true" type="number" name="price" id="price" class="form-control" placeholder="" aria-label="price" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Roblox Asset ID</span>
                                <input required="true" type="number" name="id" id="id" class="form-control" placeholder="" aria-label="id" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Type</span>
                                <select required="true" name="type" id="type" class="form-control" placeholder="" aria-label="type" aria-describedby="basic-addon1">
                                    <option value="hat">Hat</option>
                                    <option value="face">Face</option>
                                    <option value="gear">Gear</option>
                                    <option value="shirt">Shirt</option>
                                    <option value="t-shirt">T-Shirt</option>
                                    <option value="pants">Pants</option>
                                </select>
                            </div>
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
                <button style="pointer-events: none;" class="list-group-item list-group-item-action active">
                    Category
                </button>
                <a href="/shop" class="list-group-item list-group-item-action">All</a>
                <a href="/shop?filter=hat" class="list-group-item list-group-item-action">Hats</a>
                <a href="/shop?filter=face" class="list-group-item list-group-item-action">Faces</a>
                <a href="/shop?filter=gear" class="list-group-item list-group-item-action">Gear</a>

                <div class="btn-group">
                    <a href="/shop?filter=clothing" type="button" class="list-group-item list-group-item-action btn bg-white">Clothing</a>
                    <button type="button" class="list-group-item list-group-item-action btn bg-white dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/shop?filter=shirt">Shirts</a>
                        <a class="dropdown-item" href="/shop?filter=t-shirt">T-Shirts</a>
                        <a class="dropdown-item" href="/shop?filter=pants">Pants</a>
                    </div>
                </div>
            </div>
            <?php 
                if(isset($_GET['filter']))
                {
                    $filter = $_GET['filter'];
                    if($filter == "clothing")
                        $items = DB::table('shop')->where('type',"shirt")->orWhere('type',"t-shirt")->orWhere('type',"pants")->orderBy('itemid')->paginate(12);
                    else
                        $items = DB::table('shop')->where('type', $filter)->orderBy('itemid')->paginate(12);
                    $items->setPath('/shop?filter='.$filter);
                }
                else
                    $items = DB::table('shop')->orderBy('itemid')->paginate(12);
                
                $sessionvalue = session('itemsearched');
                if($sessionvalue == 'true')
                {
                    $items = session('itemdata');
                    session(['itemsearched' => 'false']);
                }

                
            ?>
            @if (!empty($items))
            <div class="container mt-5 row" style="position: relative; left:50px;">
                @foreach($items as $data)
                <div class="card" style="width: 10rem; height: auto;">
                    <a href="/item?id={{ $data->itemid }}"> <img class="card-img-top" src="{{ $data->thumbnail }}"> </a>
                    <div class="card-body">
                        <a href="/item?id={{ $data->itemid }}"> <h5 class="card-title font-weight-bold">{{ $data->name }}</h5> </a>
                        <div class="card-text">
                            <div style="position:relative; right:19.5%;" class="sm:flex sm:items-center sm:ml-6">
                                <x-moneyicon></x-moneyicon>
                                <p style="position:relative; left:4px;"> {{ $data->price }}</p>
                            </div>
                        </div>
                     </div>
                </div>
                @endforeach
            </div>
            </div>
            {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $items->links() !!}
                </div>
        </div>
            @else
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            Item not found. Try searching again!
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </div>
</x-app-layout>
