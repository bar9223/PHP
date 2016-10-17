<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dictionary
 *
 * @author Damian Szkudlarek
 */
class Dictionary {
    //put your code here
    
    private $pl;
    private $en;
    private $de;
    private $noPl;
    private $dictionary;

    public function __construct() {
        
        $this->readFile();
        
        if($this->validateInputs()) {
            $this->createNoPl();
            
            if(!$this->checkIfWordExists()){
                $this->saveWordsToDictionary();
            }
        } else {
            $this->displayError();
        }
    }
    
    public function getDictionary()
    {
        return $this->dictionary;
    }

    public function validateInputs()
    {
        if (!empty($_POST['pl']) and
                !empty($_POST['en']) and
                !empty($_POST['de'])) {
            $this->pl = $_POST['pl'];
            $this->en = $_POST['en'];
            $this->de = $_POST['de'];
            return true;
        }
        
        return false;
    }
    
    public function createNoPl()
    {
        $this->noPl = $this->toPermalink($this->pl);
    }
    
    public function readFile()
    {
        $this->dictionary = json_decode(
                file_get_contents('dictionary.json'),
                true
                );
    }
    
    public function saveWordsToDictionary()
    {

        $this->dictionary[$this->noPl] = [
            'pl' => $this->pl,
            'en' => $this->en,
            'de' => $this->de
        ];
        
        ksort($this->dictionary);
        
        file_put_contents('dictionary.json', json_encode($this->dictionary));
        
        
    }
    
    public function checkIfWordExists()
    {
        return array_key_exists($this->noPl, $this->dictionary);
    }
    
    public function displayError()
    {
        echo 'Uzupełnij wszystkie inputy';
    }
    
    public  function toPermalink($string, $word_separator = '-') {
        $unPretty = array('/ä/', '/ö/', '/ü/', '/Ä/', '/Ö/', '/Ü/', '/ß/',
            '/ą/', '/Ą/', '/ć/', '/Ć/', '/ę/', '/Ę/', '/ł/', '/Ł/' ,'/ń/', '/Ń/', '/ó/', '/Ó/', '/ś/', '/Ś/', '/ź/', '/Ź/', '/ż/', '/Ż/',
            '/Š/','/Ž/','/š/','/ž/','/Ÿ/','/Ŕ/','/Á/','/Â/','/Ă/','/Ä/','/Ĺ/','/Ç/','/Č/','/É/','/Ę/','/Ë/','/Ě/','/Í/','/Î/','/Ď/','/Ń/',
            '/Ň/','/Ó/','/Ô/','/Ő/','/Ö/','/Ř/','/Ů/','/Ú/','/Ű/','/Ü/','/Ý/','/ŕ/','/á/','/â/','/ă/','/ä/','/ĺ/','/ç/','/č/','/é/','/ę/',
            '/ë/','/ě/','/í/','/î/','/ď/','/ń/','/ň/','/ó/','/ô/','/ő/','/ö/','/ř/','/ů/','/ú/','/ű/','/ü/','/ý/','/˙/',
            '/Ţ/','/ţ/','/Đ/','/đ/','/ß/','/Œ/','/œ/','/Ć/','/ć/','/ľ/');

        $pretty   = array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss',
            'a', 'A', 'c', 'C', 'e', 'E', 'l', 'L', 'n', 'N', 'o', 'O', 's', 'S', 'z', 'Z', 'z', 'Z',
            'S','Z','s','z','Y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N',
            'O','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e',
            'e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y',
            'TH','th','DH','dh','ss','OE','oe','AE','ae','u');

        $permalink = mb_strtolower(preg_replace($unPretty, $pretty, $string), 'UTF-8');

        $ru = array ( /* Russian */
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya'
        );

        $permalink = preg_replace('/\s+/', ' ', preg_replace("/[^a-zA-Z0-9 ]/", "", str_replace(array_keys($ru), array_values($ru), $permalink)));
        return str_replace(" ", $word_separator, $permalink) ;
    }
    
}
