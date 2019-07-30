<?php namespace ProcessWire\GraphQL\Type\Fieldtype;

use GraphQL\Type\Definition\Type;
use ProcessWire\GraphQL\Type\ImageType;
use ProcessWire\GraphQL\Type\Traits\CacheTrait;
use ProcessWire\GraphQL\Type\Traits\FieldTrait;
use ProcessWire\GraphQL\Type\Traits\InputTypeTrait;

class FieldtypeImage
{
  use CacheTrait;
  use FieldTrait;
  use InputTypeTrait;
  public static function type()
  {
    return self::cache('dafault', function () {
      return Type::listOf(ImageType::type());
    });
  }
}
