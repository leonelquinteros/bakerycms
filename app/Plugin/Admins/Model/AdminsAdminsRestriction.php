<?php
class AdminsAdminsRestriction extends AdminsAppModel
{
	public $name = 'AdminsAdminsRestriction';
	public $recursive = -1;
	
	public $belongsTo = array (
							'AdminsAdmin' => array(
											'className' => 'AdminsAdmin',
											'foreignKey' => 'admins_admins_id',
							)
	);
	
	public $validate = array(
						'admins_admins_id' => array(
									'notEmptyRule' => array(
											'rule' => 'notEmpty',
											'required' => true,
											'allowEmpty' => false,
											'message' => 'Translate this',
									)
						),
						'plugin' => array(
									'notEmptyRule' => array(
											'rule' => 'notEmpty',
											'required' => true,
											'allowEmpty' => false,
											'message' => 'Translate this',
									)
						),
						'action' => array(
									'notEmptyRule' => array(
											'rule' => 'notEmpty',
											'required' => true,
											'allowEmpty' => false,
											'message' => 'Translate this',
									),
						),
	);
	
}
