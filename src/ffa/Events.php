<?php
namespace ffa;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\Item;
use pocketmine\player;
use pocketmine\Server;
use pocketmine\utils\Config;

class Events implements Listener
{

    public function __construct()
    {
        Server::getInstance()->getPluginManager()->registerEvents($this, Main::getInstance());
    }

    public function onBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $config = new Config(Main::getInstance()->getDataFolder()."/Config.yml", Config::YAML);
        $map = $config->get("arena");
        $arena = Server::getInstance()->getLevelByName($map);
        if ($level == $arena){
            $event->setCancelled(true);
        }
    }

    public function onPlace(BlockPlaceEvent $event){
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $config = new Config(Main::getInstance()->getDataFolder()."/Config.yml", Config::YAML);
        $map = $config->get("arena");
        $arena = Server::getInstance()->getLevelByName($map);
        if ($level == $arena){
            $event->setCancelled(true);
        }
    }

    public function onDeath(PlayerDeathEvent $event){
        $player = $event->getEntity();
        $level = $player->getLevel();
        $cause = $player->getLastDamageCause();
        $event->setDeathMessage("");
        $event->setDrops([]);
        $config = new Config(Main::getInstance()->getDataFolder()."/Config.yml",Config::YAML);
        $map = $config->get("arena");
        $arena = Server::getInstance()->getLevelByName($map);
        if ($level == $arena){
            if ($cause instanceof EntityDamageByEntityEvent){
                $killer = $cause->getDamager();
                if ($killer instanceof Player){
                    $killer->setHealth(20);
                    $killer->getInventory()->addItem(2, Item::get(322,0,10));
                }
                foreach ($player->getLevel()->getPlayers() as $players) {
                    $players->sendMessage("§c{$player->getName()} §ffue destruido por §b{$killer->getName()}");
                }
            }
        }

    }
    

}