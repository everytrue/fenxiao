<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/24
 * Time: 16:53
 */

namespace app\wap\controller;

use app\admin\model\approval\Approval as ApprovalModel;
use service\JsonService;
use think\Exception;


class Approval extends AuthController
{
    public function create()
    {
        $formData = $this->request->post();
        $approvalModel = new ApprovalModel();
        try {
            $approvalModel->add($formData);
            return JsonService::successful();
        } catch (Exception $e) {
            return JsonService::fail($e->getMessage());
        }
    }
}