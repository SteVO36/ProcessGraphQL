<?php namespace ProcessWire\GraphQL\Test\Permissions;

use ProcessWire\GraphQL\Test\GraphqlTestCase;
use ProcessWire\GraphQL\Utils;

class SuperuserCanViewTest extends GraphqlTestCase {

  const settings = [
    'login' => 'admin',
    'legalTemplates' => ['skyscraper'],
  ];


  public function testSuperuserCanView() {
    $target = Utils::pages()->get('template=skyscraper, sort=random');
    $query = "{
      skyscraper(s: \"id={$target->id}\") {
        list {
          id
          name
          url
        }
      }
    }";
    $res = self::execute($query);
    assertEquals(
      $target->id,
      $res->data->skyscraper->list[0]->id,
      'Retrieves the correct id.'
    );
    assertEquals(
      $target->name,
      $res->data->skyscraper->list[0]->name,
      'Retrieves the correct name.'
    );
    assertEquals(
      $target->url,
      $res->data->skyscraper->list[0]->url,
      'Retrieves the correct url.'
    );
  }
}