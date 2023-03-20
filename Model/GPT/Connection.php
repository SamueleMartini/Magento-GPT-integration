<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\ConnectionInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use SamueleMartini\GPT\Helper\ModuleConfig;
use Exception;

class Connection implements ConnectionInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var Curl
     */
    protected Curl $curl;
    /**
     * @var Json
     */
    protected Json $json;

    /**
     * @param ModuleConfig $moduleConfig
     * @param Curl $curl
     * @param Json $json
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        Curl $curl,
        Json $json
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->curl = $curl;
        $this->json = $json;
    }

    /**
     * @param string $method
     * @param array $headers
     * @param string $requestType
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function webserviceCall(string $method, array $headers = [], string $requestType = 'GET', array $params = []): array
    {
        $endpoint = self::ENDPOINT . $method;

        if ($requestType === 'GET' && !empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        $this->setHeader($headers);
        $this->setOption();

        if ($requestType === 'GET') {
            $this->curl->get($endpoint);
        } else {
            $this->curl->post($endpoint, $this->json->serialize($params));
        }

        $response = $this->curl->getBody();

        return $this->checkErrors($response);
    }

    /**
     * @param array $headers
     * @return void
     */
    public function setHeader(array $headers = []): void // to add others make a before plugin and add elements to the $headers array
    {
        $this->curl->addHeader('Authorization', 'Bearer ' . $this->moduleConfig->getApiKey());

        foreach ($headers as $header => $value) {
            $this->curl->addHeader($header, $value);
        }
    }

    /**
     * @param array $options
     * @return void
     */
    public function setOption(array $options = []): void // to add others make a before plugin and add elements to the $options array
    {
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);

        foreach ($options as $option => $value) {
            $this->curl->setOption($option, $value);
        }
    }

    /**
     * @param string $response
     * @return array
     * @throws Exception
     */
    protected function checkErrors(string $response): array
    {
        $response = $this->json->unserialize($response);

        if (isset($response['error'])) {
            throw new Exception($response['error']['message']);
        }

        return $response;
    }
}
