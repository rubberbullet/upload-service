<?php

namespace Meesho\Image\Model;

/**
 * Description of ImageModel
 *
 * @author krishna.acharjee
 */
class ImageModel
{

    private $imageId;
    private $name;
    private $modName;
    private $location;
    private $type;
    private $modDate;

    function getImageId() {
        return $this->imageId;
    }

    function getName() {
        return $this->name;
    }

    function getLocation() {
        return $this->location;
    }

    function getType() {
        return $this->type;
    }

    function getModDate() {
        return $this->modDate;
    }

    function setImageId($imageId) {
        $this->imageId = $imageId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setModDate($modDate) {
        $this->modDate = $modDate;
    }

    function getModName() {
        return $this->modName;
    }

    function setModName($modName) {
        $this->modName = $modName;
    }

}
