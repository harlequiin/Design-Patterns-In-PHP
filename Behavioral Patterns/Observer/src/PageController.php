<?php
declare(strict_types=1);

namespace harlequiin\Patterns\Observer;

use SplObjectStorage;

/**
 * Concrete Subject.
 *
 * Stores references its observers; any number of observers may subscribe
 * to the subject.
 * Provides an interface for attaching/detaching observer objects.
 * As Concrete Subject - stores the state that is of interest to interest to
 * Concrete Observer objects.
 * Sends a notification to its observers whenever its state changes.
 */
class PageController
{
    /**
     * @var string
     */
    protected $data;

    /**
     * @var SplObjectStorage
     */
    protected $views;

    public function __construct()
    {
        $this->views = new SplObjectStorage();
    }

    public function attach(ViewInterface $view): PageController
    {
        $this->views->attach($view);

        return $this;
    }

    public function updateData(string $data): PageController
    {
        $this->data = $data;
        $this->notify();

        return $this;
    }

    protected function notify(): void
    {
        foreach($this->views as $view) {
            $view->render($this->data);
        }
    }

    public function detach(ViewInterface $view): PageController
    {
        $this->views->detach($view);

        return $this;
    }
}
