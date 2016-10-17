<?php

class TicTacToe {

    private $boardX;
    private $boardY;
    private $number;
    private $player1;
    private $player2;
    private $currentPlayer = 1;
    private $previousPlayer = 2;
    private $isWinner;
    private $score;
    private $isBlocked = false;

    public function __construct() {
        session_start();

        if (!$this->checkReset()) {
            $this->initVariables();
        }
        $this->checkHit();
        $this->isWinner = $this->getWin();
        $this->winScore();
        $this->blockBoard();
    }

    public function initVariables() {
        if (!empty($_SESSION['gameBoardParams'])) {
            $this->boardX = $_SESSION['gameBoardParams']['x'];
            $this->boardY = $_SESSION['gameBoardParams']['y'];
            $this->number = $_SESSION['gameBoardParams']['number'];
            $this->player1 = $_SESSION['gameBoardParams']['player1'];
            $this->player2 = $_SESSION['gameBoardParams']['player2'];
            $this->currentPlayer = $_SESSION['gameBoardParams']['currentPlayer'];
            $this->score = $_SESSION['score'];
        }
        if (empty($_SESSION['score'])) {
            $_SESSION['score'] = [
                1 => 0,
                2 => 0
            ];
        }
    }

    public function inputValidation() {
        if (isset($_POST['player1']) and strlen($_POST['player1']) === 1
                and $_POST['player1'] != $_POST['player2']) {
            $this->player1 = $_POST['player1'];
        }
        if (isset($_POST['player2']) and strlen($_POST['player2']) === 1) {
            $this->player2 = $_POST['player2'];
        }
        if (isset($_POST['x']) and is_numeric($_POST['x'])) {
            $this->boardX = $_POST['x'];
        }
        if (isset($_POST['y']) and is_numeric($_POST['y'])) {
            $this->boardY = $_POST['y'];
        }
        if (isset($_POST['number']) and is_numeric($_POST['number'])) {
            if ($_POST['number'] <= $this->boardX and $_POST['number'] <= $this->boardY) {
                $this->number = $_POST['number'];
            }
        }

        if (!empty($this->boardX) and ! empty($this->boardY) and ! empty($this->number)
                and ! empty($this->player1) and ! empty($this->player2)) {
            $_SESSION['inputOk'] = true;
            $_SESSION['gameBoardParams'] = [
                'x' => $this->boardX,
                'y' => $this->boardY,
                'number' => $this->number,
                'player1' => $this->player1,
                'player2' => $this->player2,
                'currentPlayer' => $this->currentPlayer,
            ];
//            $_SESSION['gameBoard'] = [];

            return true;
        } elseif (isset($_POST['x'])) {

            return 1;
        }

        return false;
    }

    public function switchPlayer() {
        if ($this->currentPlayer === 1) {
            $this->currentPlayer = 2;
        } else {
            $this->currentPlayer = 1;
        }
    }

    public function checkHit() {
        if (isset($_GET['x']) and is_numeric($_GET['x']) and $_GET['x'] <= $this->boardX) {
            if (isset($_GET['y']) and is_numeric($_GET['y']) and $_GET['y'] <= $this->boardY) {
                if (empty($_SESSION['gameBoard'][$_GET['x']][$_GET['y']])) {
                    $_SESSION['gameBoard'][$_GET['x']][$_GET['y']] = $this->currentPlayer;
                    $this->previousPlayer = $this->currentPlayer;
                    $this->switchPlayer();
                    $_SESSION['gameBoardParams']['currentPlayer'] = $this->currentPlayer;
                }
            }
        }
    }

    public function getPlayer1Sign() {
        return $this->player1;
    }

    public function getPlayer2Sign() {
        return $this->player2;
    }

    public function getX() {
        return $this->boardX;
    }

    public function getY() {
        return $this->boardY;
    }

    public function getNumber() {
        return $this->number;
    }

    public function isInputOK() {
        return isset($_SESSION['inputOk']);
    }

    public function getHit($x, $y) {
        if (!empty($_SESSION['gameBoard'][$x][$y])) {
            if ($_SESSION['gameBoard'][$x][$y] === 1) {
                return $_SESSION['gameBoardParams']['player1'];
            } else {
                return $_SESSION['gameBoardParams']['player2'];
            }
        } else {
            return '&nbsp;';
        }
    }

