<?php
abstract class PersonaHelper
{
    public static function castToPersona($object)
    {
        $response = Repository::getResponse();
        $result = PersonaValidator::validate($object);
        
        if($result === true)
        {
            $Persona = Helper::cast('Persona', $object);
            return $Persona;
        }
        else { $response->s400($result); }
    }
}