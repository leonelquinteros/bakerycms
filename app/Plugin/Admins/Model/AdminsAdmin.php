<?php
class AdminsAdmin extends AdminsAppModel
{
    public $name = 'AdminsAdmin';
    public $recursive = -1;

    public $hasMany = array(
                        'AdminsAdminsRestriction' => array(
                                            'className' => 'AdminsAdminsRestriction',
                                            'foreignKey' => 'admins_admins_id',
                        )
    );


    public $validate = array(
                        'login' => array(
                                    'loginRequiredRule' => array(
                                            'rule' => 'alphaNumeric',
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    ),
                                    'loginUniqueRule' => array(
                                            'rule' => 'isUnique',
                                            'message' => 'Translate this',
                                    ),
                        ),
                        'pass' => array(
                                    'passwordRule' => array(
                                        'rule' => 'validateAdminPassword',
                                        'message' => 'Translate this',
                                    )
                        ),
                        'name' => array(
                                    'notEmpty' => array(
                                            'rule' => array('minLength', 1),
                                            'required' => true,
                                            'allowEmpty' => false,
                                            'message' => 'Translate this',
                                    ),
                        ),
    );


    /**
     * validateAdminPassword()
     * Custom validation method for Administrator's passwords.
     * If it's a new record, validates that password are not empty.
     *
     * @param (array) $check
     * @return (boolean)
     */
    public function validateAdminPassword($check)
    {
        // If it's a new record, this field is mandatory.
        if( empty($this->data['AdminsAdmin']['id']) )
        {
            return !empty( $check['pass'] );
        }
        else
        {
            return true;
        }
    }


    /**
     * beforeSave()
     * Converts passwords to SHA1 before save, or retrieves old password if empty.
     *
     * @see cake/libs/model/Model#beforeSave($options)
     */
    public function beforeSave($options = array())
    {
        if( !empty($this->data['AdminsAdmin']['pass']) )
        {
            $this->data['AdminsAdmin']['pass'] = sha1( $this->data['AdminsAdmin']['pass'] );
        }
        else
        {
            // We assume that this is not a new admin, because if the password is empty will not validate on validateAdminPassword().
            $oldAdmin = $this->findById($this->data['AdminsAdmin']['id']);

            $this->data['AdminsAdmin']['pass'] = $oldAdmin['AdminsAdmin']['pass'];
        }

        return true;
    }
}