    public function isHit($x, $y) {
        if (!empty($_SESSION['gameBoard'][$x][$y])) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkReset() {
        if (isset($_GET['reset'])) {
            $this->resetGame();
            return true;
        }
        if (isset($_GET['resetgameboard'])) {
            $this->resetGameboard();
            return TRUE;
        }

        return false;
    }

    public function resetGame() {
        session_unset();
        session_destroy();
        header('Location: index.php');
    }

    public function resetGameboard() {

        unset($_SESSION['gameBoard']);
    }

    public function getCurrentPlayer() {
        return $this->currentPlayer;
    }
    
    public function getPreviousPlayer() {
        return $this->previousPlayer;
    }

    public function isDraw() {

        for ($i = 0; $i < $this->boardX; $i++) {
            for ($j = 0; $j < $this->boardY; $j++) {
                if (!$this->isHit($i, $j)) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public function checkWinHorizontal() {
        if (isset($_SESSION["gameBoard"])) {

            for ($j = 0; $j < $this->boardY; $j++) {
                $counter = 0;
//                var_dump($this->number);
                for ($i = 0; $i < $this->boardX; $i++) {

//                    echo '<pre>';
//                    echo '__'.$i.'/'.$j.'__';
//                    echo $_SESSION["gameBoard"][$i][$j];
//                    echo '</pre>';


                    if (isset($_SESSION["gameBoard"][$i][$j]) and
                            $_SESSION["gameBoard"][$i][$j] ===
                            $this->previousPlayer) {
                        $counter++;
                    } else {
//                            echo 'reset dla: '.$i.'/'.$j.''
                        $counter = 0;
                    }
                    if ($counter === intval($this->number)) {
                        return $this->previousPlayer;
                    }
                }
            }
        }
        return FALSE;
    }

    public function checkWinVertical() {
        if (isset($_SESSION["gameBoard"])) {
            for ($i = 0; $i < $this->boardX; $i++) {
                $counter = 0;
                for ($j = 0; $j < $this->boardY; $j++) {
                    if (isset($_SESSION["gameBoard"][$i][$j]) and
                            $_SESSION["gameBoard"][$i][$j] ===
                            $this->previousPlayer) {
                        $counter++;
                    } else {
                        $counter = 0;
                    }
                    if ($counter === intval($this->number)) {
                        return $this->previousPlayer;
                    }
                }
            }
        }
        return FALSE;
    }

    public function getWin() {
        $win = false;
        if ($this->checkWinHorizontal()) {
            $win = true;
        }
        if ($this->checkWinVertical()) {
            $win = true;
        }

        if ($this->checkWinAccross()) {
            $win = true;
        }        
        return $win;
    }

    public function getWinner() {
        return $this->isWinner;
    }

    public function winScore() {
        if (!empty($this->isWinner)) {
            $_SESSION['score'][$this->previousPlayer] ++;
        }
    }

    public function blockBoard() {
        var_dump($this->isWinner);
        if (!empty($this->isWinner)) {
            $this->isBlocked = true;
        }
    }

    public function getBlockStatus() {

        return $this->isBlocked;
    }

    public function checkWinAccross() {

        for ($j = 0; $j < $this->boardY;  $j++) {
            $z = $j; 
            $counter = 0;
            for ($i = 0; $i < $this->boardX; $i++, $z++) {                
                if (isset($_SESSION["gameBoard"][$i][$z]) and
                        $_SESSION["gameBoard"][$i][$z] ===
                        $this->previousPlayer) {
                    $counter++;
                } else {
                    $counter = 0;
                }
                if ($counter === intval($this->number)) {
                    return $this->previousPlayer;
                }                               
            }
        }
        
        for ($i = 1; $i < $this->boardX;  $i++) {
            $z = $i; 
            $counter = 0;
            for ($j = 0; $j < $this->boardY; $j++, $z++) {                
                if (isset($_SESSION["gameBoard"][$z][$j]) and
                        $_SESSION["gameBoard"][$z][$j] ===
                        $this->previousPlayer) {
                    $counter++;
                } else {
                    $counter = 0;
                }
                if ($counter === intval($this->number)) {
                    return $this->previousPlayer;
                }                               
            }
        }  
        
        for ($j = 0; $j < $this->boardY;  $j++) {
            $z = $j; 
            $counter = 0;
            for ($i = $this->boardX - 1; $i >= 0 ; $i--, $z++) {                
                if (isset($_SESSION["gameBoard"][$i][$z]) and
                        $_SESSION["gameBoard"][$i][$z] ===
                        $this->previousPlayer) {
                    $counter++;
                } else {
                    $counter = 0;
                }
                if ($counter === intval($this->number)) {
                    return $this->previousPlayer;
                }                               
            }
        }

        for ($i = 0; $i < $this->boardX - 1;  $i++) {
            $z = $i; 
            $counter = 0;
            for ($j = 0; $j < $this->boardY; $j++, $z--) {                
                if (isset($_SESSION["gameBoard"][$z][$j]) and
                        $_SESSION["gameBoard"][$z][$j] ===
                        $this->previousPlayer) {
                    $counter++;
                } else {
                    $counter = 0;
                }
                if ($counter === intval($this->number)) {
                    return $this->previousPlayer;
                }                               
            }
        }          
        return false;
    }
    
   


}
