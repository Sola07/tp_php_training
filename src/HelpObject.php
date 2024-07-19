<?php

namespace App;

class HelpObject {

  public static function hydrate ($object, array $data, array $fields): void
  {
    foreach ($fields as $field)
    {
      $method = self::getMethod($field);
      $object->$method($data[$field]);
    }

  }

  private static function getMethod (string $field): string
  {
    return 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));

    }
 }
