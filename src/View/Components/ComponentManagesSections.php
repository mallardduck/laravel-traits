<?php

namespace MallardDuck\LaravelTraits\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Concerns\ManagesLayouts;
use MallardDuck\LaravelTraits\Generic\ManagesLayoutSections;

/**
 * Adds Blade section management to components.
 *
 * @property Factory|ManagesLayouts $viewFactory
 */
trait ComponentManagesSections
{
    use ManagesLayoutSections;

    /**
     * @var array
     */
    protected $componentSections = [];

    /**
     * @var bool
     */
    private $sectionsProcessed = false;

    /**
     * @var array
     */
    private $originalSections = [];

    /**
     * Boots the trait and sets the constructor defined section data.
     */
    public function bootComponentManagesSections()
    {
        $this->setComponentSections();
    }

    /**
     * Helper method to loop thru the controller set Blade sections.
     */
    public function setComponentSections()
    {
        foreach ($this->componentSections as $name => $section) {
            if (true === $this->sectionsProcessed &&
                $this->sectionDataDiffers($this->originalSections, $this->componentSections, $name)
            ) {
                $this->overwriteSectionData($name, $section);
            } elseif (false === $this->sectionsProcessed ||
              (
                  true === $this->sectionsProcessed &&
                  !$this->sectionDataDiffers($this->originalSections, $this->componentSections, $name)
              )
            ) {
                $this->pushSectionData($name, $section);
            }
        }

        // On the first run thru, mark things as processed & keep a copy of OG data.
        if (false === $this->sectionsProcessed) {
            $this->originalSections = $this->componentSections;
            $this->sectionsProcessed = true;
        }
    }
}
