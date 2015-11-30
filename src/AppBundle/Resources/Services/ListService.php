<?php

namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class ListService{
  private $router;
  
  public function __construct(Router $router)
  {
      $this->router = $router;
  }
  
  public function collapsibleList($entities){    
    $styled_list = '';
    $styled_list .= '<div class="just-padding"><div class="list-group list-group-root well">';
    
    //Parents (Level 1)
    $parent_count = 0;
    foreach($entities as $entity){
      $level = $entity->getLvl();
      if($level == 0){
        $styled_list .= 
            //'<a href="#item-'.$parent_count.'" class="list-group-item" data-toggle="collapse"><i class="glyphicon glyphicon-chevron-right"></i>'.$entity->getTitle().'</a>';
            '<a href="#item-'.$parent_count.'" class="list-group-item" data-toggle="collapse">'.$entity->getTitle().'<span class="badge" onclick="location.href=\''.$this->router->generate('admin_staffareas_edit', array('id'=>$entity->getId())).'\'">Edit</span></a>';
        $styled_list .= '<div class="list-group" id="item-'.$parent_count.'">';
        
        
        //Children (Level 2)
        $children = $entity->getChildren();
        
        $child_count = 0;
        foreach($children as $child){
          $styled_list .= 
              //'<a href="#item-'.$parent_count.'-'.$child_count.'" class="list-group-item" data-toggle="collapse"><i class="glyphicon glyphicon-chevron-right"></i>'.$child->getTitle().'</a>';
              '<a href="#item-'.$parent_count.'-'.$child_count.'" class="list-group-item" data-toggle="collapse">'.$child->getTitle().'<span class="badge" onclick="location.href=\''.$this->router->generate('admin_staffareas_edit', array('id'=>$child->getId())).'\'">Edit</span></a>';
          $styled_list .= '<div class="list-group collapse" id="item-'.$parent_count.'-'.$child_count.'">';
          
          //Grandchildren (level 3)
          $grandchildren = $child->getChildren();
          
          $grandchild_count = 0;
          foreach($grandchildren as $grandchild){
            $styled_list .= 
              '<a href="#" class="list-group-item">'.$grandchild->getTitle().'</a>';
            $styled_list .= '<div class="list-group collapse" id="item-'.$parent_count.'-'.$child_count.'-'.$grandchild_count.'">';
            $styled_list .= '</div>';
            $grandchild_count++;
          }
          
          $styled_list .= '</div>';
          $child_count++;
        }
        $parent_count++;
        
        $styled_list .= '</div>';
      }
    }
    
    $styled_list .= '</div></div>';
    return $styled_list;
  }
  
  /**
   * Count how many node levels there are in the entity list (parents + children + grand children, etc.)
   * @param AppBundle\Entity\StaffArea $entities
   * @return int The number of node levels.
   */
  private function _countNodeLevels($entities){
    $node_levels = array(); //gather the first node at each level
    $num_node_levels = 0; //how many parents (level 1) and children are there?
    foreach($entities as $entity){
      $node_level = $entity->getLvl();
      if(!in_array($node_level, $node_levels)){
        $node_levels[] = $node_level;
        $num_node_levels++;
      }
    }
    return $num_node_levels;
  }
}

