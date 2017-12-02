<?php
namespace System\Libs\Database\QueryBuilder;

class MySQLQueryBuilder extends QueryBuilder
{
	
	static $operators = array(
		'=' => '=',
		'<>' => '<>',
		'<' => '<',
		'>' => '>',
		'<=' => '<=',
		'>=' => '>=',
		'?'  => '?'
	);
	
	protected function buildSelect()
	{
		if(count($this->_select) == 0)
			return 'SELECT *';

		$selects = (count($this->_select)>1)?call_user_func_array('array_merge', $this->_select): $this->_select[0];
		
		return 'SELECT '.implode(' ,',$selects);

		
	}
	
	protected function buildFrom()
	{
		if(count($this->_from) == 0)
			return '';

		$from = (count($this->_from)>1)?call_user_func_array('array_merge', $this->_from): $this->_from[0];
		
		return ' FROM '.implode(' ,',$from);

		
	}

	protected function buildJoin()
	{
		if(count($this->_join) == 0)
			return '';

		$joins ='';

		foreach ($this->_join as $join)
		{
			$joins.=' '.$join[2].' JOIN '.$join[0].' ON ('.strtr($join[1], static::$operators).')';
		}

		return $joins;

	}
	
	protected function buildWhere()
	{
		if(count($this->_where) == 0)
			return '';

		$where ='';

		foreach ($this->_where as $conditions)
		{
			$where.= ' '.$conditions[2];
			foreach($conditions[0] as $key=>$value)
			{
				$where.= ' '.$key.$value.' '.$conditions[1];
			}
			
			$l = strlen(' '.$conditions[1]);
			$where = substr_replace($where, '', -$l, $l );
			
		}
		
		$this->_whereFlag = true;
		if($where != '')
			$where = substr_replace($where, ' WHERE', 0, strlen(' '.$this->_where[0][2]) );
		
		return strtr($where, static::$operators);

	}

	protected function buildIn()
	{
		if(count($this->_in) == 0)
			return '';

		$in ='';

		foreach ($this->_in as $values)
		{
			$in.=' '.$values[2].' '.$values[0].' IN ('.implode(',', $values[1]).')';
		}

		if(! $this->_whereFlag)
		{
			$in = substr_replace($in, ' WHERE ', 0, strlen(' '.$this->_in[0][2])); 
		}

		$this->_inFlag = true;
		return $in;

	}

	protected function buildNotIn()
	{
		if(count($this->_notIn) == 0)
			return '';

		$notIn ='';

		foreach ($this->_notIn as $values)
		{
			$notIn.=' '.$values[2].' '.$values[0].' NOT IN ('.implode(',', $values[1]).')';
		}

		if(! $this->_whereFlag and ! $this->_inFlag)
		{
			$notIn = substr_replace($notIn, ' WHERE ', 0, strlen(' '.$this->_notIn[0][2]));
		}

		return $notIn;

	}

	protected function buildOrderBy()
	{
		if(count($this->_orderBy) == 0)
			return '';

		return ' ORDER BY '.implode(',', $this->_orderBy[0]).' '.$this->_orderBy[1];

	}

	protected function buildGroupBy()
	{
		if(count($this->_groupBy) == 0)
			return '';

		return ' GROUP BY '.implode(',', $this->_groupBy[0]);

	}	
	
	protected function buildHaving()
	{
		if(count($this->_having) == 0)
			return '';

		$having ='';

		foreach ($this->_having as $conditions)
		{
			$having.= ' '.$conditions[2];
			foreach($conditions[0] as $key=>$value)
			{
				$having.= ' '.$key.$value.' '.$conditions[1];
			}
			
			$l = strlen(' '.$conditions[1]);
			$having = substr_replace($having, '', -$l, $l );

		}
		
		if($having != '')
			$having = substr_replace($where, ' HAVING', 0, strlen(' '.$this->_having[0][2]) );

		return strtr($having, static::$operators);

	}

