<?php

namespace App\Service;

use Twig\Environment;
use \Gumlet\ImageResize;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;


class Utility
{

   private $request;

   public function __construct(RequestStack $request)
   {
      $this->request = $request;
   }

   /**
    * Returns a random pseudo character string of variable size
    *
    * @param  [int] $length [Longueur souhaitée]
    * @return [string] [chaine de caracteres pseudo aleatoire]
    */
   public function randomString($length)
   {
      $string = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
      return substr(str_shuffle(str_repeat($string, $length)), 0, $length);
   }

   /**
    * Check controller matching
    * @return boolean
    */
   public function matchController($match)
   {

      list($path, $action) = explode('::', $this->request->getCurrentRequest()->attributes->get('_controller'));
      $paths = explode('\\', $path);
      $controller = end($paths);

      if ($controller == $match) {
         return true;
      }
      return false;
   }

   /**
    * Get formated media
    * @return string
    */
   public function getFormatedMedia($format, $media)
   {
      $formats = ['small', 'medium', 'large'];
      if (in_array($format, $formats)) {
         $media = str_replace('.', '_' . $format . '.', $media);
      }
      return $media;
   }

   /**
    * Check if format exist
    * @return string
    */
   public function formatExist($format)
   {
      $formats = ['small', 'medium', 'large'];
      if (in_array($format, $formats)) {
         return true;
      }
      return false;
   }

   /**
    * Check presence keys in data
    * @param Array $data
    * @param Array $keys
    * @return Boolean $exist
    */
   public function existKeys($data, $keys)
   {
      foreach ($keys as $key) {
         if (!isset($data[$key])) {
            return false;
         }
      }
      return true;
   }

   public function responseJsonSuccess($data)
   {
      return [
         'status' => 'success',
         'data' => $data
      ];
   }

   public function responseJsonError($message)
   {
      return [
         'status' => 'error',
         'message' => $message,
         'data' => []
      ];
   }

   /**
    * Check content array $_POST
    * @return
    */
   public function keyExist($request_post, $array)
   {

      // -> Initialize array data empty
      $data = [];

      // -> Verify if $array is an array
      if (is_array($array)) {

         // -> Check each item
         foreach ($array as $key => $value) {

            // -> Check if key exist in array
            if (isset($key) && array_key_exists($key, $request_post)) {

               // -> Check if value is an array
               if (is_array($value)) {

                  // -> Check each value
                  foreach ($value as $item) {

                     // -> Verify if item exists in array from $request_post
                     if (isset($item) && array_key_exists($item, $request_post[$key])) {
                        // -> Set in data
                        $data[$item] = $request_post[$key][$item];
                     } else {
                        // -> If not exist
                        return false;
                     }
                  }
               } else {
                  // -> Set in data
                  $data[$key] = $value;
               }
            } else {
               // -> If not exist
               return false;
            }
         }
      } else {
         // -> If not exist
         return false;
      }

      // -> Return $data array
      return $data;
   }


   /**
    * Check if we have min params in array
    *
    */
   public function minLengthArrayRequire($array, $length)
   {
      while (count($array) < $length) {
         $array[] = false;
      }
      return $array;
   }

   /**
    * Check action matching
    * @return boolean
    */
   public function matchAction($match)
   {

      $param = explode('::', $this->request->getCurrentRequest()->attributes->get('_controller'));

      list($path, $action) = $this->minLengthArrayRequire($param, 2);

      if ($action == $match) {
         return true;
      }
      return false;
   }

   /**
    * Exist in
    * @param Array $data
    * @param Array $values
    * @return Boolean
    */
   public static function existIn($data, $values)
   {
      foreach ($values as $key => $value) {
         if (!isset($data[$value])) {
            return false;
         }
      }
      return true;
   }

   public function getAllTimeZones()
   {
      $timezones = [
         "Africa/Abidjan",
         "Africa/Algiers",
         "Africa/Cairo",
         "Africa/Casablanca",
         "Africa/Johannesburg",
         "Africa/Lagos",
         "Africa/Maputo",
         "Africa/Nairobi",
         "America/Adak",
         "America/Anchorage",
         "America/Campo_Grande",
         "America/Chicago",
         "America/Chihuahua",
         "America/Denver",
         "America/Fortaleza",
         "America/Godthab",
         "America/Halifax",
         "America/Havana",
         "America/La_Paz",
         "America/Lima",
         "America/Los_Angeles",
         "America/Managua",
         "America/Mexico_City",
         "America/New_York",
         "America/Noronha",
         "America/Panama",
         "America/Phoenix",
         "America/Santiago",
         "America/Santo_Domingo",
         "America/Sao_Paulo",
         "America/St_Johns",
         "America/Whitehorse",
         "Antarctica/Palmer",
         "Asia/Baghdad",
         "Asia/Bangkok",
         "Asia/Dhaka",
         "Asia/Dubai",
         "Asia/Gaza",
         "Asia/Hong_Kong",
         "Asia/Jakarta",
         "Asia/Jerusalem",
         "Asia/Kamchatka",
         "Asia/Kathmandu",
         "Asia/Kolkata",
         "Asia/Kuala_Lumpur",
         "Asia/Makassar",
         "Asia/Rangoon",
         "Asia/Seoul",
         "Asia/Shanghai",
         "Asia/Tashkent",
         "Asia/Tehran",
         "Asia/Tokyo",
         "Asia/Ulaanbaatar",
         "Asia/Vladivostok",
         "Asia/Yakutsk",
         "Atlantic/Azores",
         "Atlantic/Cape_Verde",
         "Australia/Adelaide",
         "Australia/Brisbane",
         "Australia/Darwin",
         "Australia/Lord_Howe",
         "Australia/Perth",
         "Australia/Sydney",
         "Etc/UTC",
         "Europe/Athens",
         "Europe/Chisinau",
         "Europe/Dublin",
         "Europe/Istanbul",
         "Europe/Lisbon",
         "Europe/London",
         "Europe/Moscow",
         "Europe/Paris",
         "Europe/Ulyanovsk",
         "Pacific/Auckland",
         "Pacific/Bougainville",
         "Pacific/Chatham",
         "Pacific/Easter",
         "Pacific/Fakaofo",
         "Pacific/Galapagos",
         "Pacific/Gambier",
         "Pacific/Guam",
         "Pacific/Honolulu",
         "Pacific/Kiritimati",
         "Pacific/Niue",
         "Pacific/Pago_Pago",
         "Pacific/Pitcairn",
         "Pacific/Tahiti",
      ];

      return $timezones;
   }



   /**
    * Render type of entities translated
    * For algolia autocomplete
    * @return
    */
   public function getCategoriesTranslated($locale)
   {

      $array = [

         'fr' => [
            'event' => 'Evénements',
            'article' => 'Articles',
            'group' => 'Groupes',
            'house' => 'Maisons',
            'other' => 'Partenaires',
            'user' => 'Utilisateurs'
         ],
         'en' => [
            'event' => 'Events',
            'article' => 'Articles',
            'group' => 'Groups',
            'house' => 'Houses',
            'other' => 'Partners',
            'user' => 'Users'
         ]

      ];

      return $array[$locale];
   }
}
