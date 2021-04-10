<?php
class DatoController
{
	private $dao;
	private $view;

	public function __construct()
	{
		$this->dao = new DatoDAO();
		$this->view = Repository::getResponse();
    }

    public function get($id = null)
    {
        if($id)
        {
            $result = $this->dao->selectById($id);
            if($result == NULL) { $this->view->s404(); }
            else { $this->view->s200($result); }
        }
        else if(isset($_GET['presion']) && isset($_GET['humedad']) && isset($_GET['temperatura']) && isset($_GET['temperaturaInterna']))
        {
            $dato = DatoHelper::castToDato();
            $this->dao->insert($dato);
            $this->view->s201($dato);
        }
        else if(isset($_GET['inicio']) && isset($_GET['fin']) && isset($_GET['seleccionados']))
        {
            $seleccionados = explode(',', $_GET['seleccionados']);

            $datos = $this->dao->selectByRange($_GET['inicio'], $_GET['fin']);
            $csv = [];
            
            $header = ['Fecha'];
            if(in_array('presion', $seleccionados)) { array_push($header, 'Presión'); }
            if(in_array('humedad', $seleccionados)) { array_push($header, 'Humedad'); }
            if(in_array('temperatura', $seleccionados)) { array_push($header, 'Temperatura'); }
            if(in_array('temperaturaInterna', $seleccionados)) { array_push($header, 'Temperatura Interna'); }

            array_push($csv, $header);

            foreach($datos as $dato)
            {
                $line = [date('d/m/Y h:i:s', $dato->fecha)];
                if(in_array('presion', $seleccionados)) { array_push($line, $dato->presion); }
                if(in_array('humedad', $seleccionados)) { array_push($line, $dato->humedad); }
                if(in_array('temperatura', $seleccionados)) { array_push($line, $dato->temperatura); }
                if(in_array('temperaturaInterna', $seleccionados)) { array_push($line, $dato->temperaturaInterna); }

                array_push($csv, $line);
            }

            Helper::setHeaderDownload('milei.csv');
            echo Helper::array2csv($csv);
        }
        else if(isset($_GET['id'])) { $this->view->s200($this->dao->selectAfterOf($_GET['id'])); }
        else { $this->view->s200($this->dao->selectAll()); }
    }

    public function post()
    {
        
    }

    public function put($id = null)
    {
        if($id == null) { $this->view->s501(); }
        else
        {
            $object = Helper::getBodyRequest();
            $dato = DatoHelper::castToDato($object);
            $dato->setId($id);
            $this->dao->update($dato);
            $this->view->s201($dato);
        }
    }
    
    public function delete($id = null)
    {
        if($id == null) { $this->view->s501(); }
        else { $this->dao->delete($id); $this->view->s200(); }
    }

    public function options()
    {
        $rest = Repository::getRest();
        header('Access-Control-Allow-Methods: ' . $rest->getAllowedMethodsFromClass(__CLASS__));
    }
}
