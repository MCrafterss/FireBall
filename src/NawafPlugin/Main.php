<?php

namespace NawafPlugin;

use pocketmine\network\protocol\Info;
use pocketmine\plugin\PluginBase;
use pocketmine\entity\Entity;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;

class Main extends PluginBase implements \pocketmine\event\Listener{

    const motion = 2;


    public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onItem(\pocketmine\event\player\PlayerInteractEvent $event){
		$player = $event->getPlayer();
			if($event->getItem()->getId() == 369){
      
			$fb = new Entity\FireBall($player->level->getChunk($player->x >> 4, $player->z >> 4), new \pocketmine\nbt\tag\CompoundTag("", [
			"Pos" => new \pocketmine\nbt\tag\ListTag("Pos", [
				new \pocketmine\nbt\tag\DoubleTag("", $player->x),
				new \pocketmine\nbt\tag\DoubleTag("", $player->y + 2),
				new \pocketmine\nbt\tag\DoubleTag("", $player->z)
			]),
			"Motion" => new \pocketmine\nbt\tag\ListTag("Motion", [
				new \pocketmine\nbt\tag\DoubleTag("", -sin($player->yaw / 180 * M_PI)  * cos($player->pitch / 180 * M_PI)),
				new \pocketmine\nbt\tag\DoubleTag("", -sin($player->pitch / 180 * M_PI)),
				new \pocketmine\nbt\tag\DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))
			]),
			"Rotation" => new \pocketmine\nbt\tag\ListTag("Rotation", [
				new \pocketmine\nbt\tag\FloatTag("", $player->yaw),
				new \pocketmine\nbt\tag\FloatTag("", $player->pitch)
			]),
			]),$player,1200);
                        
			$fb->spawnToAll();
                        $fb->setMotion($fb->getMotion()->multiply(self::motion));
			}
                    }}
?>
