<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherStationController extends Controller
{

    // auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // show pressure
    public function pressure()
    {
        return view('pressure');
    }

    // get pressure json
    public function getPressure()
    {
        $tableName = 'IoTData';
        $params = [
            'TableName' => $tableName,
            'Limit' => 10000,            
        ];

        $db = \App::make('aws')->createClient('dynamodb');
        $result = $db->scan($params);
        $items = $this->processData($result['Items'], 'pressure');
        return response()->json(['code' => 1, 'data' => $items]);
    }

    // show humidity
    public function humidity()
    {
        return view('humidity');
    }

    // get humidity json
    public function getHumidity()
    {
        $tableName = 'IoTData';
        $params = [
            'TableName' => $tableName,
            'Limit' => 10000,            
        ];

        $db = \App::make('aws')->createClient('dynamodb');
        $result = $db->scan($params);
        $items = $this->processData($result['Items'], 'humidity');
        return response()->json(['code' => 1, 'data' => $items]);
    }

    // show temperature
    public function temperature()
    {
        return view('temperature');
    }

    // get temperature json
    public function getTemperature()
    {
        $tableName = 'IoTData';
        $params = [
            'TableName' => $tableName,
            'Limit' => 10000,            
        ];

        $db = \App::make('aws')->createClient('dynamodb');
        $result = $db->scan($params);
        $items = $this->processData($result['Items'], 'temperature');
        return response()->json(['code' => 1, 'data' => $items]);
    }

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
        return $return;
    }

}
