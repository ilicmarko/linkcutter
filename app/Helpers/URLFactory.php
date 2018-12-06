<?php

namespace App\Helpers;

use App\Links;

class URLFactory {
  const SALT = 'WeAreNeopix';

  /**
   * Remove a tailing slash, therefore google.com === google.com/
   */
  private static function URLCleaner($url) {
    $new_url = trim($url);
    $new_url = rtrim($new_url, '/');
    return $new_url;
  }

  /**
   * Generates a hash from a URL.
   * Number of combinations: 10^8
   */

  private static function generateHash($url, $random = null) {
    return substr(hash('sha512', $url . self::SALT . $random), 0, rand(3, 6));
  }

  private static function generateUniqueHash($url) {
    $code = self::generateHash($url);

    /* @NOTE
      `random_int()` was not used because it is significantly slower.
      Plus there is no need for a CSPRNG.
    */
    
    while (self::checkForHashCollision($code)) {
      $code = self::generateHash($url, rand());
    }

    return $code;
  }

  private static function checkForHashCollision($hash) {
    return Links::where('hash', '=', $hash)->exists();
  }

  public static function encode($url, $tracked) {
    $clean_url = self::URLCleaner($url);
    $add_to_db = false;

    // If the URL is going to be tracked it needs to be unique.
    if ($tracked === true) {
      $code = self::generateUniqueHash($clean_url);
      $add_to_db = true;
    } else {
      // If it's not tracked check if the URL is already in the DB.
      $in_db = Links::where('link', '=', $clean_url)->first();
      if ($in_db !== null) {
        if ($in_db->tracked) {
          $code = self::generateUniqueHash($clean_url);
          $add_to_db = true;
        } else {
          // @TODO Check if the hash is empty for some reason
          $code = $in_db->hash;
        }
      } else {
        $code = self::generateUniqueHash($clean_url);
        $add_to_db = true;
      }
    }

    return [
      'url'           => url('/r/' . $code),
      'clean_origin'  => $clean_url,
      'code'          => $code,
      'add_to_db'     => $add_to_db,
    ];
  }

  public static function decode($code) {
    $in_db = Links::where('hash', '=', $code)->first();
    $response = [];

    if ($in_db !== null) {
      $response = [
        'url'       => $in_db->link,
        'tracked'   => $in_db->tracked,
        'id'        => $in_db->id
      ];
    } else {
      $response = null;
    }

    return $response;
  }
}

