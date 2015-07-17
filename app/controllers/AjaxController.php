<?php

class AjaxController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | The Default Controller
    |--------------------------------------------------------------------------
    |
    | Instead of using RESTful routes and anonymous functions, you might wish
    | to use controllers to organize your application API. You'll love them.
    |
    | This controller responds to URIs beginning with "home", and it also
    | serves as the default controller for the application, meaning it
    | handles requests to the root of the application.
    |
    | You can respond to GET requests to "/home/profile" like so:
    |
    |       public function action_profile()
    |       {
    |           return "This is your profile!";
    |       }
    |
    | Any extra segments are passed to the method as parameters:
    |
    |       public function action_profile($id)
    |       {
    |           return "This is the profile for user {$id}.";
    |       }
    |
    */

    public function __construct(){

    }

    public function getIndex()
    {
    }

    public function postIndex()
    {

    }

    public function getMenu()
    {
        $tree = '[
                    {"title": "Books & Audible", "expanded": true, "folder": true, "children": [
                        {"title": "Books", "folder": true, "children": [
                            {"title": "Books"},
                            {"title": "Kindle Books"},
                            {"title": "Books For Study"},
                            {"title": "Audiobooks"}
                        ]},
                        {"title": "Movies, TV, Music, Games", "folder": true, "children": [
                            {"title": "Music"},
                            {"title": "MP3 Downloads"},
                            {"title": "Musical Instruments & DJ"},
                            {"title": "Film & TV"},
                            {"title": "Ble-ray"},
                            {"title": "PC & Video Games"}
                        ]},
                        {"title": "Electronics & Computers", "expanded": true, "folder": true, "children": [
                            {"title": "Electronics", "folder": true, "children": [
                                {"title": "Camera & Photo"},
                                {"title": "TV & Home Cinema"},
                                {"title": "Audio & HiFi"},
                                {"title": "Sat Nav & Car Electronics"},
                                {"title": "Phones"},
                                {"title": "Electronic Accessories"}
                            ]},
                            {"title": "Computers", "folder": true, "children": [
                                {"title": "Laptops"},
                                {"title": "Tablets"},
                                {"title": "Computer & Accessories"},
                                {"title": "Computer Components"},
                                {"title": "Software"},
                                {"title": "Printers & Ink"}
                            ]}
                        ]}
                    ]}
                ]';

        $tree = array(
                    array('title'=>'Computers', 'folder'=>true, 'expanded'=>true,'children'=>array(
                            array('title'=>'Laptops'),
                            array('title'=>'Tablets'),
                            array('title'=>'Computer & Accessories'),
                            array('title'=>'Computer Components'),
                            array('title'=>'Software'),
                            array('title'=>'Printers & Ink')
                        )
                    ),
                    array('title'=>'Electronics', 'folder'=>true, 'expanded'=>true,'children'=>array(
                            array('title'=>'Camera & Photo'),
                            array('title'=>'TV & Home Cinema'),
                            array('title'=>'Audio & HiFi'),
                            array('title'=>'Sat Nav & Car Electronics', 'folder'=>true, 'expanded'=>true,'children'=>array(
                                    array('title'=>'Sat Phones'),
                                    array('title'=>'GPS Navigator')
                            ) ),
                            array('title'=>'Phones'),
                            array('title'=>'Electronic Accessories')
                        )
                    ),
                );

        //print $tree;

        return Response::json($tree);
    }

    public function postAfe()
    {
        $code = Input::get('code');

        $select = Prefs::getAfe($code)->AfeToSelection('ANL_CODE', 'NAME', false );

        return Response::json(array('result'=>'OK', 'selection'=>$select ));
    }

    public function postScan()
    {
        $in = Input::get();

        $code = $in['txtin'];
        $outlet_id = $in['outlet_id'];
        $use_outlet = $in['search_outlet'];
        $action = strtolower( $in['action'] );

        $outlets = Prefs::getOutlet()->OutletToSelection('_id', 'name', false);

        $outlet_name = $outlets[$outlet_id];

        $res = 'OK';
        $msg = '';

        if(strripos($code, '|')){
            $code = explode('|', $code);
            $SKU = $code[0];
            $unit_id = $code[1];
        }else{
            $SKU = trim($code);
            $unit_id = null;
        }

        switch($action){
            case 'sell':
                if(is_null($unit_id)){
                    $res = 'NOK';
                    $msg = 'SKU: '.$SKU.' <br />Unit ID: NOT FOUND';
                    break;
                }
                $u = Stockunit::where('SKU','=', $SKU)
                    ->where('_id', 'like', '%'.$unit_id )
                    ->first();

                if($u){

                    $ul = $u->toArray();

                    $ul['scancheckDate'] = new MongoDate();
                    $ul['createdDate'] = new MongoDate();
                    $ul['lastUpdate'] = new MongoDate();
                    $ul['action'] = $action;
                    $ul['status'] = 'sold';
                    $ul['deliverTo'] = $outlet_name;
                    $ul['deliverToId'] = $outlet_id;
                    $ul['returnTo'] = $outlet_name;
                    $ul['returnToId'] = $outlet_id;

                    $unit_id = $ul['_id'];

                    unset($ul['_id']);

                    $ul['unitId'] = $unit_id;

                    Stockunitlog::insert($ul);

                    $history = array(
                        'datetime'=>new MongoDate(),
                        'action'=>$action,
                        'price'=>$ul['productDetail']['priceRegular'],
                        'status'=>$ul['status'],
                        'outletName'=>$ul['outletName']
                    );

                    //change status to sold
                    $u->status = 'sold';
                    $u->push('history', $history);

                    $u->save();

                    $res = 'OK';
                    $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

                }else{
                    $res = 'NOK';
                    $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
                }

                break;
            case 'check':
                    if(is_null($unit_id)){
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: NOT FOUND';
                        break;
                    }

                    $u = Stockunit::where('SKU','=', $SKU)
                        ->where('_id', 'like', '%'.$unit_id )
                        ->first();

                    if($u){

                        $ul = $u->toArray();

                        $ul['scancheckDate'] = new MongoDate();
                        $ul['createdDate'] = new MongoDate();
                        $ul['lastUpdate'] = new MongoDate();
                        $ul['action'] = $action;
                        $ul['deliverTo'] = $outlet_name;
                        $ul['deliverToId'] = $outlet_id;
                        $ul['returnTo'] = $outlet_name;
                        $ul['returnToId'] = $outlet_id;

                        $unit_id = $ul['_id'];

                        unset($ul['_id']);

                        $ul['unitId'] = $unit_id;

                        Stockunitlog::insert($ul);

                        $history = array(
                            'datetime'=>new MongoDate(),
                            'action'=>$action,
                            'price'=>$ul['productDetail']['priceRegular'],
                            'status'=>$ul['status'],
                            'outletName'=>$ul['outletName']
                        );

                        $u->push('history', $history);

                        $u->save();

                        $res = 'OK';
                        $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

                    }else{
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
                    }

                break;
            case 'deliver':
                    if(is_null($unit_id)){
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: NOT FOUND';
                        break;
                    }

                    $u = Stockunit::where('SKU','=', $SKU)
                        ->where('_id', 'like', '%'.$unit_id )
                        ->first();

                    if($u){

                        $ul = $u->toArray();

                        $ul['scancheckDate'] = new MongoDate();
                        $ul['createdDate'] = new MongoDate();
                        $ul['lastUpdate'] = new MongoDate();
                        $ul['action'] = $action;
                        $ul['deliverTo'] = $outlet_name;
                        $ul['deliverToId'] = $outlet_id;
                        $ul['returnTo'] = $outlet_name;
                        $ul['returnToId'] = $outlet_id;

                        $unit_id = $ul['_id'];

                        unset($ul['_id']);

                        $ul['unitId'] = $unit_id;

                        Stockunitlog::insert($ul);

                        $history = array(
                            'datetime'=>new MongoDate(),
                            'action'=>$action,
                            'price'=>$ul['productDetail']['priceRegular'],
                            'status'=>$ul['status'],
                            'outletName'=>$ul['outletName'],
                            'deliverTo'=>$outlet_name,
                            'deliverToId'=>$outlet_id
                        );

                        $u->push('history', $history);

                        $u->outletId = $outlet_id;
                        $u->outletName = $outlet_name;

                        $u->save();

                        $res = 'OK';
                        $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

                    }else{
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
                    }

                break;
            case 'return':
                    if(is_null($unit_id)){
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: NOT FOUND';
                        break;
                    }

                    $u = Stockunit::where('SKU','=', $SKU)
                        ->where('_id', 'like', '%'.$unit_id )
                        ->first();

                    if($u){

                        $ul = $u->toArray();

                        $ul['scancheckDate'] = new MongoDate();
                        $ul['createdDate'] = new MongoDate();
                        $ul['lastUpdate'] = new MongoDate();
                        $ul['action'] = $action;
                        $ul['deliverTo'] = $outlet_name;
                        $ul['deliverToId'] = $outlet_id;
                        $ul['returnTo'] = $outlet_name;
                        $ul['returnToId'] = $outlet_id;

                        $unit_id = $ul['_id'];

                        unset($ul['_id']);

                        $ul['unitId'] = $unit_id;

                        Stockunitlog::insert($ul);

                        $history = array(
                            'datetime'=>new MongoDate(),
                            'action'=>$action,
                            'price'=>$ul['productDetail']['priceRegular'],
                            'status'=>$ul['status'],
                            'outletName'=>$ul['outletName'],
                            'returnTo'=>$outlet_name,
                            'returnToId'=>$outlet_id
                        );

                        $u->push('history', $history);

                        $u->outletId = $outlet_id;
                        $u->outletName = $outlet_name;

                        $u->save();

                        $res = 'OK';
                        $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

                    }else{
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
                    }

                break;
            default:
                break;
        }

        $result = array(
            'result'=>$res,
            'msg'=>$msg
        );

        return Response::json($result);
    }


    public function postScancheck()
    {
        $in = Input::get();

        $code = $in['txtin'];
        $outlet_id = $in['outlet_id'];
        $use_outlet = $in['search_outlet'];

        $res = 'OK';


        if(strripos($code, '|')){
            $code = explode('|', $code);
            $SKU = $code[0];
            $unit_id = $code[1];

                if($use_outlet == 1){
                    $u = Stockunit::where('outletId','=', $outlet_id)
                        ->where('SKU','=', $SKU)
                        ->where('_id', 'like', '%'.$unit_id )
                        ->first();
                }else{
                    $u = Stockunit::where('SKU','=', $SKU)
                        ->where('_id', 'like', '%'.$unit_id )
                        ->first();
                }

            if($u){

                $ul = $u->toArray();

                $ul['scancheckDate'] = new MongoDate();
                $ul['createdDate'] = new MongoDate();
                $ul['lastUpdate'] = new MongoDate();

                $unit_id = $ul['_id'];

                unset($ul['_id']);

                $ul['unitId'] = $unit_id;

                Stockunitlog::insert($ul);

                $history = array(
                    'datetime'=>new MongoDate(),
                    'action'=>'scan',
                    'price'=>$ul['productDetail']['priceRegular'],
                    'status'=>$ul['status'],
                    'outletName'=>$ul['outletName']
                );

                $u->push('history', $history);

                $res = 'OK';
                $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

            }else{
                $res = 'NOK';
                $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
            }

        }else{
            $SKU = trim($code);

            if($use_outlet){
                $u = Stockunit::where('outletId','=',$outlet_id)
                    ->where('SKU','=',$SKU)
                    ->first();
            }else{
                $u = Stockunit::where('SKU','=',$SKU)
                    ->first();
            }


            if($u){


                $ul = $u->toArray();

                $ul['scancheckDate'] = new MongoDate();
                $ul['createdDate'] = new MongoDate();
                $ul['lastUpdate'] = new MongoDate();

                $unit_id = $ul['_id'];

                unset($ul['_id']);

                $ul['unitId'] = $unit_id;

                Stockunitlog::insert($ul);

                $history = array(
                    'datetime'=>new MongoDate(),
                    'action'=>'scan',
                    'price'=>$ul['productDetail']['priceRegular'],
                    'status'=>$ul['status'],
                    'outletName'=>$ul['outletName']
                    );

                $u->push('history', $history);

                $res = 'OK';
                $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

            }else{
                $res = 'NOK';
                $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
            }

        }


        $result = array(
            'result'=>$res,
            'msg'=>$msg
        );

        return Response::json($result);
    }

    public function postUpdateinventory(){
        $in = Input::get();

        //$id = $in['upinv_id'];

        //$unitdata = array_merge(array('id'=>$id),$in);

        //$this->updateStock($unitdata);
        $in['id'] = new MongoId($in['id']);

        Commerce::updateStock($in);

        return Response::json(array('result'=>'OK:UPDATED' ));
    }

    public function postInventoryinfo(){
        $pid = Input::get('product_id');

        $p = Product::find($pid);

        foreach( Prefs::getOutlet()->OutletToArray() as $o){

            $av = Stockunit::where('outletId', $o->_id )
                    ->where('productId', new MongoId($pid) )
                    ->where('status','available')
                    ->count();

            $hd = Stockunit::where('outletId', $o->_id)
                    ->where('productId',new MongoId($pid))
                    ->where('status','hold')
                    ->count();

            $rsv = Stockunit::where('outletId', $o->_id)
                    ->where('productId',new MongoId($pid))
                    ->where('status','reserved')
                    ->count();

            $sld = Stockunit::where('outletId', $o->_id)
                    ->where('productId',new MongoId($pid))
                    ->where('status','sold')
                    ->count();

            $avail['stocks'][$o->_id]['available'] = $av;
            $avail['stocks'][$o->_id]['hold'] = $hd;
            $avail['stocks'][$o->_id]['reserved'] = $rsv;
            $avail['stocks'][$o->_id]['sold'] = $sld;
        }

        $html = View::make('partials.stockform')->with('formdata', $avail)->render();

        if($p){
            return Response::json(array('result'=>'OK:FOUND', 'html'=>$html ));
        }else{
            return Response::json(array('result'=>'ERR:NOTFOUND'));
        }


    }


    public function postProductinfo(){
        $pid = Input::get('product_id');

        $p = Product::find($pid);

        if($p){
            return Response::json(array('result'=>'OK:FOUND', 'data'=>$p->toArray() ));
        }else{
            return Response::json(array('result'=>'ERR:NOTFOUND'));
        }
    }

    public function postPrintdefault()
    {
        $in = Input::get();

        $_id = Auth::user()->id;

        $def = Printdefault::where('ownerId',$_id)->where('type',$in['type'])->first();

        if($def){

        }else{
            $def = new Printdefault();
            $def['ownerId'] = Auth::user()->id;
        }

        foreach($in as $k=>$v){
            $def[$k] = $v;
        }

        $def->save();

        return Response::json(array('result'=>'OK'));

    }

    public function postSessionsave($sessionname = null)
    {
        if(is_null($sessionname)){
            $sessionname = 'pr_'.time();
        }
        $in = Input::get('data_array');

        $in['_id'] = $sessionname;

        Printsession::insert($in);
        return Response::json(array('result'=>'OK', 'sessionname'=>$sessionname));
    }


    public function postProductpicture(){
        $data = Input::get();


        $defaults = array();

        $files = array();

        if( isset($data['file_id']) && count($data['file_id'])){

            $data['defaultpic'] = (isset($data['defaultpic']))?$data['defaultpic']:$data['file_id'][0];
            $data['brchead'] = (isset($data['brchead']))?$data['brchead']:$data['file_id'][0];
            $data['brc1'] = (isset($data['brc1']))?$data['brc1']:$data['file_id'][0];
            $data['brc2'] = (isset($data['brc2']))?$data['brc2']:$data['file_id'][0];
            $data['brc3'] = (isset($data['brc3']))?$data['brc3']:$data['file_id'][0];


            for($i = 0 ; $i < count($data['file_id']); $i++ ){


                $files[$data['file_id'][$i]]['thumbnail_url'] = $data['thumbnail_url'][$i];
                $files[$data['file_id'][$i]]['large_url'] = $data['large_url'][$i];
                $files[$data['file_id'][$i]]['medium_url'] = $data['medium_url'][$i];
                $files[$data['file_id'][$i]]['full_url'] = $data['full_url'][$i];

                $files[$data['file_id'][$i]]['delete_type'] = $data['delete_type'][$i];
                $files[$data['file_id'][$i]]['delete_url'] = $data['delete_url'][$i];
                $files[$data['file_id'][$i]]['filename'] = $data['filename'][$i];
                $files[$data['file_id'][$i]]['filesize'] = $data['filesize'][$i];
                $files[$data['file_id'][$i]]['temp_dir'] = $data['temp_dir'][$i];
                $files[$data['file_id'][$i]]['filetype'] = $data['filetype'][$i];
                $files[$data['file_id'][$i]]['fileurl'] = $data['fileurl'][$i];
                $files[$data['file_id'][$i]]['file_id'] = $data['file_id'][$i];
                $files[$data['file_id'][$i]]['caption'] = $data['caption'][$i];

                if($data['defaultpic'] == $data['file_id'][$i]){
                    $defaults['thumbnail_url'] = $data['thumbnail_url'][$i];
                    $defaults['large_url'] = $data['large_url'][$i];
                    $defaults['medium_url'] = $data['medium_url'][$i];
                    $defaults['full_url'] = $data['full_url'][$i];
                }

                if($data['brchead'] == $data['file_id'][$i]){
                    $defaults['brchead'] = $data['large_url'][$i];
                }

                if($data['brc1'] == $data['file_id'][$i]){
                    $defaults['brc1'] = $data['large_url'][$i];
                }

                if($data['brc2'] == $data['file_id'][$i]){
                    $defaults['brc2'] = $data['large_url'][$i];
                }

                if($data['brc3'] == $data['file_id'][$i]){
                    $defaults['brc3'] = $data['large_url'][$i];
                }


            }

        }else{

            $data['thumbnail_url'] = array();
            $data['large_url'] = array();
            $data['medium_url'] = array();
            $data['full_url'] = array();
            $data['delete_type'] = array();
            $data['delete_url'] = array();
            $data['filename'] = array();
            $data['filesize'] = array();
            $data['temp_dir'] = array();
            $data['filetype'] = array();
            $data['fileurl'] = array();
            $data['file_id'] = array();
            $data['caption'] = array();

            $data['defaultpic'] = '';
            $data['brchead'] = '';
            $data['brc1'] = '';
            $data['brc2'] = '';
            $data['brc3'] = '';
        }


        $data['defaultpictures'] = $defaults;
        $data['files'] = $files;

        $p = Product::find($data['upload_id']);

        $p->thumbnail_url =  $data['thumbnail_url'];
        $p->large_url =  $data['large_url'];
        $p->medium_url =  $data['medium_url'];
        $p->full_url =  $data['full_url'];
        $p->delete_type =  $data['delete_type'];
        $p->delete_url =  $data['delete_url'];
        $p->filename =  $data['filename'];
        $p->filesize =  $data['filesize'];
        $p->temp_dir =  $data['temp_dir'];
        $p->filetype =  $data['filetype'];
        $p->fileurl =  $data['fileurl'];
        $p->file_id =  $data['file_id'];
        $p->caption =  $data['caption'];
        $p->defaultpic =  $data['defaultpic'];
        $p->brchead =  $data['brchead'];
        $p->brc1 =  $data['brc1'];
        $p->brc2 =  $data['brc2'];
        $p->brc3 =  $data['brc3'];
        $p->defaultpictures =  $data['defaultpictures'];
        $p->files =  $data['files'];

        if($p->save()){
            return Response::json(array('result'=>'OK:UPLOADED' ));
        }else{
            return Response::json(array('result'=>'ERR:UPDATEFAILED' ));
        }

    }

    public function postAssignstatus(){
        $in = Input::get();

        $status = $in['status'];

        $product_ids = $in['product_ids'];

        foreach($product_ids as $p){
            $prop = Product::find($p);
            $prop->status = $status;
            $prop->save();
        }

        return Response::json(array('result'=>'OK'));

    }

    public function postApproval(){
        $in = Input::get();

        $ticket_id = $in['ticket_id'];
        $approval_status = $in['approval_status'];

        $approval = Approval::find($ticket_id);
        if($approval){
            $approval->approvalStatus = $approval_status;
            $approval->save();

            $p = json_encode($approval);
            $actor = (isset(Auth::user()->email))?Auth::user()->fullname.' - '.Auth::user()->email:'guest';

            Event::fire('log.a',array('approval','change',$actor,$p));

            return Response::json(array('result'=>'OK'));
        }else{

            $p = 'asset not found';
            $actor = (isset(Auth::user()->email))?Auth::user()->email:'guest';

            Event::fire('log.a',array('approval','change',$actor,$p));

            return Response::json(array('result'=>'ERR::NOTFOUND'));
        }


    }


    public function postAssigncat(){
        $in = Input::get();

        $category = $in['category'];

        $cats = Prefs::getProductCategory()->ProductCatToSelection('slug', 'title', false);

        $product_ids = $in['product_ids'];

        foreach($product_ids as $p){
            $prop = Product::find($p);
            $prop->category = $cats[$category];
            $prop->categoryLink = $category;
            $prop->save();
        }

        return Response::json(array('result'=>'OK'));

    }

    public function postAssignshopcat(){
        $in = Input::get();

        $category = $in['category'];

        $cats = Prefs::getShopCategory()->ShopCatToSelection('slug', 'name', false);

        $product_ids = $in['product_ids'];

        foreach($product_ids as $p){
            $prop = Member::find($p);
            $prop->shopcategory = $cats[$category];
            $prop->shopcategoryLink = $category;
            $prop->save();
        }

        return Response::json(array('result'=>'OK'));

    }

    public function postAssignoutlet(){
        $in = Input::get();

        $category = $in['outlet'];

        $cats = Prefs::getOutlet()->OutletToSelection('name','_id',false);

        //print_r($cats);

        $product_ids = $in['product_ids'];

        foreach($product_ids as $p){
            $prop = Stockunit::find($p);
            $prop->outletId = $cats[$category];
            $prop->outletName = $category;
            $prop->save();
        }

        return Response::json(array('result'=>'OK'));

    }

    public function postUnassign(){
        $in = Input::get();

        $user_id = $in['user_id'];

        $prop_ids = $in['prop_ids'];

        foreach($prop_ids as $p){
            $prop = Property::find($p);

            if($prop){
                $prop->pull('assigned_user',$user_id);
                $prop->save();
            }

        }

        return Response::json(array('result'=>'OK'));

    }


    public function getPlaylist(){
        $mc = LMongo::collection('playlist');

        $video = $mc
            ->orderBy('sequence', 'asc')
            ->get();

        $playlist = array();

        foreach($video as $v){
            $playlist[] = array('file'=>$v['url']);
        }

        return Response::json($playlist);
    }

    public function getPush(){
        $lockfile = realpath('storage/lock').'/push';
        file_put_contents($lockfile, '1');
        return Response::json(array('push'=>1));
    }

    public function getChange(){
        $lockfile = realpath('storage/lock').'/push';

        $change = file_get_contents($lockfile);

        if($change == 1){
            file_put_contents($lockfile, '2');
            return Response::json(array('push'=>1));
        }else{
            return Response::json(array('push'=>0));
        }
    }

    public function getTag()
    {
        $q = Input::get('term');

        $qtag = new MongoRegex('/'.$q.'/i');

        $res = Tag::where('tag',$qtag)->distinct('tag')->get();

        //print_r($res->toArray());

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r[0],'label'=>$r[0],'value'=>$r[0]);
        }

        return Response::json($result);
    }


    public function getProduct()
    {
        $q = Input::get('term');

        $mreg = new MongoRegex('/'.$q.'/i');

        $res = Product::where('SKU', 'regex', $mreg)
                    ->orWhere('itemDescription', 'regex', $mreg)
                    ->orWhere('series', 'regex', $mreg)
                    ->get()->toArray();

                    //print_r($res);

        $result = array();

        foreach($res as $r){
            //print_r($r);

            if(isset($r['defaultpictures']['thumbnail_url'])){
                $display = HTML::image( $r['defaultpictures']['thumbnail_url'].'?'.time(),'thumb', array('id' => $r['_id']));
            }else{
                $display = HTML::image( URL::to('images/no-thumb.jpg').'?'.time(),'thumb', array('id' => $r['_id']));
            }

            $label = $display.' '.$r['SKU'].'-'.$r['itemDescription'];
            $result[] = array('id'=>$r['_id'],'value'=>$r['SKU'],'link'=>$r['SKU'],'pic'=>$display,'description'=>$r['itemDescription'],'label'=>$label);
        }

        return Response::json($result);
    }

    public function getProductplain()
    {
        $q = Input::get('term');

        $user = new Product();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('name'=>$qemail),array('description'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['permalink'],'description'=>$r['description'],'label'=>$r['name']);
        }

        return Response::json($result);
    }

    public function getEmail()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ),array('email','fullname'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['email'],'name'=>$r['fullname'],'label'=>$r['fullname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getMerchant()
    {
        $q = Input::get('term');

        $user = Merchant::where('group_id',4)
                    ->where(function($query) use($q) {
                        $query->where('merchantname','like','%'.$q.'%')
                            ->orWhere('fullname','like','%'.$q.'%');
                    })->get();

        $result = array();

        foreach($user->toArray() as $r){
            $result[] = array('id'=>$r['id'],'value'=>$r['merchantname'],'email'=>$r['email'],'label'=>$r['merchantname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getUser()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ),array('email','fullname'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['fullname'],'email'=>$r['email'],'label'=>$r['fullname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getGroup()
    {
        $q = Input::get('term');

        $user = new Group();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('firstname'=>$qemail),array('lastname'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['groupname'],'email'=>$r['email'],'label'=>$r['groupname'].'<br />'.$r['firstname'].''.$r['lastname'].' ( '.$r['email'].' )<br />'.$r['company']);
        }

        return Response::json($result);
    }

    public function getUserdata()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['fullname'],'email'=>$r['email'],'label'=>$r['fullname'].' ( '.$r['email'].' )','userdata'=>$r);
        }

        return Response::json($result);
    }

    public function getUserdatabyemail()
    {
        $q = Input::get('term');

        $user = LMongo::collection('users');

        $qemail = new MongoRegex('/'.$q.'/i');



        $res = $user->whereRegex('username',$qemail)->orWhereRegex('fullname',$qemail)->get();

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['username'],'email'=>$r['username'],'label'=>$r['fullname'].' ( '.$r['username'].' )','userdata'=>$r);
        }

        return Response::json($result);
    }

    public function getUserdatabyname()
    {
        $q = Input::get('term');

        $user = LMongo::collection('users');

        $qemail = new MongoRegex('/'.$q.'/i');



        $res = $user->whereRegex('username',$qemail)->orWhereRegex('fullname',$qemail)->get();

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['fullname'],'email'=>$r['username'],'label'=>$r['fullname'].' ( '.$r['username'].' )','userdata'=>$r);
        }

        return Response::json($result);
    }

    public function getUseridbyemail()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['_id']->__toString(),'email'=>$r['email'],'label'=>$r['fullname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getRev()
    {
        $q = Input::get('term');

        $doc = new Document();
        $qdoc = new MongoRegex('/'.$q.'/i');

        $res = $doc->find(array('title'=>$qdoc),array('title'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['title'],'value'=>$r['_id']->__toString());
        }

        return Response::json($result);
    }

    public function getProject()
    {
        $q = Input::get('term');

        $proj = new Project();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('projectNumber'=>$qproj)) ),array('title','projectNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['projectNumber'].' - '.$r['title'],'title'=>$r['title'],'value'=>$r['projectNumber']);
        }

        return Response::json($result);
    }

    public function getProjectname()
    {
        $q = Input::get('term');

        $proj = new Project();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('projectNumber'=>$qproj)) ),array('title','projectNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['projectNumber'].' - '.$r['title'],'number'=>$r['projectNumber'],'value'=>$r['title']);
        }

        return Response::json($result);
    }


    public function getTender()
    {
        $q = Input::get('term');

        $proj = new Tender();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('tenderNumber'=>$qproj)) ),array('title','tenderNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['tenderNumber'].' - '.$r['title'],'title'=>$r['title'],'value'=>$r['tenderNumber']);
        }

        return Response::json($result);
    }

    public function getTendername()
    {
        $q = Input::get('term');

        $proj = new Tender();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('tenderNumber'=>$qproj)) ),array('title','tenderNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['tenderNumber'].' - '.$r['title'],'number'=>$r['tenderNumber'],'value'=>$r['title']);
        }

        return Response::json($result);
    }

    public function getOpportunity()
    {
        $q = Input::get('term');

        $proj = new Opportunity();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('opportunityNumber'=>$qproj)) ),array('title','opportunityNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['opportunityNumber'].' - '.$r['title'],'title'=>$r['title'],'value'=>$r['opportunityNumber']);
        }

        return Response::json($result);
    }

    public function getOpportunityname()
    {
        $q = Input::get('term');

        $proj = new Opportunity();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('opportunityNumber'=>$qproj)) ),array('title','opportunityNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['opportunityNumber'].' - '.$r['title'],'number'=>$r['opportunityNumber'],'value'=>$r['title']);
        }

        return Response::json($result);
    }

    public function getMeta()
    {
        $q = Input::get('term');

        $doc = new Document();
        $id = new MongoId($q);

        $res = $doc->get(array('_id'=>$id));

        return Response::json($result);
    }

    public function postParam()
    {
        $in = Input::get();

        $key = $in['key'];
        $value = $in['value'];

        if(setparam($key,$value)){
            return Response::json(array('result'=>'OK'));
        }else{
            return Response::json(array('result'=>'ERR'));
        }

    }

    public function fromCamelCase($camelCaseString) {
            $re = '/(?<=[a-z])(?=[A-Z])/x';
            $a = preg_split($re, $camelCaseString);
            return join($a, " " );
    }

}

