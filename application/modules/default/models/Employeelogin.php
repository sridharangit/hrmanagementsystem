<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_Model_Employeelogin extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_emplogin';
    protected $_primary = 'id';

    public function getTodayEmpCheck($empid)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
        $c_date = date('Y-m-d');
		$sql = "select id,c_date,login_id,check_in,check_out,isactive from main_emplogin where login_id = $empid and c_date = '".$c_date."' and isactive = 1";
		$res = $db->query($sql);
		$res = $res->fetchAll();
		return $res;
	}

	public function SaveorUpdateEmployeelogin($data, $where)
	{
		if($where != ''){
			$this->update($data, $where);
			return 'update';
		} else {
			$this->insert($data);
			$id=$this->getAdapter()->lastInsertId('main_emplogin');
			return $id;
		}
	}

	public function getlastEmpCheckout($empid)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
        $c_date = date('Y-m-d');
		$sql = "select id,c_date,login_id,check_in,check_out,isactive from main_emplogin where login_id = $empid  and c_date != '".$c_date."' and isactive = 1 order by id desc limit 0,1";
		$res = $db->query($sql);
		$res = $res->fetchAll();
		return $res;
	}
}