<?php

namespace NawafPlugin\Entity;

class FireBall extends \pocketmine\entity\Projectile{
    
	const NETWORK_ID = 94;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.03;
	protected $drag = 0.01;

        private $lg;
        public function __construct(\pocketmine\level\format\FullChunk $chunk, CompoundTag $nbt, Entity $shootingEntity = null,$lg = 1200){
                $this->lg = $lg;
                Entity::registerEntity(FireBall::class);
		parent::__construct($chunk, $nbt, $shootingEntity);
	}

        public function getName() {
            return "FireBall";
        }
        
        
                
	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}
                
                $this->timings->startTiming();
                $this->updateMovement();
		$hasUpdate = parent::onUpdate($currentTick);
                
		if($this->age > $this->lg or $this->isCollided){
			$this->kill();
			$hasUpdate = true;
		}

		$this->timings->stopTiming();

		return $hasUpdate;
	}

	public function spawnTo(\pocketmine\Player $player){
		$pk = new AddEntityPacket();
		$pk->type = FireBall::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
