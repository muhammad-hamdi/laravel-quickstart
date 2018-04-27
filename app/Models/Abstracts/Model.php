<?php

namespace App\Models\Abstracts;

use App\Models\Concerns\Resourcable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use Resourcable, PresentableTrait;

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = '';

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->setResourceName();

        parent::__construct($attributes);
    }
}