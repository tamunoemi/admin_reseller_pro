<?php

namespace Teckipro\Admin\Http\Controllers;

/**
 * Class FileManagerController
 */
class FileManagerController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('teckiproadmin::file_manager');
    }
}
