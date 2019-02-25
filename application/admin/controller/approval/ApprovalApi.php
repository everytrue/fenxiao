<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/23
 * Time: 21:04
 */

namespace app\admin\controller\approval;


use app\admin\controller\AuthController;
use app\admin\model\approval\Approval;
use service\JsonService;

/**
 * 审批Api控制器
 * Class ApprovalApi
 * @package app\admin\controller\approval
 */
class ApprovalApi extends AuthController
{
    /**
     * 分页列表
     * @param int $page 页码
     * @param int $size 大小
     */
    public function pageList($page=1, $size=20)
    {
        $where = $this->request->post();
        $approvalModel = new Approval();
        $approvalList = $approvalModel->where($where)->page($page, $size)->select();
        $total = $approvalModel->count();
        return JsonService::successful('ok', ['list'=>$approvalList, 'total'=>$total]);
    }

    /**
     * 通过
     * @param int $id   审批id
     */
    public function pass($id)
    {
        $approvalModel = new Approval();
        try {
            $approvalModel->pass($id);
        } catch (\Exception $e) {
            return JsonService::fail($e->getMessage());
        }

        return JsonService::successful();
    }

    /**
     * 驳回
     * @param int $id   审批id
     */
    public function reject($id)
    {
        $approvalModel = new Approval();
        try {
            $approvalModel->reject($id);
        } catch (\Exception $e) {
            return JsonService::fail($e->getMessage());
        }
        return JsonService::successful();
    }
}