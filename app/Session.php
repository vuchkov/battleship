<?php

/**
 * Created by Ilcho Vuchkov
 * http://www.vuchkov.biz
*/

class Session
{

    private $id;

    /**
     * @return boolean
     */
    public function isNew()
    {
        return isset($_SESSION['game_id']);
    }

    public function newId()
    {
        $id = strval(rand(1, 99999));
        $this->id = $id;
        return $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function start()
    {
        session_id($this->id);
        session_start();
    }

    /**
     * @return string
     * @param string
     */
    public function getData()
    {
        return $_SESSION['game'];
    }

    /**
     * @return string
     * @param string
     */
    public function getTurn()
    {
        return $_SESSION['turn'];
    }

    /**
     * create global $_SESSION[$var] = $value
     * @param string $var
     * @param string $value
     */
    public function set($var, $value)
    {
        $_SESSION[$var] = $value;
        return true;
    }

    public function finish()
    {
        foreach($_SESSION as $s)
        {
            unset($s);
        }
    }

}