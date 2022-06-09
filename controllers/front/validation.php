<?php

use GoPay\Definition\TokenScope;
use GoPay\Definition\Language;


class sell24_gopayValidationModuleFrontController extends ModuleFrontController
{

    public function checkPay($idPay) {
    
        include_once(_PS_MODULE_DIR_ . 'sell24_gopay/gopay/autoload.php');

  
     $gopay = GoPay\payments([
        'goid' => Configuration::get('GOPAYGoID'),
        'clientId' => Configuration::get('GOPAYClientID'),
        'clientSecret' => Configuration::get('GOPAYClientSecret'),
        'isProductionMode' => false,
        'language' => Language::CZECH
    ]);

    $response = $gopay->getStatus(''.$idpay.'');

    if ($response->hasSucceed()) {
        // response format: https://doc.gopay.com/en/?shell#status-of-the-payment
     //   echo "hooray, API returned {$response}<br />\n";
    } else {
        // errors format: https://doc.gopay.com/en/?shell#http-result-codes
      //  echo "oops, API returned {$response->statusCode}: {$response}";
    }
    
    // 200 	Calling was successful
    // 403 	Not-authorized access
    // 409 	Validation errors
    // 500 	Calling ended with error
    // 404 	Service does not exist



    }


    public function postProcess()
    {
        /**
         * Get current cart object from session
         */
        $cart = $this->context->cart;
        $authorized = false;
 
        /**
         * Verify if this module is enabled and if the cart has
         * a valid customer, delivery address and invoice address
         */
        if (!$this->module->active || $cart->id_customer == 0 || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0) {
            Tools::redirect('index.php?controller=order&step=1');
        }
 
        /**
         * Verify if this payment module is authorized
         */
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'sell24_gopay') {
                $authorized = true;
                break;
            }
        }
 
        if (!$authorized) {
            die($this->l('This payment method is not available.'));
        }
 
        /** @var CustomerCore $customer */
        $customer = new Customer($cart->id_customer);
 
        /**
         * Check if this is a vlaid customer account
         */
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }
 
        /**
         * Place the order
         */
        $this->module->validateOrder(
            (int) $this->context->cart->id,
            Configuration::get('PS_OS_PAYMENT'),
            (float) $this->context->cart->getOrderTotal(true, Cart::BOTH),
            $this->module->displayName,
            null,
            null,
            (int) $this->context->currency->id,
            false,
            $customer->secure_key
        );
 
        /**
         * Redirect the customer to the order confirmation page
         */
        Tools::redirect('index.php?controller=order-confirmation&id_cart='.(int)$cart->id.'&id_module='.(int)$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
    }
}
