<?php

class AllCountries {
    
    private $url = 'https://restcountries.eu/rest/v1/all';
    private $data;
    
    public function __construct() {
        $this->data = json_decode(file_get_contents($this->url));
    }
    
    public function getAllCountries()
    {
        $tmpArray = [];
        foreach ($this->data as $country) {
            $tmpArray[] = $country->name;
        }
        
        return $tmpArray;
    }
    
    public function getAllRegions()
    {
        $tmpArray = [];
        foreach ($this->data as $country) {
            if (!in_array($country->region, $tmpArray)) {
                $tmpArray[] = $country->region;
            }
        }
        
        return $tmpArray;
    }
    
    public function getCountriesByRegion($region)
    {
        $tmpArray = [];
        foreach ($this->data as $country) {
            if (strtolower($region) === strtolower($country->region)) {
                $tmpArray[] = $country->name;
            }
        }
        
        return $tmpArray;
    }
}

$testObj = new AllCountries();
var_dump($testObj->getCountriesByRegion('euRope'));