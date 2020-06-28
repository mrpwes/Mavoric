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

namespace Bavfalcon9\Mavoric\Utils;

trait ValidConfigTrait {
    protected $validConfigMap = [];

    public function addValidator(string $key, Closure $func): void {
        if (isset($this->validConfigMap[$key])) throw new Exception('Key validator exists.');
        $this->validConfigMap[$key] = $func;
    }

    /**
     * This bypasses a closure check.
     * To Do: Check for closures
     */
    public function addNestedValidator(string $key, array $validators): void {
        if (isset($this->validConfigMap[$key])) throw new Exception('Key validator exists.');
        $this->validConfigMap[$key] = $validators;
    }

    public function isValid(string $key, $value): bool {
        if (!isset($this->validConfigMap[$key])) return false;
        
        $validator = $validConfigMap[$key];
        return $validator($value);
    }

    /**
     * Validate whether a array of nested values matches the current validator
     * @return InvalidConfigTrait|bool
     */
    public function validate(array $nestedValues = null, $validMap = null) {
        // To do: Invalid Config traits
        $validMap = ($validMap ?? $this->validConfigMap ?? []);
        if (empty($validMap)) return false;
        foreach ($validMap as $key=>$validator) {
            if (!isset($nestedValues[$key])) return false;
            if ($validator instanceof Closure) {
                if (!$validator($nestedValues[$key])) return false;
            } else if (is_array($validator)) {
                if (!is_array($nestedValues[$key])) return false;
                if (array_keys($validator) !== array_keys($nestedValues[$key])) return false;
                if (!$this->validate($nestedValues[$key], $validator)) return false;
            } else {
                return false;
            }
        }
        
        return true;
    }
}