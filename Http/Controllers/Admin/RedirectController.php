<?php

namespace Modules\Redirect\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Redirect\Entities\Redirect;
use Modules\Redirect\Http\Requests\CreateRedirectRequest;
use Modules\Redirect\Http\Requests\UpdateRedirectRequest;
use Modules\Redirect\Repositories\RedirectRepository;

class RedirectController extends AdminBaseController
{
    /**
     * @var RedirectRepository
     */
    private $redirect;

    public function __construct(RedirectRepository $redirect)
    {
        parent::__construct();

        $this->redirect = $redirect;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $redirects = $this->redirect->all();

        return view('redirect::admin.redirects.index', compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $redirectTypes = $this->getRedirectTypes();

        return view('redirect::admin.redirects.create', compact('redirectTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRedirectRequest $request
     * @return Response
     */
    public function store(CreateRedirectRequest $request)
    {
        $this->redirect->create($request->all());

        return redirect()->route('admin.redirect.redirect.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('redirect::redirects.title.redirects')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Redirect $redirect
     * @return Response
     */
    public function edit(Redirect $redirect)
    {
        $redirectTypes = $this->getRedirectTypes();

        return view('redirect::admin.redirects.edit', compact('redirect', 'redirectTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Redirect $redirect
     * @param  UpdateRedirectRequest $request
     * @return Response
     */
    public function update(Redirect $redirect, UpdateRedirectRequest $request)
    {
        $this->redirect->update($redirect, $request->all());

        return redirect()->route('admin.redirect.redirect.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('redirect::redirects.title.redirects')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Redirect $redirect
     * @return Response
     */
    public function destroy(Redirect $redirect)
    {
        $this->redirect->destroy($redirect);

        return redirect()->route('admin.redirect.redirect.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('redirect::redirects.title.redirects')]));
    }

    private function getRedirectTypes()
    {
        return [
            301 => trans('redirect::redirects.types.permanent'),
            302 => trans('redirect::redirects.types.temporary'),
        ];
    }
}
