<?php

namespace App\Form\DataTransformer;

use DateTime;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTransformer implements DataTransformerInterface {
   
   
   public function transform($date) {

      $format = gettype($date);

      if ($format == "string") {
         $format_date = 'Y-m-d H:i:s';
         $new_date = DateTime::createFromFormat($format_date, $date);

         
         return $new_date->format('d/m/Y');
      }

      if($date === null){
         return '';
      }


      return $date->format('d/m/Y');

   }

   public function reverseTransform($date) {
      // date = 11/08/2018
      if($date === null){
         //Exception
         throw new TransformationFailedException('Vous devez fournir une date');
      }

      $convertDate = \DateTime::createFromFormat('d/m/Y', $date);
     
     
      if($convertDate === false){
         //Exception
         throw new TransformationFailedException('Le format n est pas bon');

      }

      return $convertDate;
   }
}
