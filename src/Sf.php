<?php
/**
 * 顺丰快递查询的出口
 * author:yuchong
 * time:20160120
 */
namespace Hyperbolaa\Express\src;
use Hyperbolaa\Express\lib\Curl;
use Hyperbolaa\Express\lib\Xml;
use Hyperbolaa\Express\lib\Code;
use Hyperbolaa\Express\lib\Model;


class Sf
{

    /**
     *  下订单
     */
    public function OrderService($data){
        //转化地址,跨境快递使用
        $data['j_shippercode']  = code::get($data['j_province'],$data['j_city']);
        $data['d_deliverycode'] = code::get($data['d_province'],$data['d_city']);

        $model = new Model();
        $curl  = new Curl();
        $xml   = new Xml();

        //生成数据
        $data = $model->OrderService($data);

        //执行请求,解析数据
        $response_xml = $curl->post($data['url'],$data['data']);
        $response_arr = $xml->parse($response_xml);

        return $response_arr;
    }


    /**
     * 订单刷选
     */
    public function OrderFilterService($data){

        $model = new Model();
        $curl  = new Curl();
        $xml   = new Xml();

        //生成数据
        $data = $model->OrderFilterService($data);

        //执行请求,解析数据
        $response_xml = $curl->post($data['url'],$data['data']);
        $response_arr = $xml->parse($response_xml);

        return $response_arr;

    }


    /**
     * 查询订单
     */
    public function OrderSearchService($orderid){

        $model = new Model();
        $curl  = new Curl();
        $xml   = new Xml();

        //生成数据
        $data = $model->OrderSearchService($orderid);

        //执行请求,解析数据
        $response_xml = $curl->post($data['url'],$data['data']);
        $response_arr = $xml->parse($response_xml);

        return $response_arr;
    }


    /**
     * 路由查询
     */
    public function RouteService($express_id){

        $model = new Model();
        $curl  = new Curl();
        $xml   = new Xml();

        //生成数据
        $data = $model->RouteService($express_id);

        //执行请求,解析数据
        $response_xml = $curl->post($data['url'],$data['data']);
        $response_arr = $xml->parse($response_xml);

        return $response_arr;
    }



}