<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Requests\MeRequest;
use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Repositories\MeRepository;

/**
 * 我的账户控制器
 *
 * @author king <king@jinsec.com>
 */
class AdminMeController extends BackController
{


    /**
     * The MeRepository instance.
     *
     * @var jamx\Repositories\MeRepository
     */
    protected $me;


    public function __construct(
        MeRepository $me)
    {
        parent::__construct();
        $this->me = $me;
    }


    /**
     * 个人资料页面
     *
     * @return Response
     */
    public function getindex()
    {
        $me = user('object');
        return view('admin.profile.index', compact('me'));
    }


    /**
     * 提交修改个人资料
     *
     * @return Response
     */
    public function putUpdate(MeRequest $request)
    {
        //使用Bootstrap后台框架，可以废弃ajax提交方式，使用表单自动验证
        $this->me->update(user('id'), $request->all());
        return redirect()->route('admin.profile.index')->with('message', '成功更新个人资料！');
    }
}
