<?php
/**
 * @param Oauth2Module $module
 */
class DefaultController extends Controller
{
    public function actionToken()
    {
        $this->module->server->addGrantType(new OAuth2_GrantType_ClientCredentials($this->module->storage));
        $this->module->server->handleTokenRequest(OAuth2_Request::createFromGlobals(), new OAuth2_Response())
            ->send();
    }
}