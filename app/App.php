<?php

use Core\Config;
use Core\Database\MysqlDatabase;

class App
{
    private static $_instance;
    private $db_instance;
    public $title = 'Mo-Mo-Oh!';

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load()
    {
        session_start();
        require ROOT.'/app/Autoloader.php';
        App\Autoloader::register();

        require ROOT.'/core/Autoloader.php';
        Core\Autoloader::register();
    }

    public function getTable($name)
    {
        $className = '\\App\\Table\\' . ucfirst($name) . 'Table';
        return new $className($this->getDb());
    }

    public function getDb()
    {
        $config = Config::getInstance(ROOT. '/config/config.php');
        if (is_null($this->db_instance)) {
            $this->db_instance = new MysqlDatabase($config->get('dbName'), $config->get('dbUser'), $config->get('dbPassword'), $config->get('dbHost'));
        }
        return $this->db_instance;
    }

    public function dateFr($d)
    {
        $month = array(
            " Janvier ",
            " Février ",
            " Mars ",
            " Avril ",
            " Mai ",
            " Juin ",
            " Juillet ",
            " Août ",
            " Septembre ",
            " Octobre ",
            " Novembre ",
            " Décembre "
        );

        $m = (int)date('m', strtotime($d));

        return date('d', strtotime($d)).$month[$m].date('Y', strtotime($d));
    }

    public function substrwords($text, $maxchar, $end='...') {
        if (mb_strlen($text) > $maxchar) {
            $words = preg_split('/\s/u', $text);      
            $output = '';
            $i      = 0;
            while (1) {
                $length = mb_strlen($output)+mb_strlen($words[$i]);
                if ($length > $maxchar) {
                    break;
                } 
                else {
                    $output .= " " . $words[$i];
                    ++$i;
                }
            }
            $output .= $end;
        } 
        else {
            $output = $text;
        }
        return $output;
    }

    public function darkorlight($hex){
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        $darkorlight = (0.3*($r)) + (0.59*($g)) + (0.11*($b));
        return ($darkorlight >= 128 ? 1 : 0);
    }
}
