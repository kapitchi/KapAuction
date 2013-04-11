<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class KapRealProperty implements PluginInterface
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'TODO';
    }

    public function getName()
    {
        return '[KapAuction] RealProperty item type';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $sharedEm = $em->getSharedManager();
        
        //adds type to the form
        $sharedEm->attach('KapAuction\Form\Item', 'init', function($e) {
            $form = $e->getTarget();
            $typeHandle = $form->get('typeHandle');
            $valueOptions = $typeHandle->getValueOptions();
            $valueOptions[] = array(
                'label' => 'Real property',
                'value' => 'realproperty'
            );
            $typeHandle->setValueOptions($valueOptions);
        });
        
        $sharedEm->attach('KapAuction\Form\Item', 'init', function($e) use ($sm) {
            $input = $e->getTarget();
            
            $propertyForm = $sm->get('KapRealProperty\Form\Property');
            $propertyForm->remove('title');
            $propertyForm->remove('description');
            
            $input->add($propertyForm, array(
                'name' => 'realproperty'
            ));
        });
        
        $sharedEm->attach('KapAuction\Form\ItemInputFilter', 'init', function($e) use ($sm) {
            $input = $e->getTarget();
            $inputFilter = $sm->get('KapRealProperty\Form\PropertyInputFilter');
            $inputFilter->remove('title');
            $inputFilter->remove('description');
            $input->add($inputFilter, 'realproperty');
        });
        
        $sharedEm->attach('KapAuction\Form\ItemInputFilter', 'isValid.pre', function($e) use ($sm) {
            $ins = $e->getTarget();
            if($ins->getRawValue('typeHandle') != 'realproperty') {
                $group = $ins->getValidationGroup();
                if(($key = array_search('realproperty', $group)) !== false) {
                    unset($group[$key]);
                    $ins->setValidationGroup($group);
                }
            }
        });
        
        $sharedEm->attach('KapAuction\Service\Item', 'persist', function($e) use ($sm) {
            $data = $e->getParam('data');
            $entity = $e->getParam('entity');
            
            if(isset($data['realproperty'])) {
                //$e->setParam('realproperty', $sm->get('KapAuction\Service\RealPropertyItem'));
                $propertyItemService = $sm->get('KapAuction\Service\RealPropertyItem');
                $propertyService = $sm->get('KapRealProperty\Service\Property');
                $property = $propertyService->createEntityFromArray($data['realproperty']);
                
                //copy items title/desc to address
                $property->setTitle($entity->getTitle());
                $property->setDescription($entity->getDescription());
                $propEvent = $propertyService->persist($property, $data['realproperty']);
                $e->setParam('propertyEvent', $propEvent);
                
                $propertyItem = $propertyItemService->findOneBy(array(
                    'itemId' => $entity->getId(),
                    'propertyId' => $property->getId(),
                ));
                if(!$propertyItem) {
                    $ent = $propertyItemService->createEntityFromArray(array(
                        'itemId' => $entity->getId(),
                        'propertyId' => $property->getId(),
                    ));
                    $propertyItemService->persist($ent);
                }
            }
        });
        
        $sharedEm->attach('KapAuction\Controller\ItemController', 'update.load', function($e) use ($sm) {
            $entity = $e->getParam('entity');
            $form = $e->getParam('form');
            
            $propertyItemService = $sm->get('KapAuction\Service\RealPropertyItem');
            $item = $propertyItemService->findOneBy(array(
                'itemId' => $entity->getId()
            ));
            if($item) {
                $propertyService = $sm->get('KapRealProperty\Service\Property');
                $property = $propertyService->find($item->getPropertyId());
                $arr = $propertyService->createArrayFromEntity($property);
                $form->get('realproperty')->setData($arr);
            }
        });
    }
    
}