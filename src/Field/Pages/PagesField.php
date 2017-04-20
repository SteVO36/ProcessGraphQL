<?php

namespace ProcessWire\GraphQL\Field\Pages;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;

use Processwire\GraphQL\Utils;
use ProcessWire\GraphQL\Type\Object\PagesType;

class PagesField extends AbstractField {

  public function getType()
  {
    return new PagesType();
  }

  public function getName()
  {
    return 'pages';
  }

  public function getDescription()
  {
    return 'The ProcessWire `pages` API.';
  }

  public function resolve($value, array $args, ResolveInfo $info)
  {
    return  Utils::pages();
  }

}