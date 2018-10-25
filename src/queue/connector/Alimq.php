<?php
/**
 * Created by PhpStorm.
 * User: greatsir
 * Date: 2018/10/25
 * Time: 上午9:31
 */

namespace think\queue\connector;


use GuzzleHttp\Client;
use think\queue\Connector;
use think\queue\connector\message\PushMessage;

class Alimq extends Connector
{
    protected $message;
    const NEW_LINE = '\n';
    protected $access_key;
    protected $secret_key;
    protected $mq_url;
    protected $topic;
    protected $producer_id;
    protected $customer_id;
    public function __construct($options)
    {
        //初始化
        if(!empty($options)){
            $reflect = new \ReflectionClass(__CLASS__);
            $pros = $reflect->getProperties();
            foreach ($pros as $pro){
                $name = $pro->getName();
                $this->$name = $options[$name];
            }
        }

    }

    public function push($job, $data = '', $queue = null)
    {
        //data里面包含key和tag key统一为业务id和
        $message = new PushMessage();
        $body = $this->createPayload($job, $data);
        $message->body = $body;
        $message->tag  = $queue;
        $message->key  = $data['key'];
        // TODO: Implement push() method.//向MQ发送消息
        return $this->sendMessageToMq($message);
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        // TODO: Implement later() method.
    }

    public function pop($queue = null)
    {
        // TODO: Implement pop() method.
    }
    //发送消息
    private function sendMessageToMq(PushMessage $message)
    {
        $params = [
            'topic'   => $this->topic,
            'tag'     => $message->tag,//queue
            'key'     => $message->key,//消息唯一标识
            'time'    => $message->time,//时间
            'timeout' => 3000,
        ];
        $url = $this->mq_url.'?'.http_build_query($params);
        $sign = $this->signData($message);
        $httpClient = new Client();
        $response = $httpClient->request('POST',$url,['body'=>$message->body,'header'=>[
            'AccessKey' => $this->access_key,
            'Signature' => $sign,
            'ProducerId'=> $this->producer_id,
//            'shardingKey'=> $message->key
        ]]);
        return $response->getBody();
    }
    private function signData(PushMessage $message)
    {
        $signString = $this->topic . self::NEW_LINE . $this->producer_id . self::NEW_LINE . md5($message->body) . self::NEW_LINE . $message->time;
        $sign = base64_encode(hash_hmac("sha1", $signString, $this->secret_key, true));
        return $sign;
    }
}