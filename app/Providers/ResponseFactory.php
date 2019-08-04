<?php

namespace App\Providers;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory as BaseFactory;

class ResponseFactory extends BaseFactory
{
    /**
     * Create a new response factory instance.
     *
     * @param  \Illuminate\Contracts\View\Factory  $view
     * @param  \Illuminate\Routing\Redirector  $redirector
     * @return void
     */
    public function __construct(Redirector $redirector)
    {
        $this->redirector = $redirector;
    }
}
