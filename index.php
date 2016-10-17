<?php
require_once 'Countries.php';
require_once 'AllCountries.php';

$countries = new AllCountries();
$allRegions = $countries->getAllRegions();

?>

<html>
    <body>
        <?php
            foreach ($allRegions as $region) {
        ?>
            <div>
                <h2>REGION: <?php echo $region;?></h2>
                <?php
                    $allCountries = $countries->getCountriesByRegion($region);
                    foreach ($allCountries as $country) {
                        echo $country . '<br/>';
                    }
                ?>
            </div>
        <?php
            }
        ?>
    </body>
</html>