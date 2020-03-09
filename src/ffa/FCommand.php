<?php
/**
 * Created by PhpStorm.
 * User: Zulema
 * Date: 09/03/2020
 * Time: 12:51 AM
 */

namespace ffa;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\player;
use pocketmine\Server;
use pocketmine\utils\Config;

class FCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct('ffa', 'ffa command', null, ['ffa']);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param string[] $args
     *
     * @return mixed
     */
    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            $config = new Config(Main::getInstance()->getDataFolder()."/Config.yml", Config::YAML);
            if ($args[0] == "join"){
                $sender->setGamemode(0);
                $arena = $config->get("arena");
                if (!Server::getInstance()->isLevelLoaded($arena)) Server::getInstance()->loadLevel($arena);
                $sender->teleport(Server::getInstance()->getLevelByName($arena)->getSafeSpawn(),0,0);
               // $sender->getInventory()->clearAll();
                $this->kit($sender);
            }
            if ($args[0] == "register"){
                if ($sender->hasPermission("ffa.use")){
                    if(isset($args[1])){
                        $config->set("arena",$args[1]);
                        $config->save();
                        $sender->sendMessage("§bFFA §r> §aMapa registrado §b{$args[1]}");
                    } else{
                        $sender->sendMessage("§cIngresa /ffa register <mapa>");
                    }
                } else {
                    $sender->sendMessage("§cNo tienes permisos");
                }
            }
        }
    }
    
    public function kit(Player $player){
$player->getInventory()->clearAll();
        $sword = Item::get(276,0,1);
        $helmet = Item::get(314,0,1);
        $chest = Item::get(315,0,1);
        $leg = Item::get(316,0,1);
        $bot = Item::get(317,0,1);
        $sword->addEnchantment(Enchantment::getEnchantment(9)->setLevel(1));
        $helmet->addEnchantment(Enchantment::getEnchantment(17)->setLevel(3));
        $chest->addEnchantment(Enchantment::getEnchantment(17)->setLevel(3));
        $leg->addEnchantment(Enchantment::getEnchantment(17)->setLevel(3));
        $bot->addEnchantment(Enchantment::getEnchantment(17)->setLevel(3));
        $player->getInventory()->setChestplate($chest);
        $player->getInventory()->setHelmet($helmet);
        $player->getInventory()->setLeggings($leg);
        $player->getInventory()->setBoots($bot);
        $player->getInventory()->setItem(0,$sword);
        $player->getInventory()->setItem(1, Item::get(297,0,30));
        $player->getInventory()->setItem(2, Item::get(322,0,15));
        $player->getInventory()->sendArmorContents($player);
        $player->getInventory()->sendContents($player);
        $player->getInventory()->sendHeldItem($player);
    }
}