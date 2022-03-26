<?php

declare (strict_types = 1);

namespace App;

abstract class Model
{
    arrayprivate $fields;
    stringprivate $table_name;

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
        $this->fields = [];
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }
        return null;
    }

    public function __set(string $name, $value)
    {
        $this->fields[$name] = $value;
    }

}

class Field
{
    stringprivate $name;
    stringprivate $type;
    boolprivate $required;

    public function __construct(string $name, string $type, bool $required)
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}
