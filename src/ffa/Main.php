<?php
namespace ffa;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    
    private static $instance;
    
    public function onLoad()
    {
        static::$instance = $this;
    }
    
    public function onEnable(){
        $this->getServer()->getLogger()->info("§bFFA §r- §aActivado");
        $config = new Config($this->getDataFolder()."/Config.yml", Config::YAML);
        $config->save();
        $this->getServer()->getCommandMap()->register("/ffa",new FCommand());
        new Events();
    }
    
    public function onDisable()
    {
        $this->getServer()->getLogger()->info("§bFFA §r- §cDesactivado");
    }

    /**
     * @return mixed
     */
    public static function getInstance(): Main
    {
        return self::$instance;
    }
    
    

}
