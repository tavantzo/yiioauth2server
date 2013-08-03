<?php
class PdoStorage extends DbStorageAbstract {

    /**
     * @var string a component ID for a CDbConnection. If this set the dsn options will be ignored.
     **/
    public $dbConnectionId = null;

    /**
     * A custom dsn connection string @see CDbConnection::$connectionString
     * @var string
     */
    public $dsn;

    /**
     * The username if the dsn needs any
     * @var string
     */
    public $username = null;

    /**
     * The username if the dsn needs any
     * @var string
     */
    public $password = null;

    /**
     * Returns a valid configuration for an OAuth2_Storage_Pdo
     * @return mixed
     **/
    public function getConfig()
    {
        if ($this->dbConnectionId !== null) {
            // Just return the PDO instance
            return Yii::app()->getComponent($this->db)->pdoInstance;
        }

        // Return the connection configuration;
        return array(
            'dsn'=>$this->dsn,
            'username'=>$this->username,
            'password'=>$this->password
        );
    }

    /**
     * Return the class name of the assosiated Oauth2_Storage class
     * @return string
     */
    public function storageClass()
    {
        return 'OAuth2_Storage_Pdo';
    }
}
