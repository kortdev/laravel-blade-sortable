<?php


namespace Asantibanez\LaravelBladeSortable\Components;


use Illuminate\View\Component;

class Sortable extends Component
{
    public $as;

    public $component;

    public $name;

    public $animation;

    public $ghostClass;

    public $dragHandle;

    public $group;

    public function __construct($as = null,
                                $component = null,
                                $name = null,
                                $animation = 150,
                                $ghostClass = '',
                                $dragHandle = null,
                                $group = null)
    {
        $this->as = $as;
        $this->component = $component;
        $this->name = $name;
        $this->animation = $animation;
        $this->ghostClass = $ghostClass;
        $this->dragHandle = $dragHandle;
        $this->group = $group;
    }

    public function xInit()
    {
        $wireOnSortOrderChange = $this->attributes
                                    ->whereStartsWith('wire:onSortOrderChange')
                                    ->first();


        $wireOnSortOrderAdd = $this->attributes
                                    ->whereStartsWith('wire:onSortOrderAdd')
                                    ->first();

        $hasWireOnSortOrderChangeDirective = $wireOnSortOrderChange !== null;
        $hasWireOnSortOrderAddDirective = $wireOnSortOrderAdd !== null;
        $hasDragHandle = $this->dragHandle !== null;
        $hasGroup = $this->group !== null;

        $collection = collect()
            ->push("animation = {$this->animation}")
            ->push("ghostClass = '{$this->ghostClass}'")
            ->push($hasDragHandle ? "dragHandle = '.{$this->dragHandle}'" : null)
            ->push($hasGroup ? "group = '{$this->group}'" : null);

        $collection->push(($hasWireOnSortOrderChangeDirective || $hasWireOnSortOrderAddDirective) ? 'wireComponent = $wire' : null);

        $collection->push($hasWireOnSortOrderChangeDirective ? "wireOnSortOrderChange = '$wireOnSortOrderChange'" : null);

        $collection->push($hasWireOnSortOrderAddDirective ? "wireOnSortOrderAdd = '$wireOnSortOrderAdd'" : null);

        return $collection->push('init()')->filter(function ($line) {
                    return $line !== null;
                })->join('; ');
    }

    public function render()
    {
        return view('laravel-blade-sortable::components.sortable');
    }
}
