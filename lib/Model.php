<?php
/**
 * 顺丰接口模板
 * author:yuchong
 * time:20160120
 */
namespace Hyperbolaa\Express\lib;


class Model {

    private $_CHECKHEADER = 'BSPdevelop';           //客户卡号,校验码
    private $_CHECKBODY   = 'j8DzkIFgmlomPt0aLuwU'; //checkbody
    //private $_URL         = 'https://bspoisp.sit.sf-express.com:11443/bsp-oisp/sfexpressService'; //快递类服务接口url
    private $_URL         = 'http://bspoisp.sit.sf-express.com:11080/bsp-oisp/sfexpressService'; //快递类服务接口url

    /**
     * 下单服务
     */
    function OrderService($data) {

        $orderid        = $data['orderid'];
        $express_type   = $data['express_type'];
        $j_company      = $data['j_company'];
        $j_contact      = $data['j_contact'];
        $j_tel          = $data['j_tel'];
        $j_address      = $data['j_address'];
        $d_company      = $data["d_company"];
        $d_contact      = $data["d_contact"];
        $d_tel          = $data["d_tel"];
        $d_address      = $data["d_address"];
        $pay_method     = $data["pay_method"];
        $j_province     = $data["j_province"];
        $j_city         = $data["j_city"];
        $j_county       = $data["j_qu"];
        $d_province     = $data["d_province"];
        $d_city         = $data["d_city"];
        $d_county       = $data["d_qu"];
        $custid         = $data["custid"];
        $remark         = $data["remark"];
        $things_num     = $data["things_num"];
        $things         = $data['things'];
        $daishou        = $data['daishou'];


        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<Request service="OrderService" lang="zh-CN">';
        $xml .= '<Head>' . $this->_CHECKHEADER . '</Head>';
        $xml .= '<Body>';
        $xml .= '<Order orderid="' . $orderid .
            '" express_type="' . $express_type .
            '" j_company="' . $j_company .
            '" j_contact="' . $j_contact .
            '" j_tel="' . $j_tel .
            '" j_address="' . $j_address .
            '" d_company="' . $d_company .
            '" d_contact="' . $d_contact .
            '" d_tel="' . $d_tel .
            '" d_address="' . $d_address .
            '" pay_method="' . $pay_method .
            '" j_province="' . $j_province .
            '" j_city="' . $j_city .
            '" j_county="' . $j_county .
            '" d_province="' . $d_province .
            '" d_city="' . $d_city .
            '" d_county="' . $d_county .
            '" custid="' . $custid .
            '" remark="' . $remark .
            '" parcel_quantity="1">';
        if($things_num != 0 && $things_num != ""){
            $xml .= '<Cargo name="' . $things . '" count="' . $things_num . '"></Cargo>';
        }
        if($daishou != "" && $daishou != 0){
            $xml .= '<AddedService name="COD" value="'.$daishou.'" value1="'.$custid.'" />';
        }
        $xml .= '</Order>';
        $xml .= '</Body>';
        $xml .= '</Request>';

        return $this->verify($xml);
    }

    /**
     * 系统自动刷选订单
     */
    function OrderFilterService1($address,$mode=1) {
        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<Request service="OrderFilterService" lang="zh-CN">';
        $xml .= '<Head>' . $this->_CHECKHEADER . '</Head>';
        $xml .= '<Body>';
        $xml .= '<OrderFilter filter_type="1" d_address="' . $address . '" />';
        $xml .= '</Body>';
        $xml .= '</Request>';

        return $this->verify($xml);
    }

    /**
     * 手动刷选订单
     */
    function OrderFilterService($data) {
        $orderid    = $data["search_orderid"];
        $d_address  = $data["search_d_address"];
        $d_tel      = $data["search_d_tel"];
        $j_tel      = $data["search_j_tel"];
        $j_address  = $data["search_j_address"];
        $j_custid   = $data["search_j_custid"];

        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<Request service="OrderFilterService" lang="zh-CN">';
        $xml .= '<Head>' . $this->_CHECKHEADER . '</Head>';
        $xml .= '<Body>';
        $xml .= '<OrderFilter orderid="'.$orderid.'" filter_type="1" d_address="' . $d_address . '">';
        $xml .= '<OrderFilterOption j_tel="'.$j_tel.'" j_address="'.$j_address.'" d_tel="'.$d_tel.'" j_custid="'.$j_custid.'" />';
        $xml .= '</OrderFilter>';
        $xml .= '</Body>';
        $xml .= '</Request>';

        return $this->verify($xml);
    }

    /**
     * 订单查询
     */
    function OrderSearchService($orderid) {
        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<Request service="OrderSearchService" lang="zh-CN">';
        $xml .= '<Head>' . $this->_CHECKHEADER . '</Head>';
        $xml .= '<Body>';
        $xml .= '<OrderSearch orderid="' . $orderid . '" />';
        $xml .= '</Body>';
        $xml .= '</Request>';

        return $this->verify($xml);
    }


    /**
     * 路由查询功能
     */
    function RouteService($mailno){
        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<Request service="RouteService" lang="zh-CN">';
        $xml .= '<Head>' . $this->_CHECKHEADER . '</Head>';
        $xml .= '<Body>';
        $xml .= '<RouteRequest tracking_type="1" method_type="1" tracking_number="'.$mailno.'"/> ';
        $xml .= '</Body>';
        $xml .= '</Request>';
        return $this->verify($xml);
    }


    /**
     * 字符串加密验证
     */
    private function verify($xml){
        $newbody    = $xml . $this->_CHECKBODY;
        $md5        = md5($newbody, true);
        $verifyCode = base64_encode($md5);

        $PostData = array(
            "xml"        => $xml,
            "verifyCode" => $verifyCode
        );
        $strPOST = http_build_query($PostData);

        return ['url'=>$this->_URL,'data'=>$strPOST];
    }



}
