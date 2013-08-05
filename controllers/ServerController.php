<?php
/**
 * @param Oauth2Module $module
 */
class ServerController extends Controller
{
    public function actionAuthorize()
    {
        $model = new OAuth2AuthirizeModel();
        // create your storage again
        $storage = $this->module->storage;
        
        // create your server again
        $server = $this->module->server;
        
        // Add the "Authorization Code" grant type (this is required for authorization flows)
        $server->addGrantType(new OAuth2_GrantType_AuthorizationCode($storage));
        
        $request = OAuth2_Request::createFromGlobals();
        $response = new OAuth2_Response();
        
        // validate the authorize request
        if (!$server->validateAuthorizeRequest($request, $response)) {
            $response->send();
            return;
        }
        // display an authorization form
        if (!Yii::app()->request->isPostRequest) {
            $this->render($this->model->authorizeView, $model);
        }
        // print the authorization code if the user has authorized your client
        $is_authorized = ($_POST['authorized'] === 'yes');
        $server->handleAuthorizeRequest($request, $response, $is_authorized);
        if ($is_authorized) {
          // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
          $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5);
          exit("SUCCESS! Authorization Code: $code");
        }
        $response->send();
  
    }
    
    public function actionResource()
    {
        // Handle a request for an OAuth2.0 Access Token and send the response to the client
        if (!$this->module->server->verifyResourceRequest(OAuth2_Request::createFromGlobals(), new OAuth2_Response())) {
            $this->module->server->getResponse()->send();
            Yii::app()->end();
        }
        
        echo CJSON::encode(array('success' => true, 'message' => Yii::t('oauth2server.SeverController', 'Access granted'));
    }
    
    public function actionToken()
    {
        $this->module->server->addGrantType(new OAuth2_GrantType_ClientCredentials($this->module->storage));
        $this->module->server->handleTokenRequest(OAuth2_Request::createFromGlobals(), new OAuth2_Response())
            ->send();
    }

}
