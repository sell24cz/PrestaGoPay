<?php

if (!defined('_PS_VERSION_'))
    exit();

  //  include_once(_PS_MODULE_DIR_ . 'sell24_gopay/gopay/autoload.php');

    use GoPay\Definition\Language;
    use GoPay\Definition\Payment\Currency;
    use GoPay\Definition\Payment\PaymentInstrument;
    use GoPay\Definition\Payment\BankSwiftCode;
    use GoPay\Definition\Payment\Recurrence;




class sell24_gopay extends PaymentModule
{

    private $_html = '';
    private $_postErrors = array();
 
    public $address;
    public $formAction;
    
   

    public function __construct()
    {
        $this->name = 'sell24_gopay';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'sell24.cz';
        $this->controllers = array('payment', 'validation');
        $this->need_instance = 1;
        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);
        $this->currencies             = true;
        $this->currencies_mode        = 'checkbox';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('GOPAY Payment', 'sell24_gopay');
        $this->description = $this->l('Payment processing using GoPay gateway.', 'sell24_gopay');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?', 'sell24 banner');
    }


public function install()
    {
        return parent::install()
            && $this->registerHook('paymentOptions')
            && $this->registerHook('paymentReturn') 
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayFooter'); 
            
        
            Configuration::updateValue('GOPAYClientID', 'value');
            Configuration::updateValue('GOPAYClientSecret', 'value');
            Configuration::updateValue('GOPAYGoID', 'value');
            return 'value problem';

    }

public function uninstall()
    {
    return (Configuration::deleteByName('GOPAYClientID') AND
    Configuration::deleteByName('GOPAYClientSecret') AND
    parent::uninstall() );

    }


public function hookDisplayHeader($params)
    {
    // < assign variables to template >
//return 'ewqeqwewqeqw' ;
    }


