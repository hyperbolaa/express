<?php
/**
 * 合众速递的查询出口
 */
namespace Hyperbolaa\Express\src;
use Hyperbolaa\Express\lib\Curl;
use Hyperbolaa\Express\lib\Xml;


class Ucs
{

    private $url = "http://order.api.ucsus.com/ucsusapi20/service/v2/trackShipment/xml/";

    private $storeLogin = "888888";                                //账号由ucs提供
    private $token      = "******";                                 //密钥由ucs提供
    private $carrier    = "UCSUS";                                   //载体


    /**
     * 快递的查询
     * @param string $trackNumber
     * @return array
     */
    public function query($trackNumber = 'TX901100035US')
    {
        $curl = new Curl();
        $xml  = new Xml();
        $data = $this->buildXml($trackNumber);
        $request_xml  = $xml->build($data);
        $response_xml = $curl->post($this->url,$request_xml);
        $response_arr = $xml->parse($response_xml);

        return $response_arr;
    }


    /**
     * 构造请求数据
     * $trackNumber  为字符串时候  构造为数组
     * $trackNumber  为数组的时候  为默认值
     * $trackNumber  格式 ["xxxxxxxxxx","ddddddddddd"]
     */
    private function buildXml($trackNumber){
        if(!is_array($trackNumber)){
            $trackNumber = [$trackNumber];
        }
        $data = [
            "StoreLogin" => $this->storeLogin,
            'Token'      => $this->token,
            'Carrier'    => $this->carrier,
            'TrackNumberList' => $trackNumber
        ];
        return $data;
    }






}
