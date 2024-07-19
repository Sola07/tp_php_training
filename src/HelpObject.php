<?php

namespace App;

class HelpObject {

  public static function hydrate ($data, array $postURL, array $values)
  {
    foreach ($values as $value)
    {
      $method = self::getMethod($value);
      $data->$method($postURL[$value]);
    }

  }

  private static function getMethod (string $value): string
  {
    return 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));

    }
 }
