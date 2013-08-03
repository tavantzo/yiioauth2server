<?php
/**
 * @param Oauth2Module $module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $_s = $this->module->server;    
    }
}