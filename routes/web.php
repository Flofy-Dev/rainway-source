<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function () {
    return view('welcome');
});

Route::any('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::any('/shop', function () {
    return view('shop');
})->middleware(['auth', 'verified'])->name('shop');

Route::any('/settings', function () {
    return view('settings');
})->middleware(['auth', 'verified'])->name('settings');

Route::any('/avatar', function () {
    return view('avatar');
})->middleware(['auth', 'verified'])->name('avatar');

Route::any('/profile', function () {
    return view('profile');
})->middleware(['auth', 'verified'])->name('profile');

Route::any('/games', function () {
    return view('games');
})->middleware(['auth', 'verified'])->name('games');

Route::any('/users', function () {
    return view('users');
})->middleware(['auth', 'verified'])->name('users');

Route::any('/download', function () {
    return view('download');
})->middleware(['auth', 'verified'])->name('download');

Route::any('/item', function () {
    return view('item');
})->middleware(['auth', 'verified'])->name('item');

Route::get('/downloadfile', function () {
    return Storage::download('Rainway Setup.exe');
})->middleware(['auth', 'verified'])->name('downloadfile');

Route::get('/join', function () {
    return view('join');
})->middleware(['auth', 'verified'])->name('join');

Route::any ( '/search', function () {
    session(['searched' => 'true']);
    $q = Request::get('q');
    
    if($q != ""){
        $users = DB::table('users')->where('name','LIKE','%'.$q.'%')->where('status', 1)->whereNotNull('email_verified_at')->paginate(10);
        if( $users->isEmpty() )
            session(['data' => '']);
        else
            session(['data' => $users]);
    }
    return view ('users');
})->middleware(['auth', 'verified'])->name('search');

Route::any ( '/itemsearch', function () {
    session(['itemsearched' => 'true']);
    $q = "";
    $filter = "";
    if(isset($_GET['q']))
        $q = $_GET['q'];
    if(isset($_GET['filter']))
        $filter = $_GET['filter'];

    if($q != ""){
        if(isset($_GET['filter']))
        {
            if($filter == "clothing")
                $items = DB::table('shop')->where('type',"shirt")->orWhere('type',"t-shirt")->orWhere('type',"pants")->where('name','LIKE','%'.$q.'%')->paginate(12);
            else
                $items = DB::table('shop')->where('type', $filter)->where('name','LIKE','%'.$q.'%')->paginate(12);
            $items->setPath('/itemsearch?q='.$q.'&filter='.$filter);
        }
        else
        {
            $items = DB::table('shop')->where('name','LIKE','%'.$q.'%')->paginate(12);
            $items->setPath('/itemsearch?q='.$q);
        }
        
        if( $items->isEmpty() )
            session(['itemdata' => '']);
        else
            session(['itemdata' => $items]);
    }
    return view ('shop');
})->middleware(['auth', 'verified'])->name('itemsearch');

Route::any ( '/avatarsearch', function () {
    session(['avatarsearched' => 'true']);
    $q = "";
    $filter = "";
    $userid = Auth::user()->id;
    if(isset($_GET['q']))
        $q = $_GET['q'];
    if(isset($_GET['filter']))
        $filter = $_GET['filter'];

    if($q != ""){
        if(isset($_GET['filter']))
        {
            if($filter == "clothing")
            {
                $items = DB::table('owneditems')->where('user', $userid)->where(function ($q) {
                    $q->where('type',"shirt")->orWhere('type',"t-shirt")->orWhere('type',"pants");
                })->where('itemname','LIKE','%'.$q.'%')->paginate(3);
            }
            else
                $items = DB::table('owneditems')->where('user', $userid)->where('type', $filter)->where('itemname','LIKE','%'.$q.'%')->paginate(3);
            $items->setPath('/avatarsearch?q='.$q.'&filter='.$filter);
        }
        else
        {
            $items = DB::table('owneditems')->where('user', $userid)->where('itemname','LIKE','%'.$q.'%')->paginate(3);
            $items->setPath('/avatarsearch?q='.$q);
        }
        
        if( $items->isEmpty() )
            session(['avatardata' => '']);
        else
            session(['avatardata' => $items]);
    }
    return view ('avatar');
})->middleware(['auth', 'verified'])->name('avatarsearch');

