<?php

namespace App\Anatomy\traits\mappings;
//a trait for age mappings used mostly in anatomy.
trait age_mappings
{
    public function age_mappings($age)
	{
		switch ($age) 
		{
			case '0-1':
				return '0-1';
				break;

			case '1-17':
				return '1-17';
				break;	
			
			default:
				return '18-24';
				break;
		}
	}
}
