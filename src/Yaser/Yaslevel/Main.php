<?php
namespace Yaser\Yaslevel;

use pocketmine\plugin\PluginBase;

use pocketmine\plugin\Plugin;

use pocketmine\Server;

use pocketmine\Player;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\utils\TextFormat;


use pocketmine\event\Listener;

use pocketmine\command\ConsoleCommandSender;

use onebone\economyapi\EconomyAPI;

use pocketmine\math\Vector3;

use pocketmine\scheduler\ClosureTask;

class Main extends PluginBase implements Listener{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new ClosureTask(
            function (int $_): void {
                foreach ($this->getServer()->getOnlinePlayers() as $p) {
                    $Player = $p->getPlayer();
                    $exp = $Player->getXpLevel();
                    $Player->setDisplayName("§a[ $exp ] §f".$Player->getName());
                   
                }
            }
        ), 100);
    }
    public function onCommand(\pocketmine\command\CommandSender $player, \pocketmine\command\Command $command, string $label, array $args): bool
    {
        if($command->getName() == "level"){
            if($player instanceof Player){
                $economy = $this->getServer()->getPluginManager()->getPlugin('EconomyAPI');
                if ($economy->myMoney($player) >= 1000000) {
					EconomyAPI::getInstance()->reduceMoney($player,1000000);
					$xp = $player->getXpLevel();
		            $level = $player->getLevel();
		            $name = $player->getName();
					$player->addXpLevels(1);
					$player->sendMessage("§aYou Have Been Level Upgraded To §e$xp");
				}else{
					$xp = $player->getXpLevel();
		            $level = $player->getLevel();
		            $name = $player->getName();
					$player->sendMessage("§a$name §cYou Dont Have §f1000000 §cMoney To LevelUP");
				}
			}else{
				$player->sendMessage("§b[ YasLevel ] §cUse This Command In Game");
			}
				
				

        }

        return true;
    }
}
