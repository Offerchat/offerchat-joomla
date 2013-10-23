<?php
/**
 * @version	$version 1.0.0 Keenan Iban  $
 * @copyright	Copyright (C) 2013 Offerchat. All rights reserved.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class plgSystemOfferchat extends JPlugin {

	function plgOfferchat(&$subject, $config) {
    parent::__construct($subject, $config);
    $this->_plugin = JPluginHelper::getPlugin('system', 'Offerchat');
    $this->_params = new JParameter($this->_plugin->params);
  }

	function onAfterRender() {
		$api_key = $this->params->get('api_key', '');
		if ($api_key) {
			$app = JFactory::getApplication();

	    // skip if admin page 
	    if ($app->isAdmin()) {
	      return;
	    }

	    //getting body code and storing as buffer
	    $buffer = JResponse::getBody();

	    // <!--start of Offerchat js code--><script type='text/javascript'>var ofc_key = 'f8f5d9bf51cb727c98e3c2a23875a536';(function(){  var oc = document.createElement('script'); oc.type = 'text/javascript'; oc.async = true;  oc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'd1cpaygqxflr8n.cloudfront.net/p/js/widget.min.js?r=1';  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(oc, s);}());</script><!--end of Offerchat js code-->
	    $script  = "<script type=\"text/javascript\">";
	    $script .= "var ofc_key = '{$api_key}';";
	    $script .= "(function(){";
	    $script .= "var oc = document.createElement('script'); oc.type = 'text/javascript'; oc.async = true;";
	    $script .= "oc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'd1cpaygqxflr8n.cloudfront.net/p/js/widget.min.js?r=1';";
	    $script .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(oc, s);";
	    $script .= "}());";
	    $script .= "</script>";

	    $buffer = preg_replace("/<\/body>/", "\n\n" . $script . "\n\n</body>", $buffer);
			//output the buffer
	    JResponse::setBody($buffer);
		}
		
    return true;
	}
}

?>