<?php
namespace App\View\Components;

use Illuminate\View\Component;

class FeatureNavItem extends Component
{
    public string $app;
    public string $feature;
    public string $label;
    public string $icon;
    public string $routeName;

    public  $isNew;


    public function __construct($app, $feature, $label, $icon, $routeName, $isNew = false)
    {
        $this->app = $app;
        $this->feature = $feature;
        $this->label = $label;
        $this->icon = $icon;
        $this->routeName = $routeName;
        $this->isNew = $isNew;

    }

    public function render()
    {
        return view('components.feature-nav-item');
    }
}


