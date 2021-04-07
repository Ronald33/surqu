<?php
abstract class DatoHelper
{
    public static function castToDato($object)
    {
        $response = Repository::getResponse();
        $result = DatoValidator::validate($object);
        
        if($result === true)
        {
            $dato = Helper::cast('Dato', $object);
            return $dato;
        }
        else { $response->s400($result); }
    }
}