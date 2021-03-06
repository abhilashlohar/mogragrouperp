<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemSubGroup Entity
 *
 * @property int $id
 * @property int $item_group_id
 * @property string $name
 *
 * @property \App\Model\Entity\ItemGroup $item_group
 * @property \App\Model\Entity\Item[] $items
 */
class ItemSubGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
