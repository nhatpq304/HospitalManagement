<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 3/1/2020
 * Time: 8:38 PM
 */

namespace App\Objects;


class PermissionObject
{
    public  $name;
    public  $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


}