public function hookDisplayFooter($params)
    {
    return 'ewqeqwewqeqw' ;
    }

    public function money($money){

        $money = number_format( $money, 2 );
        $convert = (int)($money * 100);
        return $convert;
        
        }
        



        public function delivery($text) {
        
            switch ($text) {
                case 'pl':
                    $back = "Dostawa";
                    break;
                case 'cs':
                    $back = "Doručení";
                    break;
                case 'en':
                    $back ="Delivery";
                    break;
                default:
                    $back ="Doručení";
            }
        
            return $back;
        
        }

        public function currencyShow($text) {
        
            switch ($text) {
                case 'CZK':
                    $back = "CZECH_CROWNS";
                    break;
                case 'EUR':
                    $back = "EUROS";
                    break;
                case 'PLN':
                    $back ="Polish_złoty";
                    break;
                case 'HUF':
                    $back ="Hungarian_forint";
                    break;
                case 'GBP':
                    $back ="British_pound";
                    break;
                case 'USD':
                    $back ="US_dollar";
                    break;
                case 'RON':
                    $back ="Romanian_Leu";
                    break;
                case 'HRK':
                    $back ="Kuna";
                    break;    
                case 'BGN':
                    $back ="Bulgarian_Lev";
                    break;                                                                                          
                default:
                    $back ="CZECH_CROWNS";
            }
        
            return $back;
        
        }

        public function langSet($text) {
        
            switch ($text) {
                case 'CS':
                    $back = "Czech";
                    break;
                case 'EN':
                    $back = "English";
                    break;
                case 'SK':
                    $back ="Slovak";
                    break;
                case 'DE':
                    $back ="German";
                    break;
                case 'RU':
                    $back ="Russian";
                    break;
                case 'PL':
                    $back ="Polish";
                    break;
                case 'HU':
                    $back ="Hungarian";
                    break;
                case 'FR':
                    $back ="French";
                    break;    
                case 'RO':
                    $back ="Romanian";
                    break;   
                case 'BG':
                    $back ="Bulgarian";
                    break;
                case 'HR':
                    $back ="Croatian";
                    break;
                case 'IT':
                    $back ="Italian";
                    break;    
                case 'ES':
                    $back ="Spanish";
                    break;                                                                                                                
                default:
                    $back ="Czech";
            }
        
            return $back;
        
        }

    public function bank($text) {

        switch ($text) {
              case 'CZK': 
               $back = array(
               BankSwiftCode::FIO_BANKA, 
               BankSwiftCode::MBANK, 
               BankSwiftCode::CSOB,
               BankSwiftCode::CESKA_SPORITELNA,
               BankSwiftCode::KOMERCNI_BANKA,
               BankSwiftCode::RAIFFEISENBANK,
               BankSwiftCode::ERA,
               BankSwiftCode::UNICREDIT_BANK_CZ
               );
              case 'EUR': 
                $back = array(
                BankSwiftCode::VSEOBECNA_VEROVA_BANKA_BANKA, 
                BankSwiftCode::TATRA_BANKA, 
                BankSwiftCode::UNICREDIT_BANK_SK,
                BankSwiftCode::SLOVENSKA_SPORITELNA,
                BankSwiftCode::POSTOVA_BANKA,
                BankSwiftCode::CSOB_SK,
                BankSwiftCode::SBERBANK_SLOVENSKO,
                BankSwiftCode::UNICREDIT_BANK_CZ
                ); 
              case 'PLN': 
                $back = array(
                BankSwiftCode::MBANK1, 
                BankSwiftCode::CITI_HANDLOWY, 
                BankSwiftCode::IKO,
                BankSwiftCode::INTELIGO,
                BankSwiftCode::PLUS_BANK,
                BankSwiftCode::BANK_BPH_SA,
                BankSwiftCode::TOYOTA_BANK,
                BankSwiftCode::VOLKSWAGEN_BANK,
                BankSwiftCode::SGB, 
                BankSwiftCode::ORANGE, 
                BankSwiftCode::BZ_WBK,
                BankSwiftCode::RAIFFEISEN_BANK_POLSKA_SA,
                BankSwiftCode::POWSZECHNA_KASA_OSZCZEDNOSCI_BANK_POLSKI_SA,
                BankSwiftCode::ALIOR_BANK,
                BankSwiftCode::ING_BANK_SLASKI,
                BankSwiftCode::PEKAO_SA, 
                BankSwiftCode::GETIN_ONLINE1, 
                BankSwiftCode::BANK_MILLENNIUM,
                BankSwiftCode::BANK_OCHRONY_SRODOWISKA,
                BankSwiftCode::BNP_PARIBAS_POLSKA,
                BankSwiftCode::CREDIT_AGRICOLE,
                BankSwiftCode::DEUTSCHE_BANK_POLSKA_SA,
                BankSwiftCode::DNB_NORD,
                BankSwiftCode::E_SKOK,
                BankSwiftCode::EUROBANK,
                BankSwiftCode::POLSKI_BANK_PRZEDSIEBIORCZOSCI_SPOLKA_AKCYJNA
                );                              
              default:
              $back = array(
                BankSwiftCode::FIO_BANKA, 
                BankSwiftCode::MBANK, 
                BankSwiftCode::CSOB,
                BankSwiftCode::CESKA_SPORITELNA,
                BankSwiftCode::KOMERCNI_BANKA,
                BankSwiftCode::RAIFFEISENBANK,
                BankSwiftCode::ERA,
                );
        }      
            return $back ;

    }


    public function gopay() {

    include_once(_PS_MODULE_DIR_ . 'sell24_gopay/gopay/autoload.php');
    
  
     $gopay = GoPay\payments([
        'goid' => Configuration::get('GOPAYGoID'),
        'clientId' => Configuration::get('GOPAYClientID'),
        'clientSecret' => Configuration::get('GOPAYClientSecret'),
        'isProductionMode' => false,
        'language' => Language::CZECH
    ]);
  
     $cart = $this->context->cart;
     $CartId = $cart->id ;
     $currency = $this->context->currency;
     $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
     $UniqueId = $cart->secure_key;
    
    $products = $cart->getProducts(true);

   
     foreach ($products AS $product)
     {  
        $m = $product['total_wt']  ;
        $money = $this->money($m);
        
        $dane[] = array('name' => ''.$product['name'].'', 'amount' => $money, 'count' => $product['cart_quantity'], ) ;
              
        try {
            $test = $this->money($m)."<br />";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "<br />";
        }
      }
      
       $ship = $cart->getOrderTotal(true, Cart::ONLY_SHIPPING) ; 
       $ship = $this->money($ship); 
       $dane[] = array('name' => 'shiping', 'amount' => $ship, 'count' => '1', ) ;

     
       $orderTotal =  $cart->getOrderTotal() ;
       $orderTotal = $this->money($orderTotal);

       $adress = new Address($this->context->cart->id_address_delivery);
     
       $street = $adress->address1;
       $PostCode = $adress->postcode;
       $city = $adress->city;
       $PhoneMobile= $adress->phone_mobile;
       $CountryCode = Context::getContext()->cookie->iso_code_country;
      
       $languageApi = $this->langSet(''.$CountryCode.'');
       //$languageApi = 'Language::'.$languageApi ;
   
       $currencyMoney =   Context::getContext()->currency->iso_code;
       //$getCurrency = $this->currencyShow(''.$currencyMoney.'') ;
       //$currencyShow = 'Currency::'.$getCurrency;
       //$c = 'Currency::CZECH_CROWNS' ;

       $email =     $this->context->customer->email ;
       $FirstName = $this->context->customer->firstname;
       $LastName =  $this->context->customer->lastname;

       $return_url = "https://$_SERVER[HTTP_HOST]/module/sell24_gopay/validation";
       $notification_url = '' ;



//test 
//     print("<pre>".print_r($customer,true)."</pre>");
//     print("<pre>".print_r($cart,true)."</pre>");
//     print("<pre>".print_r($dane,true)."</pre>");



//end test 

    // recurrent payment must have field ''
    $recurrentPayment = [
        'recurrence' => [
            'recurrence_cycle' => Recurrence::DAILY,
            'recurrence_period' => '7',
            'recurrence_date_to' => '2020-12-31'
        ]
    ];    
    // pre-authorized payment must have field 'preauthorization'
    $preauthorizedPayment = [
        'preauthorization' => true
    ];
    
    $banki = array(BankSwiftCode::FIO_BANKA, BankSwiftCode::MBANK, BankSwiftCode::CSOB);
    $banki = $this->bank(''.$currencyMoney.'');
    //'allowed_swifts' => [BankSwiftCode::FIO_BANKA, BankSwiftCode::MBANK],

    $response = $gopay->createPayment([
        'payer' => [
            'default_payment_instrument' => PaymentInstrument::BANK_ACCOUNT,
            'allowed_payment_instruments' => [PaymentInstrument::BANK_ACCOUNT,PaymentInstrument::PAYMENT_CARD,PaymentInstrument::PAYPAL],   
            'allowed_swifts' => $banki,
            'contact' => [
                'first_name' => ''.$FirstName.'',
                'last_name' => ''.$LastName.'',
                'email' => ''.$email.'',
                'phone_number' => ''.$PhoneMobile.'',
                'city' => ''.$city.'',
                'street' => ''.$street.'',
                'postal_code' => ''.$PostCode.'',
                'country_code' => ''.$CountryCode.'',
            ],
        ],
        'amount' => $orderTotal,
        'currency' => $currencyMoney,
        'order_number' => ''.$CartId.'',
        'order_description' => 'basket:'.$CartId,
       'items' => $dane
        ,
        'additional_params' => [
            array('name' => 'invoicenumber', 'value' => ''.$UniqueId.'')
        ],
        'callback' => [
            'return_url' => ''.$return_url.'',
            'notification_url' => 'https://shop.sell24.cz/gopay/test1.php'
        ],
        'lang' => $languageApi, // if lang is not specified, then default lang is used
    ]);

 


    
    return  $response->json['gw_url'] ;
    
    }



