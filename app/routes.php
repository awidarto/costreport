<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::controller('user', 'UserController');
Route::controller('usergroup', 'UsergroupController');

Route::controller('advertiser', 'AdvertiserController');
Route::controller('shopcategory', 'ShopcategoryController');

Route::controller('report', 'ReportController');
Route::controller('menu', 'MenuController');

Route::controller('picture','PictureController');

Route::controller('option', 'OptionController');

Route::controller('activity', 'ActivityController');

Route::controller('scanner', 'ScannerController');

Route::controller('dashboard', 'DashboardController');

Route::controller('merchant', 'MerchantController');

Route::controller('stats', 'StatsController');

Route::controller('assettype', 'AssettypeController');
Route::controller('assetlocation', 'AssetlocationController');
Route::controller('rack', 'RackController');
Route::controller('asset', 'AssetController');

Route::controller('employee', 'EmployeeController');

Route::controller('holiday', 'HolidayController');
Route::controller('company', 'CompanyController');
Route::controller('dateparam', 'DateparamController');

Route::controller('nonstafftime', 'NonstafftimeController');
Route::controller('stafftime', 'StafftimeController');

Route::controller('coa', 'CoaController');
Route::controller('gl', 'GlController');
Route::controller('afegl', 'AfeglController');

Route::controller('approval', 'ApprovalController');
Route::controller('activity', 'ActivityController');
Route::controller('access', 'AccessController');
Route::controller('apiaccess', 'ApiaccessController');

//report routes
Route::controller('approvalreport', 'ApprovalreportController');


Route::controller('upload', 'UploadController');
Route::controller('ajax', 'AjaxController');

Route::controller('profile', 'ProfileController');

Route::get('/', 'DashboardController@getIndex');


Route::group(array('prefix' => 'api/v1' ), function()
{
});

/*
 * @author juntriaji
 * Route for API
 */

Route::group(array('prefix' => 'api/v1'), function (){
    Route::get('/auth', 'Api\AuthController@index');
    Route::post('/auth/login', 'Api\AuthController@login');
    Route::put('/auth/login', 'Api\AuthController@login');
    Route::post('/auth/logout', 'Api\AuthController@logout');
    Route::put('/auth/logout', 'Api\AuthController@logout');
    Route::resource('location', 'Api\LocationapiController');
    Route::resource('rack', 'Api\RackapiController');
    Route::resource('asset', 'Api\AssetapiController');
});



Route::get('btest',function(){
    $model = new Merchant();

    $model = $model->where('id',245);
    $model = $model->orWhere('username','like', '%Hastuti%');

    $result = $model->get();

    print_r($result->toArray());

});

Route::get('tonumber',function(){
    $property = new Property();

    $props = $property->get()->toArray();

    $seq = new Sequence();

    foreach($props as $p){

        $_id = new MongoId($p['_id']);

        $price = new MongoInt32( $p['listingPrice'] );
        $fmv = new MongoInt32( $p['FMV'] );

        $sdata = array(
            'listingPrice'=>$price,
            'FMV'=>$fmv
            );

        if( $property->where('_id','=', $_id )->update( $sdata ) ){
            print $p['_id'].'->'.$sdata['listingPrice'].'<br />';
        }

    }

});

Route::get('syncmerchant', function(){

    set_time_limit(0);

    $mymerchant = Merchant::where('group_id',4)->get();

    foreach($mymerchant->toArray() as $m){
        //print_r($m);
        //$m['mid'] = $m['id'];
        //unset($m['id']);
        $member = Member::where('id',$m['id'])->first();

        if($member){

        }else{
            $member = new Member();
        }

        foreach ($m as $k=>$v) {
            $member->{$k} = $v;
        }

        $member->status = 'inactive';
        $member->url = '';
        $member->legacyId = new MongoInt32($m['id']);

        $member->roleId = Prefs::getRoleId('Merchant');

        $member->save();

    }

});

Route::get('addrole',function(){
    $members = Member::get();

    foreach($members as $m){
        $m->roleId = Prefs::getRoleId('Merchant');
        $m->save();
    }
});

