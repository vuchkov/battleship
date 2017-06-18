<?php

/**
 * Created by Ilcho Vuchkov
 * http://www.vuchkov.biz
*/

class Grid
{
    
    private $board;
    private $ships;

    public function __construct($str)
    {
        $this->board = substr($str, 0, 100);
        $this->ships = new Ships(substr($str, 100, 100));
    }

    /**
     * @param boolean
     **/
    public function view($cheat)
    {
        global $letter;
        echo '  1  2  3  4  5  6  7  8  9  10';
        
        $i = 0; $r = 0;
        while ($i <= 99)
        {
            echo PHP_EOL;
            echo $letter[$r].' ';
            
            if (!$cheat)
            {
                $row = substr($this->board, $i, 10);
                for ($c = 0; $c <= 9; $c++)
                {
                    switch(substr($row, $c, 1))
                        {
                            case 0 : echo '.  '; break;
                            case 1 : echo '-  '; break;
                            case 2 : echo 'X  '; 
                        }
                }
            }
            else
            {
                $row = substr($this->ships, $i, 10);    
                for ($c = 0; $c <= 9; $c++)
                {
                    switch(substr($row, $c, 1))
                    {
                        case 0 : echo '   '; break;
                        case 1 or 2 or 3 : echo 'X  '; 
                    }
                }
            }

            $i += 10;
            $r++;
        }
    }

    /**
     * @return string
     **/
    
    public function str()
    {
        
        return $this->board.$this->ships;

    }

}