public function hookPaymentOptions($params)
{


    /*
     * Verify if this module is active
     */
    if (!$this->active) {
        return;
    }
    /**
     * Form action URL. The form data will be sent to the
     * validation controller when the user finishes
     * the order process.
     */
  //  $formAction = $this->context->link->getModuleLink($this->name, 'validation', array(), true);
  //  $formAction = "https://gw.sandbox.gopay.com/gw/v3/dfgvmwTKK5hrJx2aGG8ZnFyBJhAvF" ;
      $formAction = $this->gopay() ;
  
    /**
     * Assign the url form action to the template var $action
     */
    $this->smarty->assign(['action' => $formAction]);

    /**
     *  Load form template to be displayed in the checkout step
     */
    $paymentForm = $this->fetch('module:sell24_gopay/views/templates/hook/displayPayment.tpl');

    /**
     * Create a PaymentOption object containing the necessary data
     * to display this module in the checkout
     */
    $newOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption;
    $newOption->setModuleName($this->displayName)
        ->setCallToActionText($this->displayName)
        ->setLogo(_MODULE_DIR_.'sell24_gopay/views/img/gopay_bannery-barevne.png')       
        ->setAction($formAction)
        ->setForm($paymentForm);

    $payment_options = array(
        $newOption
    );

    return $payment_options;
}



