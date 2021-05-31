<?php 
require_once ROOT.'/base/Controller.php';
require_once ROOT.'/base/trait/AuthRequiredTrait.php';

abstract class AuthRequiredController extends Controller {
	use AuthRequiredTrait;
}

 ?>