<?php

interface IDatoDAO
{
	public function selectAll();
	public function selectById($id);
	public function selectFiltered($filter);
	public function insert(Dato $dato);
	public function update(Dato $dato);
	public function delete($id);
}
