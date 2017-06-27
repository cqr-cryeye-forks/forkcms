<?php

namespace Backend\Modules\Profiles\Actions;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Engine\Base\ActionDelete as BackendBaseActionDelete;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Form\Type\DeleteType;
use Backend\Modules\Profiles\Engine\Model as BackendProfilesModel;

/**
 * This action will delete a membership of a profile in a group.
 */
class DeleteProfileGroup extends BackendBaseActionDelete
{
    public function execute(): void
    {
        $deleteForm = $this->createForm(
            DeleteType::class,
            null,
            ['module' => $this->getModule(), 'action' => 'DeleteProfileGroup']
        );
        $deleteForm->handleRequest($this->getRequest());
        if (!$deleteForm->isSubmitted() || !$deleteForm->isValid()) {
            $this->redirect(BackendModel::createURLForAction('Index', null, null, ['error' => 'something-went-wrong']));

            return;
        }
        $deleteFormData = $deleteForm->getData();

        $this->id = (int) $deleteFormData['id'];

        // does the item exist
        if ($this->id === 0 || !BackendProfilesModel::existsProfileGroup($this->id)) {
            $this->redirect(BackendModel::createURLForAction('Index', null, null, ['error' => 'non-existing']));

            return;
        }

        parent::execute();

        $profileGroup = BackendProfilesModel::getProfileGroup($this->id);

        BackendProfilesModel::deleteProfileGroup($this->id);

        $this->redirect(BackendModel::createURLForAction(
            'Edit',
            null,
            null,
            ['id' => $profileGroup['profile_id'], 'report' => 'membership-deleted']
        ) . '#tabGroups');
    }
}
