<?php
abstract class PersonaValidator
{
    public static function validate()
    {
        $validator = Repository::getValidator();
        $validator->addInputFromArray('Presión', $_GET, 'presion')->addRule('isFloat');
        $validator->addInputFromArray('Humedad', $_GET, 'humedad')->addRule('isFloat');
        $validator->addInputFromArray('Temperatura', $_GET, 'temperatura')->addRule('isFloat');
        $validator->addInputFromArray('Temperatura interna', $_GET, 'temperaturaInterna')->addRule('isFloat');
        
        if($validator->isValid()) { return true; }
        else { return $validator->getInputsWithErrors(); }
    }
}
