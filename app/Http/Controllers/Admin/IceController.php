<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Repositories\DeviceRepository;  //模型仓库层
use jamx\Repositories\DictRepository;
use jamx\Repositories\DynamicRepository;
use Illuminate\Http\Request;
use jamx\Repositories\UserRepository;
use jamx\Repositories\ChannelRepository;

require_once 'Ice.php';
require_once 'Printer.php';
require_once '/home/jzb/Murmur.php';
use Murmur_MetaPrxHelper;

class IceController extends BackController
{

    public function __construct(
        DeviceRepository $repo,DictRepository $dict,DynamicRepository $dynamic,UserRepository $user,ChannelRepository $channel)
    {
        parent::__construct();
        $this->repo = $repo;
        $this->dict = $dict;
        $this->dynamic = $dynamic;
        $this->user = $user;
        $this->channel = $channel;
        
        if (! user('object')->can('manage_device')) {
            $this->middleware('deny403');
        }
       
    }
    
    protected function printer(Request $req)
    {
    	echo time();
    	$ic = null;
    	try
    	{
    		$ic = Ice_initialize();
    		$base = $ic->stringToProxy("SimplePrinter:default -p 10000");
    		$printer = Demo_PrinterPrxHelper::checkedCast($base);
    		if(!$printer)
    			throw new RuntimeException("Invalid proxy");
    	
    			$printer->printString("Hello World!");
    	}
    	catch(Exception $ex)
    	{
    		echo $ex;
    	}
    	
    	if($ic)
    	{
    		// Clean up
    		try
    		{
    			$ic->destroy();
    		}
    		catch(Exception $ex)
    		{
    			echo $ex;
    		}
    	}
    }
    
    protected function test(Request $req){
    	echo time();
    	$ic = null;
    	try
    	{
    		$ic = Ice_initialize();
    		$base = $ic->stringToProxy("Meta -e 1.0:tcp -h 127.0.0.1 -p 6502");
    	
    		var_dump($base);
    			
    		$printer = Murmur_MetaPrxHelper::checkedCast($base);
    		if(!$printer){
    			echo 'invalid proxy';
    		}
    		print_r($printer);
    			
    		//throw new RuntimeException("Invalid proxy");
    	
    		$printer->unregisterUser(3);
    		exit;
    	
    	}
    	catch(Exception $ex)
    	{
    		echo $ex;
    	}
    	
    	if($ic)
    	{
    		// Clean up
    		//try
    		//{
    		$ic->destroy();
    		/*
    			}
    			catch(Exception $ex)
    			{
    			echo $ex;
    			}*/
    	}
    }
    
}
