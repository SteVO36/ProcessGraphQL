<?php namespace ProcessWire\GraphQL\Test\Permissions;

use ProcessWire\GraphQL\Test\GraphqlTestCase;
use ProcessWire\GraphQL\Utils;

class EditorCreateAllowedOnlyOneTest extends GraphqlTestCase {

  /**
   * + The template can have only one Page.
   */
  public static function getSettings()
  {
    $editorRole = Utils::roles()->get('editor');
    return [
      'login' => 'editor',
      'legalTemplates' => ['home', 'search'],
      'legalFields' => ['title'],
      'access' => [
        'templates' => [
          [
            'name' => 'search',
            'noParents' => -1,
            'roles' => [$editorRole->id],
            'editRoles' => [$editorRole->id],
            'createRoles' => [$editorRole->id],
          ],
          [
            'name' => 'home',
            'roles' => [$editorRole->id],
            'addRoles' => [$editorRole->id],
          ]
        ],
        'fields' => [
          [
            'name' => 'title',
            'viewRoles' => [$editorRole->id],
            'editRoles' => [$editorRole->id],
          ]
        ]
      ]
    ];
  }

  /**
   * Delete the single search page so we can create it again.
   */
  public static function setUpBeforeClass()
  {
    $searchPage = Utils::pages()->get("template=search");
    $searchPage->delete();
    parent::setUpBeforeClass();
  }

  public function testPermission() {
    $query = 'mutation createPage($page: SearchCreateInput!) {
      createSearch(page: $page) {
        id
        name
        title
        template
      }
    }';

    $variables = [
      'page' => [
        'parent' => 1,
        'name' => 'search',
        'title' => 'Search'
      ]
    ];

    $res = self::execute($query, $variables);
    assertEquals('search', $res->data->createSearch->name, 'Should allow to create a page with OnlyOne checked if there is not already a page with that template.');
    assertEquals('Search', $res->data->createSearch->title);
    $search = Utils::pages()->get("name=search, template=search");
    assertEquals($search->id, $res->data->createSearch->id);
  }
}