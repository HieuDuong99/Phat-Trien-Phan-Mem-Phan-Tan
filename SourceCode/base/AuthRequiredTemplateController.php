<?php 
require_once ROOT.'/base/Controller.php';
require_once ROOT.'/base/trait/AuthRequiredTrait.php';
require_once ROOT.'/base/trait/TemplateTrait.php';

class AuthRequiredTemplateController extends Controller {
	use TemplateTrait, AuthRequiredTrait;
}

 ?>