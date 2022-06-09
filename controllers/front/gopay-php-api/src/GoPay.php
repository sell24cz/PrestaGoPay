<?php

namespace GoPay;

use GoPay\Definition\RequestMethods;
use GoPay\Http\Request;
use GoPay\Http\JsonBrowser;
use GoPay\Definition\Language;

class GoPay
{

    const JSON = 'application/json';
    const FORM = 'application/x-www-form-urlencoded';

    const LOCALE_CZECH = 'cs-CZ';
    const LOCALE_ENGLISH = 'en-US';

    private $config;
    private $browser;

    public function __construct(array $config, JsonBrowser $b)
    {
        $this->config = $config;
        $this->browser = $b;
    }

    public function getConfig($key)
    {
        return $this->config[$key];
    }

    public function call($urlPath, $contentType, $authorization, $method, $data = null)
    {
        $r = new Request($this->buildUrl("api/{$urlPath}"));
        $r->method = $method;
        $r->headers = $this->buildHeaders($contentType, $authorization);
        $r->body = $this->encodeData($contentType, $data);
        return $this->browser->send($r);
    }

    public function buildUrl($urlPath)
    {
        static $urls = [
                true => 'https://gate.gopay.cz/',
                false => 'https://gw.sandbox.gopay.com/'
        ];
        return $urls[(bool)$this->getConfig('isProductionMode')] . $urlPath;
    }

    private function encodeData($contentType, $data)
    {
        if ($data) {
            if ($contentType === GoPay::FORM) {
                return http_build_query($data, null, '&');
            }
            return json_encode($data);
        }
        return '';
    }

    private function buildHeaders($contentType, $authorization)
    {
        if (is_null($contentType)) {
            return [
                    'Accept' => 'application/json',
                    'Accept-Language' => $this->getAcceptedLanguage(),
                    'Authorization' => $authorization
            ];
        } else {
            return [
                    'Accept' => 'application/json',
                    'Accept-Language' => $this->getAcceptedLanguage(),
                    'Content-Type' => $contentType,
                    'Authorization' => $authorization
            ];
        }
    }

    private function getAcceptedLanguage()
    {
        static $czechLike = [Language::CZECH, Language::SLOVAK];
        return in_array($this->getConfig('language'), $czechLike) ? self::LOCALE_CZECH : self::LOCALE_ENGLISH;
    }
}
