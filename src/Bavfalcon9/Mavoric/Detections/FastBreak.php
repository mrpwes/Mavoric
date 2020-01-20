<?php
/***
 *      __  __                       _      
 *     |  \/  |                     (_)     
 *     | \  / | __ ___   _____  _ __ _  ___ 
 *     | |\/| |/ _` \ \ / / _ \| '__| |/ __|
 *     | |  | | (_| |\ V / (_) | |  | | (__ 
 *     |_|  |_|\__,_| \_/ \___/|_|  |_|\___|
 *                                          
 *   THIS CODE IS TO NOT BE REDISTRUBUTED
 *   @author MavoricAC
 *   @copyright Everything is copyrighted to their respective owners.
 *   @link https://github.com/Olybear9/Mavoric                                  
 */

namespace Bavfalcon9\Mavoric\Detections;

use Bavfalcon9\Mavoric\Main;
use Bavfalcon9\Mavoric\Mavoric;
use Bavfalcon9\Mavoric\events\MavoricEvent;
use Bavfalcon9\Mavoric\events\player\PlayerBreakBlock;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;

class FastBreak implements Detection {
    private $mavoric;

    public function __construct(Mavoric $mavoric) {
        $this->mavoric = $mavoric;
    }

    public function onEvent(MavoricEvent $event): void {
        /** @var PlayerBreakBlock */
        if (!$event instanceof PlayerBreakBlock) {
            return;
        }
        if ($event->getPlayer()->getGamemode() === 1) {
            return;
        }

        $block = $event->getBlock();
        $expectedTime = ceil($event->getBlock()->getBreakTime($event->getItem()));
        $expectedTime -= 2;

        if ($event->getTime() < $expectedTime) {
            $event->issueViolation(Mavoric::CHEATS['FastBreak']);
            $event->sendAlert('FastBreak', "Broke block {$block->getName()} in {$event->getTime()} seconds when time should be {$expectedTime}");
            return;
        }
        
    }
    
    public function isEnabled(): Bool {
        return true;
    }
}