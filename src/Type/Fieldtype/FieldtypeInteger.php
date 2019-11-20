<?php namespace ProcessWire\GraphQL\Type\Fieldtype;

use GraphQL\Type\Definition\Type;
use ProcessWire\GraphQL\Type\Fieldtype\Traits\FieldTrait;
use ProcessWire\GraphQL\Type\Fieldtype\Traits\InputFieldTrait;
use ProcessWire\GraphQL\Type\Fieldtype\Traits\SetValueTrait;

class FieldtypeInteger
{ 
  use FieldTrait;
  use InputFieldTrait;
  use SetValueTrait;
  public static function type()
  {
    return Type::int();
  }
}
