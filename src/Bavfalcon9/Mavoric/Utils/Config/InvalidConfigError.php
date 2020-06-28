<?php

/**
 *      __  __                       _      
 *     |  \/  |                     (_)     
 *     | \  / | __ ___   _____  _ __ _  ___ 
 *     | |\/| |/ _` \ \ / / _ \| '__| |/ __|
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

namespace Bavfalcon9\Mavoric\Utils\Config;

class InvalidConfigError {
    public const ERROR_KEY_MISSING = 0;
    public const ERROR_VALUE_INVALID = 1;
    public const ERROR_KEY_INVALID = 2;
    public const ERROR_VALUE_EXCEEDED = 3;
    public const ERROR_KEYS_NOT_EXACT = 4;
    public const ERROR_VALUES_NOT_EXACT = 5;

    /** @var int */
    protected $type;
    /** @var string */
    protected $detailedMessage;
    /** @var string|int */
    protected $key;
    /** @var mixed */
    protected $providedValue;
    /** @var Closure|null */
    protected $requirement;

    public function __construct(int $type = self::ERROR_VALUE_INVALID, string $detailedMessage = null) {
        $this->type = $type;
        $this->detailedMessage = $detailedMessage ?? "Unknown error";
    }

    public function getType(): int {
        return $this->type;
    }

    public function getMessage(): string {
        return $this->message;
    }
}