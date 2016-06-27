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
     * @throws \InvalidArgumentException when configuration with given name does not exists.
     */
    public function setDefaultConfiguration($name) {
        if (!$this->hasConfiguration($name)) {
            throw new InvalidArgumentException('Configuration does not exists.');
        }

        $this->defaultConfiguration = $name;
    }

    /**
     * @return bool
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
     * @throws \InvalidArgumentException when blank configuration name is provided.
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
     * @throws \InvalidArgumentException when configuration with given name does not exists.
     * @return array
     */
    public function getConfiguration($name) {
        if (!$this->hasConfiguration($name)) {
            throw new \InvalidArgumentException('Configuration does not exists.');
        }

        return $this->configurations[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasConfiguration($name) {
        return isset($this->configurations[$name]);
    }
    
    /**
     * @return bool
     */
    public function hasConfigurations() {
        return !empty($this->configurations);
    }

    /**
     * @param $name
     * @throws \InvalidArgumentException when configuration with given name does not exists.
     * @param array $configuration
     * @return array Merged configuration.
     */
    public function mergeConfiguration($name, array $configuration) {
        if (!$this->hasConfiguration($name)) {
            throw new \InvalidArgumentException('Configuration does not exists.');
        }

        return array_merge($this->getConfiguration($name), $configuration);
    }
}
