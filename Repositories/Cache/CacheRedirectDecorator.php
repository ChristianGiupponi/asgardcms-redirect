<?php

namespace Modules\Redirect\Repositories\Cache;

use Modules\Redirect\Repositories\RedirectRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRedirectDecorator extends BaseCacheDecorator implements RedirectRepository
{
    public function __construct(RedirectRepository $redirect)
    {
        parent::__construct();
        $this->entityName = 'redirect.redirects';
        $this->repository = $redirect;
    }
}
