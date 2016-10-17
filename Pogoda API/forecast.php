<?php
    require_once 'Api.php';
    
    $weather = new Api($_GET['city']);
    $data = $weather->getForecast();
?>

<html>
    <head>
        <title>Prognoza pogody</title>
    </head
    <body>
        <a href="index.php?cityFavourite=<?php echo $_GET['city']; ?>">DODAJ DO ULUBIONYCH</a>
        <?php foreach ($data["days"] as $date => $forecast) { ?>
            <section>
                Data: <?php echo $date; ?><br/>
                Temeratura: <?php echo $forecast['temp']; ?><br/>
                Ciśnienie: <?php echo $forecast['pressure']; ?><br/>
                Wilgotność: <br/>

            </section>
        <?php } ?>
        Średnia temperatura: <?php echo $data['avg']['temp']; ?><br/>
        Średnia ciśnienie: <?php echo $data['avg']['pressure']; ?><br/>
    </body>
</html>