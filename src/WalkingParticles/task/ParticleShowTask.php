<?php

/*
 * This file is a part of WalkingParticles.
 * Copyright (C) 2015 CyberCube-HK
 *
 * WalkingParticles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * WalkingParticles is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WalkingParticles. If not, see <http://www.gnu.org/licenses/>.
 */
namespace WalkingParticles\task;

use pocketmine\math\Vector3;
use pocketmine\Player;
use WalkingParticles\WalkingParticles;
use WalkingParticles\base\BaseTask;

class ParticleShowTask extends BaseTask{

	public function onRun($tick){
		$t = $this->getPlugin()->getData()->getAll();
		foreach((array) $this->getPlugin()->getServer()->getOnlinePlayers() as $p){
			if(isset($t[$p->getName()]) && $this->getPlugin()->isCleared($p) !== true && $t[$p->getName()]["enabled"] !== false){
				if($this->getPlugin()->VanishNoPacket !== null){
					if($this->getPlugin()->VanishNoPacket->isVanished($p) !== false && $this->plugin->getConfig()->get("hideparticles-vanished") !== false){
						return;
					}
				}
				if($this->getPlugin()->getConfig()->get("worlds-only") !== false){
					foreach($this->getPlugin()->getConfig()->get("allowed-worlds") as $world){
						if($p->getLevel()->getName() == $world){
							return;
						}
					}
				}
				foreach((array) $t[$p->getName()]["particle"] as $particle){
					if($this->getPlugin()->getParticles()->getTheParticle($particle, new Vector3($p->x, $p->y, $p->z)) == "unknown_particle"){
						return;
					}
					$y = $p->y;
					$y2 = $y + 0.5;
					$y3 = $y2 + 1.4;
					$p->getLevel()->addParticle($this->getPlugin()->getParticles()->getTheParticle($particle, new Vector3($p->x, mt_rand($y, rand($y2, $y3)), $p->z)));
				}
			}
		}
	}

}
?>