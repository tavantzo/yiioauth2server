<?php
/**
 * 
 * @param string $client_id
 * @param string $client_secret
 * @param string $redirect_url
 */
class OAuth2Client extends CActiveRecord {
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->client_secret = $this->generateClientSecret();
        }

        return parent::beforeSave();
    }

    public function tableName()
    {
        return 'oauth2_clients';
    }
    
    public function primaryKey()
    {
        
        return 'client_id';
    }
    
    public function behaviors()
    {
        return array(
        );
    }
    
    public function relations()
    {
        return array(
        );
    }
    
    public function rules()
    {
        return array(
            array('client_id, redirect_url', 'safe', 'insert'),
            array('client_id, client_secret, redirect_url', 'required'),
            array('client_id, client_secret', 'length', 'max'=>80),
            array('redirect_url', 'length', 'max'=>2000),
        );

    }
    
    /**
     * Creates oauth2 client credentials for the given client_id
     * @return OAuth2Client Return the newly create record or null if it failed
     */
    public function addClient($client_id)
    {
        $model = new static('insert');
        $model->attributes = array('client_id'=>$client_id, 'redirect_url'=>$redirect_url);
        if ($model->save()) {
            return $model;
        }

        return null;
    }
    
    /**
     * Generates a hash to be uses as the clienT secret
     * 
     * @return string
     */
    protected function generateClientSecret()
    {
        return password_hash(uniqid(), PASSWORD_BCRYPT);
    }
}