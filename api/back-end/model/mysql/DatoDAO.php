<?php
require_once(__DIR__ . '/../dao/IDatoDAO.php');

class DatoDAO implements IDatoDAO
{
    private static $table = 'datos';

    private static $selected_fields = array
    (
        'dato_id' => 'id',
        'UNIX_TIMESTAMP(dato_fecha)' => 'fecha', 
        'dato_presion' => 'presion', 
        'dato_humedad' => 'humedad', 
        'dato_temperatura' => 'temperatura', 
        'dato_temperatura_interna' => 'temperaturaInterna'
    );

	private static function getFieldsToInsert(Dato $dato)
	{
        $fields = array
		(
			'dato_fecha' => $dato->getFecha(), 
			'dato_presion' => $dato->getPresion(), 
			'dato_humedad' => $dato->getHumedad(), 
			'dato_temperatura' => $dato->getTemperatura(), 
			'dato_temperatura_interna' => $dato->getTemperaturaInterna()
        );

		return $fields;
    }
    
    private function setSubItems(&$row)
    {
        $riw = Helper::cast('Dato', $row);
    }

    public function selectAll()
    {
        $db = Repository::getDB();
        $results = $db->select(self::$table, self::$selected_fields);
        array_walk($results, array($this, 'setSubItems'));
        return $results;
    }

    public function selectById($id)
    {
        $db = Repository::getDB();
        $fields = self::$selected_fields;
        $where = 'dato_id = :id';
        $replacements = array('id' => $id);
        $results = $db->select(self::$table, $fields, $where, $replacements);
        if(sizeof($results) == 1) { $this->setSubItems($results[0]); return $results[0]; }
        else { return NULL; }
    }

    public function selectAfterOf($id)
    {
        $db = Repository::getDB();
        $where = 'dato_id > :id';
        $replacements = array('id' => $id);
        $results = $db->select(self::$table, self::$selected_fields, $where, $replacements);
        array_walk($results, array($this, 'setSubItems'));
        return $results;
    }

    public function selectByRange($inicio, $fin)
    {
        $db = Repository::getDB();
        $where = 'UNIX_TIMESTAMP(dato_fecha) >= :inicio && UNIX_TIMESTAMP(dato_fecha) <= :fin';
        $replacements = array('inicio' => $inicio, 'fin' => $fin);
        $results = $db->select(self::$table, self::$selected_fields, $where, $replacements);
        array_walk($results, array($this, 'setSubItems'));
        return $results;
    }

    public function selectFiltered($filter)
    {
        $db = Repository::getDB();
        $where = 'dato_nombres LIKE :filter OR dato_apellidos LIKE :filter OR dato_documento LIKE :filter';
        $replacements = ['filter' => '%' . $filter . '%'];
        $results = $db->select(self::$table, self::$selected_fields, $where, $replacements);
        array_walk($results, array($this, 'setSubItems'));
        return $results;
    }

    // public function selectByDocumento($documento)
    // {
    //     $db = Repository::getDB();
    //     $where = 'dato_documento = :documento';
    //     $replacements = array('documento' => $documento);
    //     $results = $db->select(self::$table, self::$selected_fields, $where, $replacements);
    //     if(sizeof($results) == 1) { return $results[0]; }
    //     else { return NULL; }
    // }

    public function insert(Dato $dato)
    {
        $db = Repository::getDB();
        $data = self::getFieldsToInsert($dato);
        $db->insert(self::$table, $data);
        $dato->setId($db->getLastInsertId());
    }

    public function update(Dato $dato)
    {
        $db = Repository::getDB();
        $replacements = self::getFieldsToInsert($dato);
        $where = 'dato_id = :id';
        $data = array('id' => $dato->getId());
        $db->update(self::$table, $replacements, $where, $data);
    }

    public function delete($id)
    {
        $db = Repository::getDB();
        $where = 'dato_id = :id';
        $data = array('id' => $id);
        $db->delete(self::$table, $where, $data);
    }
}