<?php

namespace jamx\Http\Middleware;

use Closure;

/**
 * 后台管理 权限不足抛出异常响应 中间件
 *
 * @author king <king@jinsec.com>
 */
class PermissionDenied
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return response()->view('errors.deny', array(), 403);
        return $next($request);
    }
}
