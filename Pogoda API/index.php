<?php
    require_once 'Api.php';
    
    $cities = [
        'Poznan',
        'Warszawa',
        'Berlin',
        'New York',
        'London',
        'Chicago',
    ];
  // pobieram ciastko 
    if (isset($_COOKIE['citiesToHide'])) {
        $citiesToHide = json_decode($_COOKIE['citiesToHide'], true);
    } else {
        $citiesToHide = [];
    }  
   // usuń te co zostały schowane
    if (isset($_GET['unhide']) && in_array($_GET['unhide'], $citiesToHide)) {
        foreach ($citiesToHide as $key => $value ){ 
            if ($_GET['unhide'] === $value){
                unset($citiesToHide[$key]);
                break;
            }
        }
    }  
    // dodaje do tablicy
    if (isset($_GET['city']) && !in_array($_GET['city'], $citiesToHide)) {
        $citiesToHide[] = $_GET['city'];
    } 
    
    // zapisuje ciacho   
    if (count($citiesToHide)) {
        setcookie('citiesToHide', json_encode($citiesToHide));
    }
    // dodaj do ulubionych
    // pobieram ciastko
    if (isset($_COOKIE['favouriteCities'])) {
        $favouriteCities = json_decode($_COOKIE['favouriteCities']);
    } else {
        $favouriteCities = [];
    }  
    
    //dodaje do tablicy ulubione miasto
    if (isset($_GET['cityFavourite']) 
            && !in_array($_GET['cityFavourite'], $favouriteCities)) {
        $favouriteCities[] = $_GET['cityFavourite'];
    }  
    // zapsuje ciastko z ulubionymi miastami
    if (count($favouriteCities)) {
        setcookie('favouriteCities', json_encode($favouriteCities));
    };
    // łączę listę miast z tymi dodanymi do ulubionych
    $cities = array_merge($favouriteCities, $cities);
?>

<html>
    <head>
        <title>Strona glowna</title>
    </head>
    <body>
        //patended search method by the JSPHP1POZ
        <form action="forecast.php">
            <input type="text" name="city"/>
            <input type="submit" value="szukaj"/>
        </form>
        <?php foreach ($cities as $city) { 
            if (!in_array($city, $citiesToHide)) {
        ?>
            <section>
                <?php
                    $api = new Api($city);
                    $data = $api->getCurrentWeather();
                ?>
                Miasto: <?php echo $data["name"]; ?><br/>
                Temeratura: <?php echo $data["temp"]; ?><br/>
                Ciśnienie: <?php echo $data["pressure"]; ?><br/>
                Wilgotność: <?php echo $data["humidity"]; ?><br/>
                <a href="forecast.php?city=<?php echo $data["name"]; ?>">Prognoza pogody</a>
                <a href="index.php?city=<?php echo $city; ?>">UKRYJ</a>
            </section>
        <?php } else{ ?>
        <br/>
        Miasto: <?php echo $city; ?><br/>
        <a href="index.php?unhide=<?php echo $city; ?>">POMYLIŁEM SIE, POKAZ RAZ JESZCZE</a>
        <?php
            
        }          
            } ?>
        
    </body>
</html>