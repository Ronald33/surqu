<?php
abstract class DatoHelper
{
    public static function castToDato()
    {
        $response = Repository::getResponse();
        $result = DatoValidator::validate();
        
        if($result === true)
        {
            $dato = Helper::cast('Dato', (object) $_GET);
            $dato->setFecha(Helper::getCurrentTimestamp());
            return $dato;
        }
        else { $response->s400($result); }
    }
}