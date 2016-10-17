<?php
class CountryInfo {
    private $url = 'https://restcountries.eu/rest/v1/name/';
    private $data;
    
    public function __construct($countryName) {
        $this->data = json_decode(
                file_get_contents($this->url . $countryName . '?fullText=true')
                );
    }
    
    public function getName()
    {
        return $this->data[0]->name;
    }
    
    public function getRegion()
    {
        return $this->data[0]->region;
    }
    
    public function getSubregion()
    {
        return $this->data[0]->subregion;
    }
    
    public function getPopulation()
    {
        return $this->data[0]->population;
    }
}
