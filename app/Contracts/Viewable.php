<?php

namespace App\Contracts;

interface Viewable
{
    public function views();

    public function isViewedBy($user);

    public function view($user);
}
