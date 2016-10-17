<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Dictionary.php';

$dictionary = new Dictionary();
$newDictionary = $dictionary->getDictionary();
       
        
?>

<form action="" method="POST">
    <input type="text" name="pl" placeholder="PL"/>
    <input type="text" name="en" placeholder="EN"/>
    <input type="text" name="de" placeholder="DE"/>
    <button>Zapisz</button>
</form>

<table>
    <thead>
        <tr>
            <th>PL</th>
            <th>EN</th>
            <th>DE</th>
        </tr>        
    </thead>
    <tbody>
        <?php
        foreach ($newDictionary as $words) 
            {?>
            <tr> 
                <td><?php echo $words['pl'];?></td>
                <td><?php echo $words['en'];?></td>
                <td><?php echo $words['de'];?></td>
            </tr>
            <?php
            }
        ?>
    </tbody>
</table>














<?php