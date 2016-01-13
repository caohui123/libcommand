<?php

namespace AppBundle\Resources\Services;

use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use AppBundle\Entity\Staff;

class ListService{
  private $router;
  
  public function __construct(Router $router)
  {
      $this->router = $router;
  }
  
  public function staffAreasList(array $entities){    
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
  
  public function liaisonSubjectsList(array $entities){    
    $styled_list = '';
    
    //Parents (Level 1)
    $parent_count = 0;
    foreach($entities as $entity){
      $level = $entity->getLvl();
      if($level == 0){
        $styled_list .= '
          <div class="panel panel-default">
          <div class="panel-heading">'.$entity->getName().' <a class="badge" href="'.$this->router->generate('liaisonsubject_edit', array('id'=>$entity->getId())).'">Edit</a></div>
          <div class="panel-body">
            

          <!-- Table -->
          <table class="table">
            <thead>
              <tr>
                <th>Department</th>
                <th>Primary Liaison</th>
                <th>Secondary Liaison</th>
                <th>Phone Number</th>
                <th>Faculty Liaison</th>
              </tr>
            </thead>
        ';
        
        //Children (Level 2)
        $children = $entity->getChildren();
        $child_count = 0;
        foreach($children as $child){
          
          $primary_liaison = $this->_packageLiaison($child->getPrimaryLiaison());
          $secondary_liaison = $this->_packageLiaison($child->getSecondaryLiaison());
          $phone = $child->getPhone();
          $faculty_liaison = $child->getFacultyName();
          $faculty_phone = $child->getFacultyPhone();
          $faculty_office = $child->getFacultyOffice();
          
          $styled_list .= '<tr>';
          $styled_list .= '<td><a href="'.$this->router->generate('liaisonsubject_edit', array('id'=>$child->getId())).'">'.$child->getName().'</a></td>';
          $styled_list .= '<td>'.$primary_liaison.'</td>';
          $styled_list .= '<td>'.$secondary_liaison.'</td>';
          $styled_list .= '<td>'.$phone.'</td>';
          $styled_list .= '<td>'.$faculty_liaison.'<br>'.$faculty_phone.'<br>'.$faculty_office.'</td>';
          $styled_list .= '</tr>';
          
          //Grand Children (Level 3)
          $grandchildren = $child->getChildren();
          $grandchild_count = 0;
          foreach($grandchildren as $grandchild){
            $gc_primary_liaison = $this->_packageLiaison($grandchild->getPrimaryLiaison());
            $gc_secondary_liaison = $this->_packageLiaison($grandchild->getSecondaryLiaison());
            $phone = $grandchild->getPhone();
            $faculty_liaison = $grandchild->getFacultyName();
            $faculty_phone = $grandchild->getFacultyPhone();
            $faculty_office = $grandchild->getFacultyOffice();
            
            $styled_list .= '<tr>';
            $styled_list .= '<td><span class="glyphicon glyphicon-chevron-up"></span> <a href="'.$this->router->generate('liaisonsubject_edit', array('id'=>$grandchild->getId())).'">'.$grandchild->getName().'</a></td>';
            $styled_list .= '<td>'.$gc_primary_liaison.'</td>';
            $styled_list .= '<td>'.$gc_secondary_liaison.'</td>';
            $styled_list .= '<td>'.$phone.'</td>';
            $styled_list .= '<td>'.$faculty_liaison.'<br>'.$faculty_phone.'<br>'.$faculty_office.'</td>';
            $styled_list .= '</tr>';
            
            $grandchild_count++;
          }
        }
        $styled_list .= '
          </table>
          </div>
        </div><!--#end parent div-->
        ';
        $child_count++;
      }
      
      $parent_count++;
    } //end parent foreach
    
    return $styled_list;
  }
  
  public function libraryDepartmentsList(array $entities){    
    $styled_list = '';
    $styled_list .= '<div class="just-padding"><div class="list-group list-group-root well">';
    
    //Parents (Level 1)
    $parent_count = 0;
    foreach($entities as $entity){
      $level = $entity->getLvl();
      if($level == 0){
        $styled_list .= 
            '<a href="#item-'.$parent_count.'" class="list-group-item" data-toggle="collapse">'.$entity->getName().'<span class="badge" onclick="location.href=\''.$this->router->generate('department_edit', array('id'=>$entity->getId())).'\'">Edit</span></a>';
        $styled_list .= '<div class="list-group" id="item-'.$parent_count.'">';
        
        
        //Children (Level 2)
        $children = $entity->getChildren();
        
        $child_count = 0;
        foreach($children as $child){
          $styled_list .= 
              '<a href="#item-'.$parent_count.'-'.$child_count.'" class="list-group-item" data-toggle="collapse">'.$child->getName().'<span class="badge" onclick="location.href=\''.$this->router->generate('department_edit', array('id'=>$child->getId())).'\'">Edit</span></a>';
          $styled_list .= '<div class="list-group collapse" id="item-'.$parent_count.'-'.$child_count.'">';
          
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
   * Package a staff's name and ID for useage in the liaison subject table
   * 
   * @param Staff $liaison The Staff entity
   * @return String $package The packaged anchor tag with Staff information
   */
  private function _packageLiaison(Staff $liaison = null){
    $package = '';
    
    if($liaison instanceof Staff){
      $name = $liaison->getLastName(). ', '. $liaison->getFirstName();
      $id = $liaison->getId();

      $package = '<a href="'.$this->router->generate('staff_show', array('id'=>$id)).'">'.$name.'</a>';
    };
    
    return $package;
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

