<?php
require_once 'TicTacToe.php';

$ticTacToe = new TicTacToe();
$validationResult = $ticTacToe->inputValidation();

$currentPlayer = $ticTacToe->getCurrentPlayer();
$previousPlayer = $ticTacToe->getPreviousPlayer();

var_dump($_SESSION['score']);
?>





<html>
    <head>

    </head> 
    <body>

        <?php
        if (($validationResult === false or ( $validationResult === 1))
                and ! $ticTacToe->isInputOK()) {
            ?>
            <form method="POST">
                <input type="text" placeholder="X" name="x" value="<?php echo $ticTacToe->getX(); ?>"/>
                <input type="text" placeholder="Y" name="y" value="<?php echo $ticTacToe->getY(); ?>"/>
                <input type="text" placeholder="Znak gracza 1" name="player1" value="<?php echo $ticTacToe->getPlayer1Sign(); ?>"/>
                <input type="text" placeholder="Znak gracza 2" name="player2" value="<?php echo $ticTacToe->getPlayer2Sign(); ?>"/>
                <input type="text" name="number" value="<?php echo $ticTacToe->getNumber(); ?>"/>
                <button>Graj</button>
            </form> <?php
    }
    if ($validationResult === 1) {
        echo 'Wprowadź dane ponownie';
    }

    if (isset($_SESSION['gameBoardParams'])) {
           ?> 
        <table>
            <thead>
                <tr>
                    
                     <th>
                1 GRACZ
                    </th>
                    <th>
                2 GRACZ       
                    </th>
                </tr>
           
            
            </thead>
            <tbody>
                <tr>
            <td>
            <?php echo $_SESSION['score'][1] ?>
            </td>  
            <td>
            <?php echo $_SESSION['score'][2] ?>
            </td>
                </tr>
            </tbody>
        </table>
        <?php
            if ($ticTacToe->isDraw()) {
                ?>
                <h5>
                    Game Over! You loose!
                </h5>
            <?php } 
// var_dump($ticTacToe->getWin());
            if ($ticTacToe->getWinner()) {
                ?>
                <h5>
                    Player <?php echo $previousPlayer; ?> Won!
                </h5>
            <?php } ?>
            <h5>
                Gracz:<?php echo $currentPlayer; ?>

            </h5>
            <table>
                <thead>
                    <tr>
                        <td></td>
                        <?php
                        for ($i = 0; $i < $_SESSION['gameBoardParams']['x']; $i++) {
                            ?>    
                            <th> <?php echo $i ?>
                            </th>
                        <?php }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < $_SESSION['gameBoardParams']['y']; $i++) {
                        ?>
                        <tr>
                            <td>
                                <b> <?php echo $i; ?> </b>
                            </td>
                            <?php
                            for ($j = 0; $j < $_SESSION['gameBoardParams']['x']; $j++) {
                                ?>
                                <td>
                                    <?php if($ticTacToe->getBlockStatus()){
                                        echo $ticTacToe->getHit($j, $i);
                                    } else { ?>
                                    <a href="?x=<?php echo $j; ?>&y=<?php echo $i; ?>">
                                        <?php
                                        echo $ticTacToe->getHit($j, $i);
                                        ?>
                                    </a>
                                    <?php } ?> 
                                </td>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </tbody>


            </table>
            <a href="?reset=1">RESET</a>
            <a href="?resetgameboard=1">RESET GAMEBOARD</a>
            <?php }
        ?>  


        <style>
            a {display: block; width:30px; height:30px; text-align: center; background:#DDD;}
        </style>
    </body>

</html>


