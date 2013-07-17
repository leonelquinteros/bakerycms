<?php
require_once dirname(__FILE__) . '/../TestHelper.php'; 

class AdminsTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		App::import('Model', 'Admins.AdminsAdmin');
		App::import('Model', 'Admins.AdminsAdminsRestriction');
		$admin = new AdminsAdmin();
		$admin->deleteAll('1 = 1');
	}
	
	public function testNonEmptyFieldsValidation()
	{
		App::import('Model', 'Admins.AdminsAdmin');
		$admin = new AdminsAdmin();
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = '';
		$adminData['AdminsAdmin']['pass'] = 'testNonEmptyFieldsValidation';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = 'leonel@deviget.com';
		
		$this->assertFalse($admin->save($adminData));
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testNonEmptyFieldsValidation';
		$adminData['AdminsAdmin']['pass'] = '';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = 'leonel@deviget.com';
		
		$this->assertFalse($admin->save($adminData));
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testNonEmptyFieldsValidation';
		$adminData['AdminsAdmin']['pass'] = 'testNonEmptyFieldsValidation';
		$adminData['AdminsAdmin']['name'] = '';
		$adminData['AdminsAdmin']['email'] = 'leonel@deviget.com';
		
		$this->assertFalse($admin->save($adminData));
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testNonEmptyFieldsValidation';
		$adminData['AdminsAdmin']['pass'] = 'testNonEmptyFieldsValidation';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = '';
		
		$this->assertFalse($admin->save($adminData));
	}
	
	public function testEmailValidation()
	{
		App::import('Model', 'Admins.AdminsAdmin');
		$admin = new AdminsAdmin();
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testEmailValidation';
		$adminData['AdminsAdmin']['pass'] = 'testEmailValidation';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = 'Not valid email adrress';
		
		$this->assertFalse($admin->save($adminData));
	}
	
	public function testLoginUniqueValidation()
	{
		App::import('Model', 'Admins.AdminsAdmin');
		$admin = new AdminsAdmin();
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testLoginUniqueValidation';
		$adminData['AdminsAdmin']['pass'] = 'testLoginUniqueValidation';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = 'leonel@deviget.com';
		
		$this->assertTrue( is_array( $admin->save($adminData) ) );
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testLoginUniqueValidation';
		$adminData['AdminsAdmin']['pass'] = 'testLoginUniqueValidation';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = 'leonel@deviget.com';
		
		$this->assertFalse($admin->save($adminData));
	}
	
	public function testPasswordEncription()
	{
		App::import('Model', 'Admins.AdminsAdmin');
		$admin = new AdminsAdmin();
		
		$adminData = $admin->create();
		$adminData['AdminsAdmin']['login'] = 'testPasswordEncription';
		$adminData['AdminsAdmin']['pass'] = 'testPasswordEncription';
		$adminData['AdminsAdmin']['name'] = 'Leonel';
		$adminData['AdminsAdmin']['email'] = 'leonel@deviget.com';
		
		$admin->save($adminData);
		
		$adminData = $admin->findById($admin->id);
		
		$this->assertEquals( sha1('testPasswordEncription'), $adminData['AdminsAdmin']['pass'] );
	}
	
}
