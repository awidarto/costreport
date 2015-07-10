<?php

class CompanyController extends AdminController {

    public function __construct()
    {
        parent::__construct();

        $this->controller_name = str_replace('Controller', '', get_class());

        //$this->crumb = new Breadcrumb();
        //$this->crumb->append('Home','left',true);
        //$this->crumb->append(strtolower($this->controller_name));

        $this->model = new Company();
        //$this->model = DB::collection('documents');
        $this->title = $this->controller_name;

        Breadcrumbs::addCrumb('HRMS Parameters',URL::to( strtolower($this->controller_name) ));

    }

    public function getTest()
    {
        $raw = $this->model->where('docFormat','like','picture')->get();

        print $raw->toJSON();
    }


    public function getIndex()
    {

        $this->heads = array(
            array('Company Name',array('search'=>true,'sort'=>true)),
            array('Company Code',array('search'=>true,'sort'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'daterange'=>true)),
        );

        $this->place_action = 'none';
        $this->show_select = false;
        $this->can_add = false;

        //print $this->model->where('docFormat','picture')->get()->toJSON();
        //$this->title = 'Companies';
        //Breadcrumbs::addCrumb('HRMS Parameters',URL::to( strtolower($this->controller_name) ));

        return parent::getIndex();

    }

    public function postIndex()
    {

        $this->fields = array(
            array('DESCR',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('DB_CODE',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('LAST_CHANGE_DATETIME',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
        );

        $this->def_order_by = 'LAST_CHANGE_DATETIME';
        $this->def_order_dir = 'ASC';
        $this->place_action = 'none';
        $this->show_select = false;

        $this->sql_key = 'DB_CODE';
        $this->sql_table_name = 'db_defn';
        $this->sql_connection = 'mysql3';

        return parent::postSQLIndex();
    }

    public function postAdd($data = null)
    {

        $this->validator = array(
            'companyName' => 'required',
            'companyCode' => 'required',
            'slug'=> 'required'
        );

        return parent::postAdd($data);
    }

    public function postEdit($id,$data = null)
    {
        $this->validator = array(
            'companyName' => 'required',
            'companyCode' => 'required',
            'slug'=> 'required'
        );

        return parent::postEdit($id,$data);
    }

    public function makeActions($data)
    {
        $delete = '<span class="del" id="'.$data['DB_CODE'].'" ><i class="fa fa-trash"></i>Delete</span>';
        $edit = '<a href="'.URL::to('company/edit/'.$data['DB_CODE']).'"><i class="fa fa-edit"></i>Update</a>';

        $actions = $edit.'<br />'.$delete;
        return $actions;
    }

    public function splitTag($data){
        $tags = explode(',',$data['docTag']);
        if(is_array($tags) && count($tags) > 0 && $data['docTag'] != ''){
            $ts = array();
            foreach($tags as $t){
                $ts[] = '<span class="tag">'.$t.'</span>';
            }

            return implode('', $ts);
        }else{
            return $data['docTag'];
        }
    }

    public function splitShare($data){
        $tags = explode(',',$data['docShare']);
        if(is_array($tags) && count($tags) > 0 && $data['docShare'] != ''){
            $ts = array();
            foreach($tags as $t){
                $ts[] = '<span class="tag">'.$t.'</span>';
            }

            return implode('', $ts);
        }else{
            return $data['docShare'];
        }
    }

    public function namePic($data)
    {
        $name = HTML::link('products/view/'.$data['DB_CODE'],$data['productName']);
        if(isset($data['thumbnail_url']) && count($data['thumbnail_url'])){
            $display = HTML::image($data['thumbnail_url'][0].'?'.time(), $data['filename'][0], array('id' => $data['DB_CODE']));
            return $display.'<br />'.$name;
        }else{
            return $name;
        }
    }

    public function pics($data)
    {
        $name = HTML::link('products/view/'.$data['DB_CODE'],$data['productName']);
        if(isset($data['thumbnail_url']) && count($data['thumbnail_url'])){
            $display = HTML::image($data['thumbnail_url'][0].'?'.time(), $data['filename'][0], array('style'=>'min-width:100px;','id' => $data['DB_CODE']));
            return $display.'<br /><span class="img-more" id="'.$data['DB_CODE'].'">more images</span>';
        }else{
            return $name;
        }
    }

    public function getViewpics($id)
    {

    }


}
