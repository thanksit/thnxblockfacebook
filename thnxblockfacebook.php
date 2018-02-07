<?php
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
class thnxblockfacebook extends Module implements WidgetInterface
{
	public function __construct()
	{
		$this->name = 'thnxblockfacebook';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'thanksit.com';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Platinum Facebook Like Box block');
		$this->description = $this->l('Platinum Facebook Like Box block by thanksit');
		$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
	}
	public function install()
	{
		if(!parent::install()
			|| !$this->registerHook('DisplayFooter')
			|| !$this->registerHook('displayHeader')
			)
		return false;
			Configuration::updateValue('thnxblockfacebook_url','https://www.facebook.com/thanksit/');
		return true;
	}
	public function uninstall()
	{
		if(!parent::uninstall())
			return false;
		Configuration::deleteByName('thnxblockfacebook_url');
			return true;
	}
	public function getContent()
	{
		$html = '';
		if (Tools::isSubmit('submitModule'))
		{
			Configuration::updateValue('thnxblockfacebook_url', Tools::getValue('thnxblockfacebook_url'));
			$html .= $this->displayConfirmation($this->l('Configuration updated'));
			Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		$html .= $this->renderForm();
		return $html;
	}
	public function renderWidget($hookName = null, array $configuration = [])
	{
	    $this->smarty->assign($this->getWidgetVariables($hookName,$configuration));
	    return $this->fetch('module:'.$this->name.'/views/templates/front/'.$this->name.'.tpl');	
	}
	public function getWidgetVariables($hookName = null, array $configuration = [])
	{
		$return_arr = array();
	    $facebookurl = Configuration::get('thnxblockfacebook_url');
    	if (!strstr($facebookurl, 'facebook.com')){
    		$facebookurl = 'https://www.facebook.com/'.$facebookurl;
    	}
    	$return_arr['facebookurl'] = $facebookurl;
    	return $return_arr;
	}
	public function hookHeader()
	{
		$this->page_name = Dispatcher::getInstance()->getController();
	}
	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Facebook Block Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Facebook link (full URL is required)'),
						'name' => 'thnxblockfacebook_url',
					),
				),
				'submit' => array(
					'title' => $this->l('Save')
				)
			),
		);
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		return $helper->generateForm(array($fields_form));
	}
	public function getConfigFieldsValues()
	{
		return array(
			'thnxblockfacebook_url' => Tools::getValue('thnxblockfacebook_url', Configuration::get('thnxblockfacebook_url')),
		);
	}
}