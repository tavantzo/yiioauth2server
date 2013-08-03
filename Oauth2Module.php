<?php

class Oauth2Module extends CWebModule {

    /**
     * The component Identifier for the web user.
     * @stirng
     */
    public $userComponentId = 'user';

    protected $_serverOptions = array(
        'access_lifetime'          => 3600,
        'www_realm'                => 'Service',
        'token_param_name'         => 'access_token',
        'token_bearer_header_name' => 'Bearer',
        'enforce_state'            => true,
        'require_exact_redirect_uri' => true,
        'allow_implicit'           => false,
    );

    protected $_grantTypes = array();
    protected $_storage = array('class'=>'PdoStorage',
        'dbConnectionId'=>'db',
        'options'=>array()
    );

    protected $_server = null;

    public function init()
    {
        if (!class_exists("OAuth2_Server"))
            throw new CException("Cannot find OAuth2 package. Please ckeck your vendors.");

        // Set module's import paths
        $this->setImport(array(
            'oauth2.*',
            'oauth2.models.*',
            'oauth2.components.*'
        ));
    }

    public function getServer($refresh=true)
    {
        if ($this->_server===null || $refresh) {
            $storage = $this->getStorage();
            $config = $this->_serverOptions;
            $this->_server = new OAuth2_Server($storage, $config);
        }

        return $this->_server;
    }

    public function setServerOptions($options)
    {
        $this->_serverOptions = array_merge($this->_serverOptions, $options);
        return $this;
    }

    public function setStorage($conf)
    {
        $this->_storage = $conf;
        return $this;
    }

    public function getStorage()
    {
        return Yii::createComponent($this->_storage)->oauth2Storage;
    }

    /**
     * Return the associated web user instance.
     * @return CWebUser
     */
    public function getWebUser()
    {
        return Yii::app()->getComponent($this->userComponentId);
    }
}