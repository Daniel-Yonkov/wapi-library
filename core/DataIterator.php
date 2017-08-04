<?php
namespace wapi\core;

/**
 * Iterators
 */
class DataIterator
{
    protected $data = null;
    /**
     * Iterate trought data array returning key-value pairs
     */
    public function __construct($data)
    {
        $this->iteration($data);
    }


    protected function iteration($data){
        $counter=0;
        $fields='';
        $values='';

        foreach ($data as $k => $v) {
            if($counter == 0){
                $fields.= $k;
                $values.='"'.$v.'"';
                $counter++;
                continue;   
            }
            $fields.= ', '.$k;
            $values.= ', '.'"'.$v.'"';
        }
        $this->data =array($fields,$values);
    }

    public function getData(){
        return $this->data;
    }
}