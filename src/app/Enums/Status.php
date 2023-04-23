<?php

namespace App\Enums;

/**
 * Enumerador referente aos status dos produtos na aplicação
 */
class Status {
    // A sintaxe _enum_  não foi utilizada pois o php atual é o 8, não o 8.1

    const DRAFT = 'draft';

    const TRASH = 'trash';

    const PUBLISHED = 'published';
}