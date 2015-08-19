<?php
class HtmlTable {

    protected $table = null;
    protected $header = null;
    protected $attr = null;
    protected $data = null;

    public function __construct($data = null, $attr = null, $header = null)
    {
        if(is_null($data)) return;
        $this->data = $data;
        $this->attr = $attr;
        if(is_array($header)) {
            $this->header = $header;
        }
        else {
            if(count($this->data) && $this->is_assoc($this->data[0]) || is_object($this->data[0])) {
                $headerKeys = is_object($this->data[0]) ? array_keys((array)$this->data[0]) : array_keys($this->data[0]);
                $this->header = array();
                foreach ($headerKeys as $value) {
                    $this->header[] = $value;
                }
            }
        }
        return $this;
    }

    public function build()
    {
        $atts = '';
        if(!is_null($this->attr)) {
            foreach ($this->attr as $key => $value) {
                $atts .= $key . ' = "' . $value . '" ';
            }
        }
        $table = '<table ' . $atts . ' >';

        if(!is_null($this->header)) {


            $table .= '<thead>';
            foreach ($this->header as $value) {
                $table .= $this->createHeadRow($value);
            }
            $table .= '</thead>';
            /*
            $table .= '<thead><tr>';
            foreach ($this->header as $value) {
                if(is_array($value)){
                    $table .= '<th '.$value['attr'].'>' . $value['value'] . '</th>';
                }else{
                    $table .= '<th>' . $value . '</th>';
                }
            }
            $table .= '</thead></tr>';
            */
        }

        $table .= '<tbody>';
        foreach ($this->data as $value) {
            $table .= $this->createRow($value);
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $this->table = $table;
    }

    protected function createRow($array = null)
    {
        if(is_null($array)) return false;
            $row = '<tr>';
            foreach ($array as $value) {
                if(is_array($value)){
                    if(isset($value['attr'])){
                        $row .= '<td '.$value['attr'].'>' . $value['value'] . '</td>';
                    }else{
                        $row .= '<td>' . $value['value'] . '</td>';
                    }
                }else{
                    $row .= '<td>' . $value . '</td>';
                }
            }
            $row .= '</tr>';
            return $row;
    }

    protected function createHeadRow($array = null)
    {
        if(is_null($array)) return false;
            $row = '<tr>';
            foreach ($array as $value) {
                if(is_array($value)){
                    if(isset($value['attr'])){
                        $row .= '<th '.$value['attr'].'>' . $value['value'] . '</th>';
                    }else{
                        $row .= '<th>' . $value['value'] . '</th>';
                    }
                }else{
                    $row .= '<th>' . $value . '</th>';
                }
            }
            $row .= '</tr>';
            return $row;
    }

    protected function is_assoc($array){
        return is_array($array) && array_diff_key($array, array_keys(array_keys($array)));
    }
}