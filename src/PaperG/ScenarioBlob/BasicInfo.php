<?php

namespace PaperG\ScenarioBlob;


class BasicInfo implements BlobInterface
{
    use Utility;

    const NAME = "name";
    const UUID = "uuid";
    const METADATA = "metadata";
    const SCENARIO = "scenario";
    const BLOB = "blob";
    const VERSION = 'version';

    const CURRENT_VERSION  = 1;

    /**
     * @var string Advertising campaign name
     */
    private $name;

    /**
     * @var string identifier
     */
    private $uuid;

    /**
     * @var string purpose of sending this blob
     */
    private $metadata;

    /**
     * @var string
     */
    private $scenario;

    /**
     * @var BlobInterface
     */
    private $blob;

    public function __construct($array = null) {
        $this->fromArray($array);
    }

    /**
     * @param string $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $scenario
     */
    public function setScenario($scenario)
    {
        if (in_array($scenario, Scenario::$validScenarios)) {
            $this->scenario = $scenario;
        }
    }

    /**
     * @return string
     */
    public function getScenario()
    {
        return $this->scenario;
    }

    /**
     * @param BlobInterface $subBlob
     */
    public function setBlob($subBlob)
    {
        $this->blob = $subBlob;
    }

    /**
     * @return BlobInterface
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    public function toArray()
    {
        return [
            self::NAME     => $this->getName(),
            self::UUID     => $this->getUuid(),
            self::METADATA => $this->getMetadata(),
            self::SCENARIO => $this->getScenario(),
            self::BLOB     => isset($this->blob) ? $this->getBlob()->toArray() : null,
            self::VERSION  => self::CURRENT_VERSION
        ];
    }

    public function fromArray($array)
    {
        $this->setName($this->safeGet($array, self::NAME));
        $this->setUuid($this->safeGet($array, self::UUID));
        $this->setMetadata($this->safeGet($array, self::METADATA));
        $this->setScenario($this->safeGet($array, self::SCENARIO));
        $this->setBlob($this->safeGet($array, self::BLOB));
    }

    public function validate()
    {
        $missing = [];
        if (empty($this->name)) {
            $missing[] = "name";
        }

        if (empty($this->uuid)) {
            $missing[] = "uuid";
        }

        if (empty($this->scenario)) {
            $missing[] = "scenario";
        }

        if (!empty($missing)) {
            throw new \InvalidArgumentException("Invalid BasicBlob, missing: " . implode(", ", $missing));
        }

        return true;
    }
}
