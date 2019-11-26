<?php

namespace Backend\Modules\Pages\Domain\Page;

use Common\Doctrine\Entity\Meta;
use Common\Locale;
use DateTime;

class PageDataTransferObject
{
    /** @var Page|null */
    public $page;

    /** @var int */
    public $id;

    /** @var int */
    public $revisionId;

    /** @var int */
    public $userId;

    /** @var int */
    public $parentId;

    /** @var int */
    public $templateId;

    /** @var Meta */
    public $meta;

    /** @var Locale */
    public $locale;

    /** @var Type */
    public $type;

    /** @var string */
    public $title;

    /** @var string */
    public $navigationTitle;

    /** @var bool */
    public $navigationTitleOverwrite;

    /** @var bool */
    public $hidden;

    /** @var string */
    public $status;

    /** @var DateTime */
    public $publishOn;

    /** @var array|null */
    public $data;

    /** @var DateTime */
    public $createdOn;

    /** @var DateTime */
    public $editedOn;

    /** @var bool */
    public $allowMove;

    /** @var bool */
    public $allowChildren;

    /** @var bool */
    public $allowEdit;

    /** @var bool */
    public $allowDelete;

    /** @var int */
    public $sequence;

    protected function __construct(Page $page = null)
    {
        $this->page = $page;

        if (!$this->hasExistingPage()) {
            $this->allowChildren = true;
            $this->allowDelete = true;
            $this->allowEdit = true;
            $this->allowMove = true;

            return;
        }

        $this->id = $this->page->getId();
        $this->revisionId = $this->page->getRevisionId();
        $this->userId = $this->page->getUserId();
        $this->parentId = $this->page->getParentId();
        $this->templateId = $this->page->getTemplateId();
        $this->meta = $this->page->getMeta();
        $this->locale = $this->page->getLocale();
        $this->type = $this->page->getType();
        $this->title = $this->page->getTitle();
        $this->navigationTitle = $this->page->getNavigationTitle();
        $this->navigationTitleOverwrite = $this->page->isNavigationTitleOverwrite();
        $this->hidden = $this->page->isHidden();
        $this->status = $this->page->getStatus();
        $this->publishOn = $this->page->getPublishOn();
        $this->data = $this->page->getData();
        $this->createdOn = $this->page->getCreatedOn();
        $this->editedOn = $this->page->getEditedOn();
        $this->allowMove = $this->page->isAllowMove();
        $this->allowChildren = $this->page->isAllowChildren();
        $this->allowEdit = $this->page->isAllowEdit();
        $this->allowDelete = $this->page->isAllowDelete();
        $this->sequence = $this->page->getSequence();
    }

    public function getPageEntity(): Page
    {
        return $this->page;
    }

    public function hasExistingPage(): bool
    {
        return $this->page instanceof Page;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    public function getId(): ?int
    {
        if ($this->hasExistingPage()) {
            return $this->page->getId();
        }

        return null;
    }
}
