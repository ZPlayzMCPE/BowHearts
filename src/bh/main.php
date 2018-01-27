<?php
namespace bh;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
class main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder()."config.yml",Config::YAML,array(
				"Msg" => "Player {PLAYER} has {HEALTH}/{MAXHEALTH}",
				"Message" => "true",
				"Popup" => "false"
		));
		$this->config->save();
	}
	
	public function onHit(EntityDamageEvent $ev){
		$player = $ev->getEntity();
			if ($ev->getCause() === EntityDamageByEntityEvent::CAUSE_PROJECTILE){
                                if ($player instanceof Entity){
					$shooter = $ev->getDamager();
						if ($shooter instanceof Entity){
							$msg = $this->config->get("Msg");
							$msg = str_replace("{PLAYER}", $player->getName(), $msg);
							$msg = str_replace("{HEALTH}", $player->getHealth(), $msg);
							$msg = str_replace("{MAXHEALTH}", $player->getMaxHealth(), $msg);
							if ($this->config->get("Message") === "true"){
								$shooter->sendMessage($msg);
							} 
							if ($this->config->get("Popup") === "true"){
								$shooter->sendPopup($msg);
							}
						}
					
				}
			}
		
	}
	
	
}
