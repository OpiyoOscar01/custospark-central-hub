<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpgradeBadge extends Component
{
    public string $app;

    /**
     * Create a new component instance.
     */
    public function __construct(string $app)
    {
        $this->app = $app;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.upgrade-badge');
    }
}
