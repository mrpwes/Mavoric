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
 *  @link https://github.com/Olybear9/Mavoric                                  
 */
namespace Bavfalcon9\Mavoric\Utils;

use pocketmine\entity\Entity;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

class EffectUtils {
    /**
     * Gets the effect level for the given effect on an entity.
     * @param Entity $entity - Entity to check.
     * @param int $effectID - The id of the effect to get the level of
     * @return int
     */
    public static function getEffectLevel(Entity $entity, int $effectID): int {
        return ($effect = $entity->getEffect($effectID)) instanceof EffectInstance ? $effect->getEffectLevel() : 0;
    }
}