Route::get('impcat',function(){

    $slugs = array(
        'Others'=>'others',
        'Music Instruments'=>'music-instruments',
        'Electronics'=>'electronics',
        'Motorcycle Accessories'=>'motorcycle-accessories',
        'Homes and Gardens'=>'homes-and-gardens',
        'Pet Supplies'=>'pet-supplies',
        'Food & Health'=>'food-health',
        'Health & Beauty'=>'health-beauty',
        'Watch & Jewelry watch-jewelry',
        'Collectibles'=>'collectibles',
        'Food & Health'=>'food-health',
        'Fashion & Accessories'=>'fashion-accessories',
        'Books & Magazines'=>'books-magazines',
        'Toys & Games'=>'toys-games',
        'Infants & Children'=>'infants-children',
        'Sporting Goods'=>'sporting-goods'
    );

    $csvfile = public_path().'/storage/import/jex_shops2.csv';

    $imp = array();

    Excel::load($csvfile,function($reader) use (&$imp){
        $imp = $reader->toArray();
    })->get();

    print_r($imp);

    $count = 0;
    foreach($imp as $s){

        $m = Member::where('id',strval($s['id']))->first();

        if($m){
            $count++;
            $m->shopcategory = $s['shopcategory'];
            $m->shopcategoryLink = $slugs[ trim($s['shopcategory']) ];

            $m->status = 'active';

            $m->save();

            print_r($m);
        }
    }
    print $count."\r\n";

});


Route::get('regeneratepic/{obj?}',function($obj = null){

    set_time_limit(0);

    if(is_null($obj)){
        $product = new Product();
    }else{
        switch($obj){
            case 'product' :
                        $product = new Product();
                        break;
            case 'page' :
                        $product = new Page();
                        break;
            case 'post' :
                        $product = new Posts();
                        break;
            default :
                        $product = new Product();
                        break;
        }
    }

    $props = $product->get();

    //$seq = new Sequence();

    $sizes = Config::get('picture.sizes');

    foreach($props as $p){

        if(isset($p->files)){
            $files = $p->files;

            foreach($files as $folder=>$files){

                $dir = public_path().'/storage/media/'.$folder;

                if (is_dir($dir) && file_exists($dir)) {
                    if ($dh = opendir($dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if($file != '.' && $file != '..'){
                                if(!preg_match('/^lrg_|med_|th_|full_/', $file)){
                                    echo $dir.'/'.$file."\n";

                                    $destinationPath = $dir;
                                    $filename = $file;

                                    $urls = array();

                                    foreach($sizes as $k=>$v){
                                        $thumbnail = Image::make($destinationPath.'/'.$filename)
                                            ->fit($v['width'],$v['height'])
                                            //->insert($sm_wm,0,0, 'bottom-right')
                                            ->save($destinationPath.'/'.$v['prefix'].$filename);
                                    }
                                    /*
                                    $thumbnail = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['thumbnail']['width'] ,$sizes['thumbnail']['height'])
                                        ->save($destinationPath.'/th_'.$filename);

                                    $medium = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['medium']['width'] ,$sizes['medium']['height'])
                                        ->save($destinationPath.'/med_'.$filename);

                                    $large = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['large']['width'] ,$sizes['large']['height'])
                                        ->save($destinationPath.'/lrg_'.$filename);

                                    $full = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['full']['width'] ,$sizes['full']['height'])
                                        ->save($destinationPath.'/full_'.$filename);
                                    */
                                }
                            }
                        }
                        closedir($dh);
                    }
                }
            }

        }



    }

});

Route::get('pdf',function(){
    $content = "
    <page>
        <h1>Exemple d'utilisation</h1>
        <br>
        Ceci est un <b>exemple d'utilisation</b>
        de <a href='http://html2pdf.fr/'>HTML2PDF</a>.<br>
    </page>";

    $html2pdf = new HTML2PDF();
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf','D');
});


Route::get('smerchant',function(){
    $q = Input::get('term');

    $user = Merchant::where('group_id',4)
                ->where(function($query) use($q) {
                    $query->where('merchantname','like','%'.$q.'%')
                        ->orWhere('fullname','like','%'.$q.'%');
                })->get();

    print_r($user->toArray());
});
/*
Route::get('brochure/dl/{id}',function($id){

    $prop = Property::find($id)->toArray();

    //return View::make('print.brochure')->with('prop',$prop)->render();

    $content = View::make('print.brochure')->with('prop',$prop)->render();

    //return $content;

    return PDF::loadView('print.brochure',array('prop'=>$prop))
        ->stream('download.pdf');
});

Route::get('brochure',function(){
    View::make('print.brochure');
});
*/

Route::get('inc/{entity}',function($entity){

    $seq = new Sequence();
    print_r($seq->getNewId($entity));

});

Route::get('last/{entity}',function($entity){

    $seq = new Sequence();
    print( $seq->getLastId($entity) );

});

