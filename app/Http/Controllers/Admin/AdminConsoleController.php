<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Repositories\UserRepository;
use jamx\Repositories\ChannelRepository;
use jamx\Repositories\DeviceRepository;
use jamx\Repositories\RoleRepository;

/**
 * 后台控制台常规控制器
 *
 * @author king <king@jinsec.com>
 */
class AdminConsoleController extends BackController
{
	public $mn = 'console';
	public function __construct(UserRepository $user,ChannelRepository $channel,DeviceRepository $device,RoleRepository $role)
	{
		$this->user = $user;
		$this->channel = $channel;
		$this->device = $device;
		$this->role = $role;
	}
	
    /**
     * 后台首页 === 后台控制台概要页面
     *
     * @return Response
     */
    public function getIndex(Request $req)
    {
        //计数：
        $where['and'] =array('is_delete'=>'0');
        $req->is_delete = 0;
        $req->is_count = true;
        $ct_user = $this->user->index($req);
        $where2['and'] = array('state'=>'0');
        $req->state = 0;
        $ct_channel = $this->channel->index($req);
        $ct_device = $this->device->index($req);
        $ct_role = $this->role->index($req);
        /*
         * 
         *$where['and'] =array('is_delete'=>'0');
        $ct_user = $this->user->lists($where,array(),'',true);
        $where2['and'] = array('state'=>'0');
        $ct_channel = $this->channel->lists($where2,array(),'',true);
        $ct_device = $this->device->lists($where,array(),'',true);
        $ct_role = $this->role->lists(array(),array(),'',true);
         */
        $mn = $this->mn;
    	return view('admin.index',compact('ct_user','ct_channel','ct_device','ct_role','mn'));
    }
}
