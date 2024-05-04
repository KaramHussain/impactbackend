<?php

namespace App\Anatomy\traits\mappings;

trait part_mappings
{

    public function part_mappings()
	{
		$mappings = array (

			'shoulder'   => ['Shoulder'],
			'elbow'	     => ['Elbow'],
			'wrist'	     => ['Wrist'],
			'hand'  	 => ['Hand'],
			'forearm'	 => ['Fore Arm'],
			'arm'		 => ['Arms'],
			'neck'	     => ['Neck'],
			'ear'		 => ['Ear'],
			'head' 	     =>	['Head'],
			'mouth'	     => ['Mouth'],
			'eye'		 => ['Eyes'],
			'nose'	     => ['Nose'],
			'chest'      => ['Chest'],
			'abdomen'    => ['Abdomen'],
			'pelvis'	 => ['Pelvis'],
			'pubis'	     => ['Genitals'],
			'buttocks'   => ['Buttock', 'Hip'],
			'thigh'	     => ['Thigh'],
			'knee'	     => ['Knee'],
			'leg'	     => ['Shin'],
			'ankle'	     => ['Ankle'],
			'foot'	     => ['Foot'],
			'sole'	     => ['Sole'],
			'calf'	     => ['Calf'],
			'back_knee'  => ['Back Knee'],
			'hamstring'  => ['Hamstring'],
			'back'	     => ['Back'],
			'loin'       => ['Loin'],
            'breasts'    => ['Chest'],
            'skin'       => ['Skin'],
            'veins'      => ['Veins'],
            'muscles'    => ['Muscles'],
            'bones'      => ['Bones']
		);

		return $mappings;
	}

}
