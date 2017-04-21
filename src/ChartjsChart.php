<?php
/**
*  
*/
class ChartjsChart extends ChartBase
{
    public $type;
    public function __construct($arrayOfData = [], $type="line", $config = [])
    {
        $this->config['type'] = $this->type = $type;
        $this->config['data'] = ['datasets'=>[]];
        parent::__construct($arrayOfData, $config);
        
    }
    
    public function createData()
    {
        
        $arg_list = func_get_args();

        $functionName = 'create'.ucfirst($this->type).'ChartData';

        $data = [];

        if( method_exists($this, $functionName) )
        {
            $data = call_user_func_array(array($this, $functionName), $arg_list);

        }else{

            $data = call_user_func_array(array($this, 'createChartData'), $arg_list);
        }

        return $data;
    }
    
    /**
     * Get field from data source;
     */
    public function getField($field) {
        if(is_array($this->dataSource)) {
            array_walk( $this->dataSource, function ($dataSet, $key) use (&$data, $field) {
                foreach ($dataSet as $row) {                    
                    $row = (object) $row;
                    if( isset($row->$field) ) {
                        $data[$key][] = $row->$field;
                    }else{
                         $data[$key][] = 0;
                    }
                }
            } );

        }

        return $data;
    }

    public function getFields($fields) {
        $data = [];
       
        if(is_array($this->dataSource) && is_array($fields)) {

            array_walk( $this->dataSource, function ($dataSet, $key) use (&$data, $fields) {
                foreach ($dataSet as $row_key => $row) {
                    $row = (object) $row;
                    foreach ($fields as $key_field => $field) {
                        if( isset($row->$field) ) {
                            $data[$key][$row_key][$key_field] = $row->$field;
                        }
                    }
                    
                }
            } );

        }

        return $data;
    }

    public function createChartData($labels, $field)
    {
        $dataSets = $this->getField($field);
        $data = [];
        foreach ($dataSets as $key => $dataSet) {
            $data[$key]['data'] = $dataSet;
            $data[$key]['label'] = isset($labels[$key]) ? $labels[$key] : '';
        }

        $this->config['data']['datasets'] = array_replace_recursive($this->config['data']['datasets'], $data);
    }

    public function createBubbleChartData($labels, $x, $y, $size)
    {
        $dataSetData = [];
        $dataSets = $this->getFields(['x' => $x, 'y' => $y, 'r' => $size]);
        
        $data = [];
        
        foreach ($dataSets as $key => $dataSet) {
            $data[$key]['data'] = $dataSet;
            $data[$key]['label'] = $labels[$key];
        }

        $this->config['data']['datasets'] = array_replace_recursive($this->config['data']['datasets'], $data);

    }




}