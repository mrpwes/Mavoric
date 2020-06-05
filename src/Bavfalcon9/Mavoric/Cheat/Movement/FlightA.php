<?php
/***
 *      __  __                       _      
 *     |  \/  |                     (_)     
 *     | \  / | __ ___   _____  _ __ _  ___ 
 *     | |\/| |/ _` \ \ / / _ \| "__| |/ __|
 *     | |  | | (_| |\ V / (_) | |  | | (__ 
 *     |_|  |_|\__,_| \_/ \___/|_|  |_|\___|
 *                                          
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 * 
 *  @author Bavfalcon9
 *  @link https://github.com/Bavfalcon9/Mavoric                                  
 */
namespace Bavfalcon9\Mavoric\Cheat\Movement;

use pocketmine\Player;
use pocketmine\block\Air;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\math\Vector3;
use Bavfalcon9\Mavoric\Mavoric;
use Bavfalcon9\Mavoric\Cheat\Cheat;
use Bavfalcon9\Mavoric\Cheat\CheatManager;

class FlightA extends Cheat {
    /** @var int[] */
    private $damageTimes;

    public function __construct(Mavoric $mavoric, int $id = -1) {
        parent::__construct($mavoric, "FlightA", "Movement", $id, true);
        $this->damageTimes = [];
    }

    public function onDamaged(EntityDamageByEntityEvent $ev): void {
        if ($ev->getEntity() instanceof Player) {
            $this->damageTimes[$ev->getEntity()->getName()] = microtime(true);
        }
    }

    public function onPlayerMove(PlayerMoveEvent $ev): void {
        $player = $ev->getPlayer();
        $from = $ev->getFrom();
        $to = $ev->getTo();

        if ($player->getAllowFlight() === true) return;

        if (Mavoric::$MATH_MODE === '0.2') {
            $blockAbove = $player->getLevel()->getBlock($player)->getSide(Vector3::SIDE_UP);
            $blockUnder = $blockAbove->getSide(Vector3::SIDE_DOWN);
        } else {
            $blockAbove = $player->getLevel()->getBlock($player)->getSide(\pocketmine\math\Facing::UP);
            $blockUnder = $blockAbove->getSide(\pocketmine\math\Facing::DOWN);        
        }

        $airTime = $player->getInAirTicks() - ($player->getPing() / 20); // divide by 20 to convert to ticks
        $yDistance = $to->y - $from->y;
        $xyzDistance = $from->distance($to);
        $lastDamageTime = microtime(true) - ($this->damageTimes[$player->getName()] ?? 0);

        if ($lastDamageTime <= 3) return;
        
        if ($blockAbove instanceof Air) {
            if ($yDistance >= 0 && $airTime >= 100) {
                // we need to check for jump boost effect here
                $this->increment($player->getName(), 1);
                $this->notifyAndIncrement($player, 4, 1, [
                    "AirTime" => $airTime,
                    "DistY" => $yDistance,
                    "Ping" => $player->getPing()
                ]);
                return;
            }

            if ($airTime >= 200) {
                $this->debug('Expected air cheat');
                $this->increment($player->getName(), 1);
                $this->notifyAndIncrement($player, 4, 1, [
                    "AirTime" => $airTime,
                    "Ping" => $player->getPing()
                ]);
                return;
            }
        }
    }
}