public function hookPaymentReturn($params)
{
    /**
     * Verify if this module is enabled
     */
    if (!$this->active) {
        return;
    }
    return $this->fetch('module:sell24_gopay/views/templates/hook/payment_return.tpl');
}


public function hookDisplayPayment($params){
    return $this->display(__FILE__, 'displayPayment.tpl');
    }

    // public function getContent()
    // {
    //     return $this->_html;
    // }



    public function displayForm()
    {
        // < init fields for form array >
       
      
    
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
    
        $fields_form = array();
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('GOPAY Configuration'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('GoID'),
                    'size' => 20,                
                    'name' => 'GOPAYGoID',
                    'required' => true,
                    ),
                array(
                    'type' => 'text',
                    'label' => $this->l('ClientID'),
                    'size' => 20,                
                    'name' => 'GOPAYClientID',
                    'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('ClientSecret'),
                        'size' => 20,                
                        'name' => 'GOPAYClientSecret',
                        'required' => true,
                        ),
            ),
    
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );
    
     
    
        // < load helperForm >
        $helper = new HelperForm();
    
        // < module, token and currentIndex >
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
    
    
        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
    
    
        // < title and toolbar >
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                        '&token='.Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );
    
        // < load current value >
        $helper->fields_value['GOPAYClientID'] = Configuration::get('GOPAYClientID');
        $helper->fields_value['GOPAYClientSecret'] = Configuration::get('GOPAYClientSecret');
        $helper->fields_value['GOPAYGoID'] = Configuration::get('GOPAYGoID');
    
      
    
      
    
        return $helper->generateForm($fields_form);

       

    }
    
    
    public function getContent()
    {
        $output = null;
    
    
        // < here we check if the form is submited for this module >
        if (Tools::isSubmit('submit'.$this->name)) {
            $GOPAYClientID = strval(Tools::getValue('GOPAYClientID'));
            $GOPAYClientSecret = strval(Tools::getValue('GOPAYClientSecret'));
            $GOPAYGoID = strval(Tools::getValue('GOPAYGoID'));
    
            
            // < make some validation, check if we have something in the input >
            if (!isset($GOPAYClientID) OR !isset($GOPAYClientSecret) )
                $output .= $this->displayError($this->l('Please insert something in this field.'));
            else
            {
                // < this will update the value of the Configuration variable >
                Configuration::updateValue( 'GOPAYClientID', $GOPAYClientID,true);
                Configuration::updateValue( 'GOPAYClientSecret', $GOPAYClientSecret,true);
                Configuration::updateValue( 'GOPAYGoID', $GOPAYGoID,true);
    
    
                // < this will display the confirmation message >
                $output .= $this->displayConfirmation($this->l('Value updated!'));
           
            }
        }

  
        $output .= $this->display(__FILE__, 'admin_info.tpl');
        return $output.$this->displayForm();



    }





}
