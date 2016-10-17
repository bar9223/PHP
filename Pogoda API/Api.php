<?php

/**
 * Description of Api
 *
 * @author diabelek
 */
class Api {
    private $currentWeather;
    private $weatherForecast;
    private $url = 'http://api.openweathermap.org/data/2.5/';
    private $apiId = '623ab05272f04dfb30f338568094b48b';
        
    public function __construct($city)
    {
        $this->currentWeather = json_decode(
                file_get_contents($this->createUrl($city, 'weather')),
                true
            );

        $this->weatherForecast = json_decode(
                file_get_contents($this->createUrl($city, 'forecast')),
                true
            );
    }
    
    public function getWeather()
    {
        return $this->currentWeather["weather"][0]["main"];
    }
    
    public function getCurrentWeather()
    {
        return [
            'name' => $this->currentWeather["name"],
            'temp' => $this->currentWeather["main"]["temp"],
            'pressure' => $this->currentWeather["main"]["pressure"],
            'humidity' => $this->currentWeather["main"]["humidity"]
        ];
    }
    
    public function getForecast()
    {
        $tmp = [];
        $avg = 0;
        $avgP = 0;
        
        foreach($this->weatherForecast['list'] as $val) {
//            $tmpArray = [];
//            $tmpArray['temp'] = $val['main']['temp'];
//            $tmpArray['pressure'] = $val['main']['pressure'];
                    
            $tmpArray = [
                'temp' => $val['main']['temp'],
                'pressure' => $val['main']['pressure']
            ];
            
            $tmp[date('d.m.Y H:i', $val['dt'])] = $tmpArray;
            $avg += $val['main']['temp'];
            $avgP += $val['main']['pressure'];
        }
        
        $avg = $avg / count($this->weatherForecast['list']);
        $avgP = $avgP / count($this->weatherForecast['list']);

        //$tmp['avg'] = $avg;
        $return = [];
        $return['days'] = $tmp;
        
        $tmpArray = [
                'temp' => $avg,
                'pressure' => $avgP
            ];
        
        $return['avg'] = $tmpArray;
        
        return $return;
    }
    
    private function createUrl($city, $type)
    {
        return $this->url . $type .'?q=' . $city . '&units=metric&appid=' . $this->apiId;
    }
}
//
//$myApi = new Api('Poznan');
//var_dump($myApi->getForecast());
//
//echo date('d.m.Y H:i', 1471888800);