<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/22
 * Time: 14:30
 */

namespace app\admin\controller\approval;

use app\admin\controller\AuthController;
use \app\admin\model\approval\Approval as ApprovalModel;

/**
 * 审批页面控制器
 * Class Approval
 * @package app\admin\controller\approval
 */
class Approval extends AuthController
{
    /**
     * 审批列表
     * @param int $page 页码
     * @param int $size 大小
     */
    public function index($page=1, $size=20)
    {
        $search = $this->request->post();
        $approvalModel = new ApprovalModel();
        $approvalList = $approvalModel->page($page, $size)->select();
    }
}