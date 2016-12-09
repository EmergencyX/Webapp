<?php

namespace EmergencyExplorer\Http\View\Composers;

use EmergencyExplorer\Util\Image\ImageUtil;
use Illuminate\View\View;

class ImageComposer
{
    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * ImageComposer constructor.
     *
     * @param ImageUtil $imageUtil
     */
    public function __construct(ImageUtil $imageUtil)
    {
        $this->imageUtil = $imageUtil;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('imageUtil', $this->imageUtil);
    }
}
