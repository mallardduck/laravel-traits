<?php

namespace MallardDuck\LaravelTraits\Http;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Concerns\ManagesLayouts;
use MallardDuck\LaravelTraits\Generic\ManagesLayoutSections;

/**
 * Adds Blade section management to controllers.
 *
 * @property Factory|ManagesLayouts $viewFactory
 */
trait ControllerManagesSections
{
    use ManagesLayoutSections;

    /**
     * @var array
     */
    protected $bladeSections = [];

    /**
     * @var bool
     */
    private $sectionsProcessed = false;

    /**
     * @var array
     */
    private $orgBladeSections = [];

    /**
     * Boots the trait and sets the constructor defined section data.
     */
    public function bootManagesSections()
    {
        $this->setControllerSections();
    }

    /**
     * Helper method to loop thru the controller set Blade sections.
     */
    public function setControllerSections()
    {
        foreach ($this->bladeSections as $name => $section) {
            if (true === $this->sectionsProcessed &&
                $this->sectionDataDiffers($this->orgBladeSections, $this->bladeSections, $name)
            ) {
                $this->overwriteSectionData($name, $section);
            } elseif (false === $this->sectionsProcessed ||
              (
                  true === $this->sectionsProcessed &&
                  !$this->sectionDataDiffers($this->orgBladeSections, $this->bladeSections, $name)
              )
            ) {
                $this->pushSectionData($name, $section);
            }
        }

        // On the first run thru, mark things as processed & keep a copy of OG data.
        if (false === $this->sectionsProcessed) {
            $this->orgBladeSections = $this->bladeSections;
            $this->sectionsProcessed = true;
        }
    }
}
