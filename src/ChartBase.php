<?php
/**
*  
*/
abstract class ChartBase
{
    protected $dataSource;
    public $config = [];
    public function __construct($arrayOfData = [], $config = [])
    {
       if(!empty($arrayOfData)) {
        $this->dataSource = array_filter($arrayOfData);
       }
        
        $this->options = array_replace_recursive($this->config, $config);
       
    }

    public function addDataSource($arrayOfData)
    {
        if(is_array($arrayOfData) && !empty($arrayOfData)){
            $this->dataSource = $arrayOfData;
        }
        
    }

    public function addSingleDataSource($singleDataSource) {
        if(is_array($arrayOfData) && !empty($arrayOfData)) {
            $this->dataSource[] = $arrayOfData;
        }
    }

    public function getDataSource() {
        return $this->dataSource;
    }

    public function buildConfig($format = 'json')
    {
        switch ($format) {
            case 'json':
                return json_encode($this->config);
            break;
            
        }
    }

    abstract public function createData();
    
}