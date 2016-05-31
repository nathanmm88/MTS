<?php
namespace App\API;

use App\API\AbstractCall;
use App\Lib\DotNotation;
use App\Entity\Menu\MenuSectionEntity;
use App\Entity\Menu\MenuItemEntity;
use App\Entity\Menu\MenuItemVariationEntity;
use App\Entity\Menu\CondimentEntity;
use App\Entity\Menu\CondimentTypeEntity;

class GetMenuCall extends AbstractCall {

    public function handleResult($response) {
        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);
      
        //set the takeaway details
        $this->menu->setId($responseDotNotation->get('Menu.MenuID'))
                ->setTakeawayID($responseDotNotation->get('Menu.TakeawayID'))
                ->setDescription($responseDotNotation->get('Menu.MenuDescription'));
     
        //loop through the sections 
        foreach ($responseDotNotation->get('MenuSections') as $key => $section) {

            //set in the dot notation
            $sectionDotNotation = new DotNotation($section['MenuSection']);

            //set the values to the entity
            $sectionEntity = MenuSectionEntity::fromArray([
                        'id' => $sectionDotNotation->get('MenuSectionID'),
                        'menu_id' => $sectionDotNotation->get('MenuID'),
                        'name' => $sectionDotNotation->get('MenuSectionName'),
                        'description' => $sectionDotNotation->get('MenuSectionDesc'),
                        'active' => $sectionDotNotation->get('Active'),
                        'position' => $sectionDotNotation->get('Position'),
                            ], $this->request);

            //save this entity to the session
            $this->menu->addSection($sectionEntity);

            //loop through each menu item
            foreach ($section['MenuItems'] as $item) {

                //set in the dot notation
                $itemDotNotation = new DotNotation($item);

                //set the values
                $menuItem = MenuItemEntity::fromArray([
                            'id' => $itemDotNotation->get('MenuItem.MenuItemID'),
                            'section_id' => $itemDotNotation->get('MenuItem.MenuSectionID'),
                            'reference' => $itemDotNotation->get('MenuItem.MenuItemReference', 'TBC'),
                            'name' => $itemDotNotation->get('MenuItem.MenuItemName'),
                            'description' => $itemDotNotation->get('MenuItem.MenuItemDesc'),
                            'price' => $itemDotNotation->get('MenuItem.Price'),
                            'active' => $itemDotNotation->get('MenuItem.Active'),
                            'deleted' => $itemDotNotation->get('MenuItem.Deleted'),
                            'position' => $itemDotNotation->get('MenuItem.Position'),
                            'heat' => $itemDotNotation->get('MenuItem.Heat'),
                            'vegetarian' => $itemDotNotation->get('MenuItem.Vegetarian'),
                            'gluten_free' => $itemDotNotation->get('MenuItem.GlutenFree'),
                            'dairy_free' => $itemDotNotation->get('MenuItem.DairyFree'),
                            'may_contain_bones' => $itemDotNotation->get('MenuItem.MayContainBones'),
                            'has_variations' => ((count($itemDotNotation->get('Variations')) > 0) ? true : false)
                                ], $this->request);

                //save this entity to the session
                $this->menu->addItem($menuItem);


                foreach ($itemDotNotation->get('Variations') as $variation) {

                    //set in the dot notation
                    $variationDotNotation = new DotNotation($variation);

                    $variationEntity = MenuItemVariationEntity::fromArray([
                                'id' => $variationDotNotation->get('MenuItem_VariationID'),
                                'parent_id' => $variationDotNotation->get('MenuItemID'),
                                'parent_name' => $itemDotNotation->get('MenuItem.MenuItemName'),
                                'reference' => $itemDotNotation->get('MenuItem.MenuItemReference', 'TBC'),
                                'name' => $variationDotNotation->get('VariationName'),
                                'description' => $variationDotNotation->get('VariationDesc'),
                                'price' => $variationDotNotation->get('Price'),
                                'active' => $variationDotNotation->get('Active'),
                                'deleted' => $variationDotNotation->get('Deleted'),
                                'position' => $variationDotNotation->get('Position'),
                                'heat' => $variationDotNotation->get('Heat'),
                                'vegetarian' => $variationDotNotation->get('Vegetarian'),
                                'gluten_free' => $variationDotNotation->get('GlutenFree'),
                                'dairy_free' => $variationDotNotation->get('DairyFree'),
                                'may_contain_bones' => $variationDotNotation->get('MayContainBones'),
                                    ], $this->request);

                    //save this entity to the session
                    $this->menu->addVariation($variationEntity);
                }
                
                //loop through the condiment types
                foreach ($itemDotNotation->get('CondimentTypes') as $condimentType) {

                    $condimentTypeDotNotation = new DotNotation($condimentType);

                    //set the values
                    $condimentTypeEntity = CondimentTypeEntity::fromArray([
                                'id' => $condimentTypeDotNotation->get('CondimentType.CondimentTypeID'),
                                'item_id' => $itemDotNotation->get('MenuItem.MenuItemID'),
                                'description' => $condimentTypeDotNotation->get('CondimentType.CondimentTypeDesc'),
                                    ], $this->request);

                    //save this entity to the session
                    $this->menu->addCondimentType($condimentTypeEntity);

                    foreach ($condimentTypeDotNotation->get('Condiments') as $condiment) {

                        $condimentDotNotation = new DotNotation($condiment);

                        //set the values to the entity
                        $condimentEntity = CondimentEntity::fromArray([
                                    'id' => $condimentDotNotation->get('CondimentID'),
                                    'condiment_type_id' => $condimentDotNotation->get('CondimentTypeID'),
                                    'name' => $condimentDotNotation->get('CondimentName'),
                                    'description' => $condimentDotNotation->get('CondimentDesc'),
                                    'active' => $condimentDotNotation->get('Active'),
                                    'deleted' => $condimentDotNotation->get('Deleted'),
                                    'additional_cost' => $condimentDotNotation->get('AdditionalCost'),
                                        ], $this->request);

                        //save this entity to the session
                        $this->menu->addCondiment($condimentEntity);
                        
                    }
                }
            }
        }
    }
}
