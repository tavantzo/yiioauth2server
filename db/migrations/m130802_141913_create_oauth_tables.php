<?php

class m130802_141913_create_oauth_tables extends EDbMigration
{
	public function up()
	{
        switch(strtolower($this->dbConnection->driverName))
        {
            case 'oracle':
                $this->oracle_up();
            break;
            default:
                $this->common_up();
        }
	}

	public function down()
	{
        $this->dropTable('oauth_clients');
        $this->dropTable('oauth_access_tokens');
        $this->dropTable('oauth_authorization_codes');
        $this->dropTable('oauth_refresh_tokens');
        $this->dropTable('oauth_users');
		return true;
	}

    /**
     * MySQL / SQLite / PostgreSQL / MS SQL Server
     */
    private function common_up()
    {
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_clients ( client_id VARCHAR(80) NOT NULL, client_secret VARCHAR(80) NOT NULL, redirect_uri VARCHAR(2000)  NOT NULL, CONSTRAINT client_id_pk PRIMARY KEY (client_id));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_access_tokens (access_token VARCHAR(40) NOT NULL, client_id VARCHAR(80) NOT NULL, user_id VARCHAR(255), expires TIMESTAMP NOT NULL,scope VARCHAR(2000), CONSTRAINT access_token_pk PRIMARY KEY (access_token));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_authorization_codes (authorization_code VARCHAR(40) NOT NULL, client_id VARCHAR(80) NOT NULL, user_id VARCHAR(255), redirect_uri VARCHAR(2000) NOT NULL, expires TIMESTAMP NOT NULL, scope VARCHAR(2000), CONSTRAINT auth_code_pk PRIMARY KEY (authorization_code));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_refresh_tokens ( refresh_token VARCHAR(40) NOT NULL, client_id VARCHAR(80) NOT NULL, user_id VARCHAR(255), expires TIMESTAMP NOT NULL, scope VARCHAR(2000), CONSTRAINT refresh_token_pk PRIMARY KEY (refresh_token));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_users (username VARCHAR(255) NOT NULL, password VARCHAR(2000), first_name VARCHAR(255), last_name VARCHAR(255), CONSTRAINT username_pk PRIMARY KEY (username));")->execute();
    }

    private function oracle_up()
    {
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_clients ( client_id VARCHAR2(80) NOT NULL, client_secret VARCHAR2(80) NOT NULL, redirect_uri VARCHAR2(2000)  NOT NULL, CONSTRAINT client_id_pk PRIMARY KEY (client_id));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_access_tokens (access_token VARCHAR2(40) NOT NULL, client_id VARCHAR2(80) NOT NULL, user_id VARCHAR2(255), expires TIMESTAMP NOT NULL,scope VARCHAR2(2000), CONSTRAINT access_token_pk PRIMARY KEY (access_token));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_authorization_codes (authorization_code VARCHAR2(40) NOT NULL, client_id VARCHAR2(80) NOT NULL, user_id VARCHAR2(255), redirect_uri VARCHAR2(2000) NOT NULL, expires TIMESTAMP NOT NULL, scope VARCHAR2(2000), CONSTRAINT auth_code_pk PRIMARY KEY (authorization_code));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_refresh_tokens ( refresh_token VARCHAR2(40) NOT NULL, client_id VARCHAR2(80) NOT NULL, user_id VARCHAR2(255), expires TIMESTAMP NOT NULL, scope VARCHAR2(2000), CONSTRAINT refresh_token_pk PRIMARY KEY (refresh_token));")->execute();
        $this->dbConnection->createCommand("CREATE TABLE IF NOT EXISTS oauth_users (username VARCHAR2(255) NOT NULL, password VARCHAR2(2000), first_name VARCHAR2(255), last_name VARCHAR2(255), CONSTRAINT username_pk PRIMARY KEY (username));")->execute();
    }
}