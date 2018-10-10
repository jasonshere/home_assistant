<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherStationController extends Controller
{

    /**
     *  set auth
     * 
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  show pressure chart
     * 
     *  render page
     * 
     */
    public function pressure()
    {
        return view('pressure');
    }

    /**
     *  return pressure json for AJAX
     * 
     *  render json
     * 
     */
    public function getPressure()
    {
        $tableName = 'IoTData';
        $params = [
            'TableName' => $tableName,
            'Limit' => 200,
            'KeyConditionExpression' => 'device_id = :d',
            'ExpressionAttributeValues' => [
                ':d' => ['S' => 'Melbourne-RMIT']
            ],
            'ScanIndexForward' => false       
        ];

        $db = \App::make('aws')->createClient('dynamodb');
        $result = $db->query($params);
        $items = $this->processData($result['Items'], 'pressure');
        return response()->json(['code' => 1, 'data' => $items]);
    }

    /**
     *  show humidity chart
     * 
     *  render page
     * 
     */
    public function humidity()
    {
        return view('humidity');
    }

    /**
     *  return humidity json for AJAX
     * 
     *  render json
     * 
     */
    public function getHumidity()
    {
        $tableName = 'IoTData';
        $params = [
            'TableName' => $tableName,
            'Limit' => 200,
            'KeyConditionExpression' => 'device_id = :d',
            'ExpressionAttributeValues' => [
                ':d' => ['S' => 'Melbourne-RMIT']
            ],
            'ScanIndexForward' => false       
        ];

        $db = \App::make('aws')->createClient('dynamodb');
        $result = $db->query($params);
        $items = $this->processData($result['Items'], 'humidity');
        return response()->json(['code' => 1, 'data' => $items]);
    }

    /**
     *  show temperature chart
     * 
     *  render page
     * 
     */
    public function temperature()
    {
        return view('temperature');
    }

    /**
     *  return temperature json for AJAX
     * 
     *  render json
     * 
     */
    public function getTemperature()
    {
        $tableName = 'IoTData';
        $params = [
            'TableName' => $tableName,
            'Limit' => 200,
            'KeyConditionExpression' => 'device_id = :d',
            'ExpressionAttributeValues' => [
                ':d' => ['S' => 'Melbourne-RMIT']
            ],
            'ScanIndexForward' => false       
        ];

        $db = \App::make('aws')->createClient('dynamodb');
        $result = $db->query($params);
        $items = $this->processData($result['Items'], 'temperature');
        return response()->json(['code' => 1, 'data' => $items]);
    }

    /**
     *  process data
     * 
     *  return array
     * 
     */
    protected function processData($items, $type)
    {
        $labels = [];
        $data = [];
        $return = [];
        foreach($items as $item) {
            // $labels
            if (!array_key_exists($item['device_id']['S'], $return)) {
                $return[$item['device_id']['S']] = [];
            }
            $return[$item['device_id']['S']]['labels'][] = date("Y-m-d H:i:s", $item['timestamp']['N']);
            $return[$item['device_id']['S']]['data'][] = $item['data']['M']['sensor_data']['M'][$type]['N'];
        }
        $return['Melbourne-RMIT']['labels'] = array_reverse($return['Melbourne-RMIT']['labels']);
        $return['Melbourne-RMIT']['data'] = array_reverse($return['Melbourne-RMIT']['data']);
        return $return;
    }

    /**
     *  my calendar
     * 
     *  return page
     */
    public function calendar()
    {
        return view('calendar');
    }

    /**
     *  show intruders
     * 
     *  render page
     */
    public function intruder()
    {
        $baseUrl = 'https://s3.amazonaws.com/intruders/';
        $s3 = \App::make('aws')->createClient('s3');
        $result = $s3->getIterator('ListObjectsV2', [
            'Bucket' => 'intruders', // REQUIRED
            'EncodingType' => 'url',
            'Prefix' => 'faces',
        ]);
        $data = [];
        // dd($result);
        foreach($result as $key => $file) {
            if ($key == 0) continue;
            $data[] = ['url' => $baseUrl. $file['Key'], 'datetime' => $file['LastModified']->__toString()];
        }
        return view('intruder', ['pics' => $data]);
    }

}
