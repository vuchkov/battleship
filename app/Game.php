<?php

/**
 * Created by Ilcho Vuchkov
 * http://www.vuchkov.biz
*/

class Game
{
    public $gameId;
    //private $session;
    public $grid;
    //private $ships;
    public $turn; // int
    private $cheat = false;
    private $finish = false;

    private $message = array(
        'error' => '*** Error ***',
        'miss'  => '*** Miss ***',
        'hit'   => '*** Hit ***',
        'sunk'  => '*** Sunk ***',
        'finish'=> 'Well done! You completed the game in '  // 15 shots
    );

    public function __construct($gameId, $grid, $turn)
    {
        $this->gameId = $gameId;
        
        $this->grid = new Grid($grid);

        $this->turn = $turn;
    }

    /**
     * @param string
     * @return string
     **/
    public function action($coord)
    {
        global $number;
        $this->cheat = false;

        if ($coord == 'show')
        {
            $this->cheat = true;
        }

        else
        {
            $symbol = strtoupper( substr($coord, 0, 1) );
            $y = $number[$symbol];
            $x = (int) substr( $coord, 1, strlen( $coord ) - 1 );
            if( ( ($y >= 1) && ($y <= 10) ) && ( ($x >= 1) && ($x <= 10) ) ) {
                $this->turn++;
                if ($this->shoot($x, $y)) {
                    if (!$this->finish) 
                    { 
                        return $this->message['hit']; 
                    }
                    else 
                    { 
                        return $this->message['finish'].$turn.' shots'.PHP_EOL; 
                    }
                } else {
                    return $this->message['miss'].PHP_EOL;
                }

            } else {
                return $this->message['error'].PHP_EOL;
            }
        }

    }
    
    /**
     * @param boolean
     **/

    public function view($web, $status)
    {
        echo ($web) ? 
            '<!doctype html><html><body><pre>' : '';
        
        $this->grid->view($this->cheat);

        if ($web) 
        { 
            echo '</pre><form name="input" action="index.php" method="post">
            Enter coordinates (row, col), e.g. A5 <input type="input" size="5" name="coord" autocomplete="off" required autofocus>
            <input type="hidden" name="game_id" value="'.$this->gameId.'">
            <input type="submit" value="SUBMIT"></form>
            <hr>For console use [game_id] == '.$this->gameId.PHP_EOL.'</body></html>';
        } 
        else 
        {
            echo 'Usage: php -f index.php [game_id]=='.$this->gameId.' [coord] \n';
        }
    }

}