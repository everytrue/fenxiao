<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/23
 * Time: 19:57
 */

namespace app\admin\model\approval;

use app\admin\controller\order\StoreOrder;
use app\admin\model\store\StoreProduct;
use app\admin\model\system\SystemAdmin;
use app\wap\controller\AuthApi;
use app\wap\controller\Store;
use basic\ModelBasic;
use think\Cookie;
use think\Db;
use think\Exception;
use traits\ModelTrait;
use util\Curl;

class Approval extends ModelBasic
{
    use ModelTrait;

    protected $autoWriteTimestamp = true;
    protected $insert = ['uid', 'status'=>0];
    protected $update = ['approver', 'approval_time'];

    public function getStatusAttr($value)
    {
        $status = [0=>'待审批', 1=>'审批通过', 2=>'审批驳回'];
        return $status[$value];
    }

    public function setUidAttr()
    {
        return SystemAdmin::activeAdminIdOrFail();
    }

    public function setApproverAttr()
    {
        return SystemAdmin::activeAdminIdOrFail();
    }

    public function setApprovalTimeAttr()
    {
        return time();
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function pass($id)
    {
        $approval = self::find($id);
        if (!$approval) throw new Exception('数据不存在!');

        Db::startTrans();
        self::update(['id'=>$id, 'status'=>1]);
        $storeOrder = new StoreOrder();
        $msg = $storeOrder->take_delivery_func(['order_id'=>$approval['order_id']]);
        if ($msg) {
            Db::rollback();
            throw new Exception($msg);
        } else {
            Db::commit();
        }
    }

    /**
     * @param $id
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function reject($id)
    {
        $approval = self::find($id);
        if (!$approval) throw new Exception('数据不存在!');
        self::update(['id'=>$id, 'status'=>2]);
    }

    /**
     * @param array $data
     * @return false|int|void
     * @throws Exception
     */
    public function add($data)
    {
        $product = StoreProduct::get(['is_card'=>1]);
        if (!$product) throw new Exception('Product does not exist or has been deleted.');

        $authApi = new AuthApi();
        $result = $authApi->now_buy_api($product['id']);
        if (!is_array($result) || !isset($result['cartId'])) throw new Exception($result);
        $cartId = $result['cartId'];

        $store = new Store();
        $result = $store->confirm_order_api($cartId);
        if (!is_array($result) || !isset($result['orderKey'])) throw new Exception($result);
        $orderKey = $result['orderKey'];

        // 生成并获取订单
        $curl = new Curl();
        $url = 'http://127.0.0.1/index.php/wap/auth_api/create_order/key' . $orderKey;
        $form = ['addressId'=>2, 'bargainId'=>0, 'couponId'=>'', 'mark'=>'', 'payType'=>'yue', 'seckill_id'=>0, 'useIntegral'=>false];
        $result = json_decode($curl->post($url, $form, cookieToString(Cookie::get())), true);
        if ($result['code'] != 200) throw new Exception($result['msg']);
        $orderId = $result['data']['result']['orderId'];

        $storeOrder = new StoreOrder();
        $orderData = \app\admin\model\order\StoreOrder::get(['order_id'=>$orderId]);
        if (!$orderData) throw new Exception('Order does not exist or has been deleted.');
        $result = $storeOrder->updateDeliveryGoods_api(['delivery_name'=>'中通快递', 'delivery_id'=>'cards_008'], $orderData['id']);
        if ($result) throw new Exception($result);

        $data['order_id'] = $orderId;
        self::insert($data);
    }
}