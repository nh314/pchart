<?php

include dirname(__FILE__)."/../src/ChartBase.php";
include dirname(__FILE__)."/../src/ChartjsChart.php";

use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    
    private function loadDataFile()
    {
        $dataFile = array_diff(scandir('test_data'), array('..', '.'));
        $dataSource = [];
        foreach ($dataFile as $key => $file) {
            $string = file_get_contents(dirname(__FILE__).'/test_data/'.$file);
            $dataSource[$key] = json_decode($string);
        }
        $dataSources = array_values(array_filter($dataSource));

        return $dataSources;
    }

    public function testSingleDataSource()
    {
        
        $dataSources = $this->loadDataFile();

        foreach ($dataSources as $dataSource) {
            if( !isset($dataSource->data) || !isset($dataSource->type) || !isset($dataSource->params) ) {
                continue;
            }
            
            $chart = new ChartjsChart($dataSource->data, $dataSource->type);
            
            $sourceSetCount = count($dataSource->data);
            
            $chartSourceSetCount = count( $chart->getDataSource() );
            
            $this->assertEquals( $sourceSetCount, $chartSourceSetCount, 'Test number of datasets.');

            call_user_func_array(array($chart, 'createData'), $dataSource->params);
            
            $this->assertEquals(count($dataSource->data[0]), count($chart->config['data']['datasets'][0]['data']), "Test number of records." );

        }

    }
    
}
?>