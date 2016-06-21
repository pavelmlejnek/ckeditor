<?php

namespace CKEditor\Model;

use Nette\InvalidArgumentException;

class ConfigurationsManager
{
    /**
     * @var array
     */
    private $configurations = [];

    /**
     * @var string
     */
    private $defaultConfiguration;

    /**
     * @param string $name
     */
    public function setDefaultConfiguration($name) {
        if (!$this->hasConfiguration($name)) {
            throw new InvalidArgumentException('Configuration does not exists.');
        }

        $this->defaultConfiguration = $name;
    }

    /**
     * @return boolean
     */
    public function hasDefaultConfiguration() {
        if ($this->defaultConfiguration === NULL) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @return string|null
     */
    public function getDefaultConfiguration() {
        return $this->defaultConfiguration;
    }

    /**
     * @param string $name
     * @param array $values
     */
    public function addConfiguration($name, $values = []) {
        if ($name === '') {
            throw new \InvalidArgumentException('You cannot add configuration with blank name.');
        }

        $this->configurations[$name] = $values;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getConfiguration($name) {
        if (!$this->hasConfiguration($name)) {
            throw new \InvalidArgumentException('Configuration does not exists.');
        }

        return $this->configurations[$name];
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasConfiguration($name) {
        return isset($this->configurations[$name]);
    }
    
    /**
     * @return boolean
     */
    public function hasConfigurations() {
        return !empty($this->configurations);
    }

    /**
     * @param $name
     * @param array $configuration
     */
    public function mergeConfiguration($name, array $configuration) {
        if (!$this->hasConfiguration($name)) {
            throw new \InvalidArgumentException('Configuration does not exists.');
        }

        return array_merge($this->getConfiguration($name), $configuration);
    }
}