	public function buildLimit()
	{
		if($this->_limit == null)
			return '';

		$limit = 'LIMIT ';

		return $this->_offset != null? $limit.$this->_offset.', '.$this->_limit: $limit.$this->_limit;
	}

	public function buildInsert()
	{
		if(count($this->_insert) == 0)
			return '';

		$insert = 'INSERT INTO '.$this->_insert[0];
		if(isset($_insert[1]))
			$insert.='('.implode(',',$this->_insert[1]).')';
			
		return $insert;
		
		/*
		foreach($this->_insert as $values)
		{
			$insert .= 'INSERT INTO '.$values[0].
			'('.implode(',', array_keys($values[1])).') VALUES('.
			implode(',', array_values($values[1])).');';

		}

		return $insert;
		*/
	}
	
	public function buildValues()
	{
		$vals = ' VALUES ';
		foreach($this->_values as $values)
		{
			$vals.='('.implode(', ',$values).'), ';
		}
		return substr_replace($vals,';',-2,2);
	}

	public function buildUpdate()
	{

		if(count($this->_update) == 0)
			return '';

		$update = '';
		$update.=' UPDATE '.$this->_update[0];//.' SET ';
			return $update;
		/*
		$l =strlen(', ');

		foreach ($this->_update as $values)
		{

			$update.=' UPDATE '.$values[0];//.' SET ';
			return $update;
			/*
			foreach($values[1] as $field=>$value)
			{
				$update.=$field.'='.$value.', ';
			}

			$update = substr_replace($update,' ',-2, 2);

			if(count($values[2]))
			{
				$update.=' WHERE';
				$operation = $values[3];

				if(isset($values[2][1]))
					$operation = $values[2][1];
				
				foreach($values[2] as $key=>$value)
				{
					$update.=' '.$key.$value.' '.$operation;
				}
				$strl = strlen(' '.$operation); 
				$update = substr_replace($update,'',-strl, strl);

			}

			$update.=';';

		}
		return strtr($update, static::$operators);
		*/

	}
	
	public function buildSet()
	{
		$vals = ' SET ';
		foreach($this->_set as $key=>$value)
		{
			$vals.=$key.'='.$value.', ';
		}
		
		return substr_replace($vals,'',-2,2);
	}

	public function buildDelete()
	{
		if(count($this->_delete) == 0)
			return '';
		
		$delete = 'DELETE FROM '.$this->_delete[0];

		return $delete;
		/*
		foreach ($this->_delete as $values)
		{
			$delete.=' DELETE FROM '.$values[0];
			
			if(count($values[1]))
			{
				$delete.=' WHERE';
				
				foreach($values[1] as $key=>$value)
				{
					$delete.= ' '.$key.$value.' '.$values[1];
				}
				$strl =strlen(' '.$values[1]);
				$delete = substr_replace($delete,'', -strl,strl);

			}

			$delete.=';';

		}

		return strtr($delete, static::$operators);
		*/

	}
	
	protected function buildQuery()
	{
		switch ($this->_queryFlag)
		{
			case 'select':
				$this->_query =
				$this->buildSelect()
				.' '.$this->buildFrom()
				.' '.$this->buildJoin()
				.' '.$this->buildWhere()
				.' '.$this->buildIn()
				.' '.$this->buildNotIn()
				.' '.$this->buildGroupBy()
				.' '.$this->buildHaving()
				.' '.$this->buildOrderBy()
				.' '.$this->buildLimit()
				.';';
				break;

			case 'insert':
				$this->_query =
				$this->buildInsert()
				.' '.$this->buildValues();
				break;
			
			case 'update':
				$this->_query =
				$this->buildUpdate()
				.' '.$this->buildSet()
				.' '.$this->buildWhere();
				break;;
			
			case 'delete':
				$this->_query =
				$this->buildDelete()
				.' '.$this->buildWhere();
				break;
			
			default:
				$this->_query = '';
				break;
		}

	}
	
}