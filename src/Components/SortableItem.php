<?php


namespace Asantibanez\LaravelBladeSortable\Components;


use Illuminate\View\Component;
use Exception;

class SortableItem extends Component
{
    public $sortKey;

    public $as;

    public $component;

    public function __construct($sortKey = null, $as = null, $component = null)
    {
        $this->sortKey = $sortKey;
        $this->as = $as;
        $this->component = $component;

        if ($this->sortKey === null) {
            throw new Exception("Must pass 'sort-key' property to Sortable Item");
        }
    }

    public function render()
    {
        return view('laravel-blade-sortable::components.sortable-item');
    }
}