Route::any ( '/adminsearch', function () {
    session(['adminsearched' => 'true']);
    $q = Request::get('q');
    
    if($q != ""){
        $users = DB::table('users')->where('name','LIKE','%'.$q.'%')->paginate(10);
        if( $users->isEmpty() )
            session(['admindata' => '']);
        else
            session(['admindata' => $users]);
    }
    return view ('adminpanel');
})->middleware(['auth', 'verified'])->name('adminsearch');

Route::post('/banuser', function () {
    $username = $_POST["username_ban"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['status' => 0, 'admin' => 0]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('banuser');

Route::post('/unbanuser', function () {
    $username = $_POST["username_unban"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['status' => 1]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('unbanuser');

Route::post('/adminpromote', function () {
    $username = $_POST["username_promote"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['admin' => 1]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('adminpromote');

Route::post('/admindemote', function () {
    $username = $_POST["username_demote"];
    $page = DB::table('users')->where('name', $username)->value('id');
    $page = strval(ceil($page / 5));
    $url = "/adminpanel?page=$page";
    
    DB::table('users')
        ->where('name', $username)
        ->update(['admin' => 0]);
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('admindemote');

Route::get('/bodycolors', function () {
    $bodypart = $_GET["bpart"];
    $color = $_GET["color"];
    $userid = Auth::user()->id;

    if($bodypart != "all")
    {
        DB::table('users')
        ->where('id', $userid)
        ->update([$bodypart => $color]);
    }
    else
    {
        DB::table('users')
        ->where('id', $userid)
        ->update([
            'Head' => $color,
            'Torso' => $color,
            'LeftArm' => $color,
            'RightArm' => $color,
            'LeftLeg' => $color,
            'RightLeg' => $color
        ]);    
    }
    
    $head = DB::table('users')->where('id', $userid)->value('Head');
    $torso = DB::table('users')->where('id', $userid)->value('Torso');
    $leftarm = DB::table('users')->where('id', $userid)->value('LeftArm');
    $rightarm = DB::table('users')->where('id', $userid)->value('RightArm');
    $leftleg = DB::table('users')->where('id', $userid)->value('LeftLeg');
    $rightleg = DB::table('users')->where('id', $userid)->value('RightLeg');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://renderservice.rainway.xyz/bodycolors.php?head=$head&torso=$torso&rightarm=$rightarm&leftarm=$leftarm&rightleg=$rightleg&leftleg=$leftleg");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_exec($ch);
    curl_close($ch);

    $renderurl = "http://renderservice.rainway.xyz/render.php?";
    $items = DB::table('owneditems')->where('user', $userid)->where('wearing', 1)->paginate(9999999);
    $assetnumber = 1;

    if (!empty($items))
        foreach($items as $data)
        {
            $renderurl = $renderurl.'asset'.$assetnumber.'='.$data->robloxid.'&';
            $assetnumber++;
        }
    echo $renderurl;
    $render = file_get_contents($renderurl);

    DB::table('users')
        ->where('id', $userid)
        ->update(['avatar' => $render]);

    $url = env('APP_URL')."/avatar";
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('bodycolors');

Route::any('/redraw', function () {
    $userid = Auth::user()->id;
    $head = DB::table('users')->where('id', $userid)->value('Head');
    $torso = DB::table('users')->where('id', $userid)->value('Torso');
    $leftarm = DB::table('users')->where('id', $userid)->value('LeftArm');
    $rightarm = DB::table('users')->where('id', $userid)->value('RightArm');
    $leftleg = DB::table('users')->where('id', $userid)->value('LeftLeg');
    $rightleg = DB::table('users')->where('id', $userid)->value('RightLeg');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://renderservice.rainway.xyz/bodycolors.php?head=$head&torso=$torso&rightarm=$rightarm&leftarm=$leftarm&rightleg=$rightleg&leftleg=$leftleg");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_exec($ch);
    curl_close($ch);

    $renderurl = "http://renderservice.rainway.xyz/render.php?";
    $items = DB::table('owneditems')->where('user', $userid)->where('wearing', 1)->paginate(9999999);
    $assetnumber = 1;

    if (!empty($items))
        foreach($items as $data)
        {
            $renderurl = $renderurl.'asset'.$assetnumber.'='.$data->robloxid.'&';
            $assetnumber++;
        }
    echo $renderurl;
    $render = file_get_contents($renderurl);

    DB::table('users')
        ->where('id', $userid)
        ->update(['avatar' => $render]);

    $url = env('APP_URL')."/avatar";
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('redraw');

Route::post('/changeblurb', function () {
    $blurb = $_POST['blurb'];
    $userid = Auth::user()->id;
    DB::table('users')
        ->where('id', $userid)
        ->update(['blurb' => $blurb]);

    $url = env('APP_URL')."/profile?id=".$userid;
    header("Location: $url");
    exit;
})->middleware(['auth', 'verified'])->name('changeblurb');

Route::post('/createitem', function () {
    $name = $_POST['name'];
    $description = $_POST['desc'];
    $price = abs($_POST['price']);
    $assetid = $_POST['id'];
    $type = $_POST['type'];
    $thumbnail = file_get_contents("http://renderservice.rainway.xyz/thumbnail.php?id=$assetid");
    $creator = Auth::user()->id;

    $query = DB::table('shop')->where('robloxid', $assetid)->value('name');
    $q = DB::table('shop')->where('name', $name)->value('name');
    
    if(empty($query) && empty($q) && is_numeric($assetid)){
        DB::table('shop')->insert(
            array(
               'name'     =>   $name, 
               'description'   =>   $description,
               'price'     =>   $price, 
               'thumbnail'   =>   $thumbnail,
               'robloxid'   =>   $assetid,
               'onsale'   =>   1,
               'creator'   =>   $creator,
               'type'   =>   $type
            )
        );
    }

    $url = env('APP_URL')."/shop";
    header("Location: $url");
    exit;
})->middleware(['auth', 'verified'])->name('createitem');

Route::post('/buyitem', function () {
    $userid = $_POST['id'];
    $price = $_POST['price'];
    $assetid = $_POST['robloxid'];
    $type = $_POST['type'];
    $id = $_POST['itemid'];

    $itemowned = DB::table('owneditems')->where('user', $userid)->where('itemid', $id)->value('itemid');
    
    $rainbux = Auth::user()->rainbux;

    $itemname = DB::table('shop')->where('itemid', $id)->value('name');
    
    if(empty($itemowned) && $rainbux >= $price){
        $rainbux = $rainbux - $price;

        DB::table('users')
            ->where('id', $userid)
            ->update(['rainbux' => $rainbux]);

        DB::table('owneditems')->insert(
            array(
               'user'     =>   $userid, 
               'itemid'   =>   $id,
               'robloxid'   =>   $assetid,
               'itemname'   =>   $itemname,
               'type'   =>   $type
            )
        );
    }

    $url = env('APP_URL')."/item?id=".$id;
    header("Location: $url");
    exit;
})->middleware(['auth', 'verified'])->name('buyitem');

Route::any('/adminpanel', function () {
    return view('adminpanel');
})->middleware(['auth', 'verified'])->name('adminpanel');

Route::post('/wearitem', function () {
    $itemid = $_POST["id"];
    $assetid = $_POST["robloxid"];
    $userid = Auth::user()->id;
    
    $items = DB::table('owneditems')->where('user', $userid)->where('itemid', $itemid)->paginate(3);
    $assetnumber = 1;

    if (!empty($items))
        foreach($items as $data)
        {
            if($data->itemid == $itemid)
                break;
            $assetnumber++;
        }
        
    $page = strval(ceil($assetnumber / 3));

    $url = "/avatar?page=$page";

    $wearing = DB::table('owneditems')->where('user', $userid)->where('itemid', $itemid)->value('wearing');
    $type = DB::table('owneditems')->where('user', $userid)->where('itemid', $itemid)->value('type');
    $typecount = DB::table('owneditems')->where('user', $userid)->where('type', $type)->where('wearing', 1)->count();

    if($wearing == 0)
    {
        if($type == "hat" && $typecount <= 5)
        {
            DB::table('owneditems')
                ->where('user', $userid)
                ->where('itemid', $itemid)
                ->update(['wearing' => 1]);
        }
        else if($typecount == 0)
        {
            DB::table('owneditems')
                ->where('user', $userid)
                ->where('itemid', $itemid)
                ->update(['wearing' => 1]);
        }
        else
        $url = "/avatar?page=$page&error=true";
    }
    else
    {
        DB::table('owneditems')
        ->where('user', $userid)
        ->where('itemid', $itemid)
        ->update(['wearing' => 0]);
    }
        
    header("Location: $url");
    exit;
    
})->middleware(['auth', 'verified'])->name('wearitem');

require __DIR__.'/auth.php';