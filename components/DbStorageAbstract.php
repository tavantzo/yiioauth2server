<?php

abstract class DbStorageAbstract extends CComponent
{
    /**
     * It should return the necessary connection configuration
     * fir a OAuth2_Storage class
     */
    abstract public function getConfig();
    /**
     * It should return the class name of the associated storage.
     * ie: OAuth2_Starage_Pdo
     *
     * @return string
     */
    abstract public function storageClass();

    /**
     * Default storage options
     */
    public $options = array(
        'client_table'          => 'oauth_clients',
        'access_token_table'    => 'oauth_access_tokens',
        'refresh_token_table'   => 'oauth_refresh_tokens',
        'code_table'            => 'oauth_authorization_codes',
        'user_table'            => 'oauth_users',
        'jwt_table'             => 'oauth_jwt',
    );

    /**
     * Return a OAuth2_Storage instance
     * @return OAuth2_Storage_AuthorizationCodeInterface
     *  |OAuth2_Storage_AccessTokenInterface|OAuth2_Storage_ClientCredentialsInterface,
     *   |OAuth2_Storage_UserCredentialsInterface,
     *   |OAuth2_Storage_RefreshTokenInterface,
     *   |OAuth2_Storage_JWTBearerInterface
     */
    public function getOauth2Storage()
    {
        $className = $this->storageClass();
        // Create and return the Oauth2_Storage object
        $storage = new $className($this->getConfig(), $this->options);
        CVarDumper::dump($storage, 10, 1);
        return $storage;
    }
}