<?php

namespace TalentAsia\Form\ErrorStore;

interface ErrorStoreInterface
{
    public function hasError($key);

    public function getError($key);
}
