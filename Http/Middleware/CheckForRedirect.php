<?php

namespace Modules\Redirect\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Redirect\Repositories\RedirectRepository;

class CheckForRedirect
{
    private $redirect;

    /**
     * @param RedirectRepository $redirect
     */
    public function __construct(RedirectRepository $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedUrl = $request->url();

        $redirectObj = $this->redirect->where('from', $requestedUrl)->get(['to', 'type'])->first();

        if ($redirectObj) {
            return redirect()->to($redirectObj->to, $redirectObj->type);
        }

        return $next($request);
    }
}
