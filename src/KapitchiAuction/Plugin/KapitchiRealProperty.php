<?php
namespace KapitchiAuction\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class KapitchiRealProperty implements PluginInterface
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
        return '[KapitchiAuction] RealProperty item type';
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
        $sharedEm->attach('KapitchiAuction\Form\Item', 'init', function($e) {
            $form = $e->getTarget();
            $typeHandle = $form->get('typeHandle');
            $valueOptions = $typeHandle->getValueOptions();
            $valueOptions[] = array(
                'label' => 'Real property',
                'value' => 'realproperty'
            );
            $typeHandle->setValueOptions($valueOptions);
        });
        
        $sharedEm->attach('KapitchiAuction\Form\Item', 'init', function($e) use ($sm) {
            $input = $e->getTarget();
            
            $propertyForm = $sm->get('KapitchiRealProperty\Form\Property');
            $propertyForm->remove('title');
            $propertyForm->remove('description');
            
            $input->add($propertyForm, array(
                'name' => 'realproperty'
            ));
        });
        
        $sharedEm->attach('KapitchiAuction\Form\ItemInputFilter', 'init', function($e) use ($sm) {
            $input = $e->getTarget();
            $inputFilter = $sm->get('KapitchiRealProperty\Form\PropertyInputFilter');
            $inputFilter->remove('title');
            $inputFilter->remove('description');
            $input->add($inputFilter, 'realproperty');
        });
        
        $sharedEm->attach('KapitchiAuction\Form\ItemInputFilter', 'isValid.pre', function($e) use ($sm) {
            $ins = $e->getTarget();
            if($ins->getRawValue('typeHandle') != 'realproperty') {
                $group = $ins->getValidationGroup();
                if(($key = array_search('realproperty', $group)) !== false) {
                    unset($group[$key]);
                    $ins->setValidationGroup($group);
                }
            }
        });
        
        $sharedEm->attach('KapitchiAuction\Service\Item', 'persist', function($e) use ($sm) {
            $data = $e->getParam('data');
            $entity = $e->getParam('entity');
            
            if(isset($data['realproperty'])) {
                //$e->setParam('realproperty', $sm->get('KapitchiAuction\Service\RealPropertyItem'));
                $propertyItemService = $sm->get('KapitchiAuction\Service\RealPropertyItem');
                $propertyService = $sm->get('KapitchiRealProperty\Service\Property');
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
        
        $sharedEm->attach('KapitchiAuction\Controller\ItemController', 'update.load', function($e) use ($sm) {
            $entity = $e->getParam('entity');
            $form = $e->getParam('form');
            
            $propertyItemService = $sm->get('KapitchiAuction\Service\RealPropertyItem');
            $item = $propertyItemService->findOneBy(array(
                'itemId' => $entity->getId()
            ));
            if($item) {
                $propertyService = $sm->get('KapitchiRealProperty\Service\Property');
                $property = $propertyService->find($item->getPropertyId());
                $arr = $propertyService->createArrayFromEntity($property);
                $form->get('realproperty')->setData($arr);
            }
        });
    }
    
}