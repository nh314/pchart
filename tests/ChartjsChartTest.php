<?php

include "../src/ChartBase.php";
include "../src/ChartjsChart.php";

use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function testSingleDataSource()
    {
        $string = file_get_contents("chartjstestdata01.txt");

        $dataSources = [json_decode($string)];
        
        $chart = new ChartjsChart($dataSources);
        
        $sourceSetCount = count($dataSources);

        $chartSourceSetCount = count( $chart->dataSource );

        $this->assertEquals( $sourceSetCount, $chartSourceSetCount, 'Number of dataset is '.count($dataSources));

        $chart->createData(['Age'], 'age');

        $this->assertEquals( count($chart->config['data']['datasets'][0]['data']), 10, "Numer of record is 10.");

        $string = file_get_contents("chartjstestdata01.txt");

    }
    
}
?>