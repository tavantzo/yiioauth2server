<?php

class DefaultController extends Controller {
    
    public function actionIndex()
    {
        CVarDumper::dump($this->module->server, 3, 1);
    }

}