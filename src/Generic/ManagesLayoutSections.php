<?php

namespace MallardDuck\LaravelTraits\Generic;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Concerns\ManagesLayouts;

/**
 * Trait ManagesLayoutSections
 *
 * @package MallardDuck\LaravelTraits\Generic
 *
 * @property null|Factory&ManagesLayouts $viewFactory
 */
trait ManagesLayoutSections
{
    /**
     * @return Factory&ManagesLayouts
     */
    public function getViewFactory(): Factory
    {
        return $this->viewFactory ?? app('view');
    }

    /**
     * @param array  $original
     * @param array  $current
     * @param string $sectionName
     *
     * @return bool
     */
    private function sectionDataDiffers(array $original, array $current, string $sectionName): bool
    {
        if (false === isset($original[$sectionName])) {
            return false;
        }
        return $original[$sectionName] !== $current[$sectionName];
    }

    private function pushSectionData($name, $section)
    {
        $this->getViewFactory()->startSection($name, $section);
    }

    private function overwriteSectionData($name, $section)
    {
        $this->getViewFactory()->startSection($name, null);
        echo $section;
        $this->getViewFactory()->stopSection(true); // pass true to overwrite prior section content
    }
}