Route::get('init/{entity}/{initial}',function($entity,$initial){

    $seq = new Sequence();
    print_r( $seq->setInitialValue($entity,$initial));

});

Route::get('hashme/{mypass}',function($mypass){

    print Hash::make($mypass);
});

Route::get('xtest',function(){
    Excel::load('WEBSITE_INVESTORS_ALLIANCE.xlsx')->calculate()->dump();
});

Route::get('xcat',function(){
    print_r(Prefs::getCategory());
});

Route::get('barcode/dl/{txt}',function($txt){
    $barcode = new Barcode();
    $barcode->make($txt,'code128',60, 'horizontal' ,true);
    return $barcode->render('jpg',$txt,true);
});

Route::get('barcode/{txt}',function($txt){
    $barcode = new Barcode();
    $barcode->make($txt,'code128',60, 'horizontal' ,true);
    return $barcode->render('jpg',$txt);
});

Route::get('qr/{txt}',function($txt){
    $txt = base64_decode($txt);
    return QRCode::format('png')->size(399)->color(40,40,40)->generate($txt);
});

Route::get('pdf417/{txt}',function($txt){
    $txt = base64_decode($txt);
    header('Content-Type: image/svg+xml');
    print DNS2D::getBarcodeSVG($txt, "PDF417");
});

Route::get('media',function(){
    $media = Product::all();

    print $media->toJson();

});

Route::get('login',function(){
    return View::make('login')->with('title','Sign In');
});

Route::post('login',function(){

    // validate the info, create rules for the inputs
    $rules = array(
        'email'    => 'required|email',
        'password' => 'required|alphaNum|min:3'
    );

    // run the validation rules on the inputs from the form
    $validator = Validator::make(Input::all(), $rules);

    // if the validator fails, redirect back to the form
    if ($validator->fails()) {
        return Redirect::to('login')->withErrors($validator);
    } else {

        $userfield = Config::get('kickstart.user_field');
        $passwordfield = Config::get('kickstart.password_field');

        // find the user
        $user = User::where($userfield, '=', Input::get('email'))->first();
        /*
        $member = Member::where('email', '=', Input::get('email'))
                        ->whereOr('fullname','=', Input::get('email'))
                        ->first();
        */
        // check if user exists
        if ($user) {
            // check if password is correct
            if (Hash::check(Input::get('password'), $user->{$passwordfield} )) {

                //print $user->{$passwordfield};
                //exit();
                // login the user
                Auth::login($user);

                return Redirect::to('/');

            } else {
                // validation not successful
                // send back to form with errors
                // send back to form with old input, but not the password
                return Redirect::to('login')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            }
        }
        /* else if($member){

            //print_r($member);

            if (Prefs::hashcheck(Input::get('password'), $member->password )) {

                //print $user->{$passwordfield};
                //print_r($member);
                //exit();
                // login the user
                Auth::login($member);

                //print_r(Auth::user());

                return Redirect::to('/');

            } else {
                // validation not successful
                // send back to form with errors
                // send back to form with old input, but not the password
                return Redirect::to('login')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            }

        } */
        else {
            // user does not exist in database
            // return them to login with message
            Session::flash('loginError', 'This user does not exist.');
            return Redirect::to('login');
        }

    }

});

Route::get('logout',function(){
    Auth::logout();
    return Redirect::to('/');
});

/* Filters */

Route::filter('jauth', function()
{
    //print_r(Auth::user());

    //exit();

    if (!Auth::user()){
        Session::put('redirect',URL::full());
        return Redirect::to('login');
    }

    if($redirect = Session::get('redirect')){
        Session::forget('redirect');
        return Redirect::to($redirect);
    }

    //if (Auth::guest()) return Redirect::to('login');
});

function sa($item){
    if(URL::to($item) == URL::full() ){
        return  'active';
    }else{
        return '';
    }
}

function hsa($item){
    if(is_array($item)){
        foreach ($item as $it) {
            if(URL::to($it) == URL::full() ){
                return  'nav-active active';
            }else{
                return '';
            }
        }
    }else{
        if(URL::to($item) == URL::full() ){
            return  'nav-active active';
        }else{
            return '';
        }
    }
}

function boldfirst($title){
    $t = explode(' ',$title);
    if(count($t) > 1){
        $t[0] = '<strong>'.$t[0].'</strong>';
        $title = implode(' ',$t);
        return $title;
    }else{
        return '<strong>'.$title.'</strong>';
    }
}
