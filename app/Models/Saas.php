<?php

namespace jamx\Models;

use Eloquent;
use DB;

/**
 * 
 * 
 *
 * @author king <king@jinsec.com>
 */
class Saas extends Eloquent
{
	public function table(){
		$table = $this->table;
		return $table;
	}
	public function mn(){
		$table = $this->table;
		$mn = substr($table,5);
		return $mn;
	}
   
	
	
}
