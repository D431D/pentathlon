<?php
class Matricula extends Eloquent{
	public $timestamps = false;

	public function elemento(){
		return $this->belongsTo('Elemento');
	}
}