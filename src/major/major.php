<?php

namespace major;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\block\Block;

class major extends PluginBase implements Listener{
	public $data = [];
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function ontap(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		if($player->isOP()){
			if($player->getInventory()->getItemInHand()->getId() == 280){
				$name = $player->getName();
				if(!$player->isSneaking()){
					$block = $event->getblock();
					if(isset($this->data[$name])){
						$distance = $this->data[$name]->distance($block->asVector3());//
						$player->sendMessage("§6".(round($distance,2)+1)." m");
					}else{
						$this->data[$name] = $block->asVector3();
						$player->sendMessage("[メジャー]このブロックの座標を記録しました。 {$block->x}, {$block->y}, {$block->z} ");	
					}
				}else{
					unset($this->data[$name]);
					$player->sendMessage("[メジャー]記録した座標のデータを削除しました");
				}
			}
		}
	}
}