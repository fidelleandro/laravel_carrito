<?php
namespace App\Helpers;
class Helper {

    public static function buildTree(array $lista,$parent_id = 0){
        $build = array(); //Este array contiene todos los elementos con sus hijos
        foreach ($lista as $elemento) {
            if ($elemento['parent'] == $parent_id) { //Estoy dentro del elemento padre
                /**Encontrar todos los hijos del padre con recursividad */
                $children = Helper::buildTree($lista,$elemento['id']); //$parent_id = al id del elemento
                if ($children) { // si encuentra un hijo
                    $elemento['children'] = $children;
                }
                $build[] = $elemento; //La variable build contiene todos los elementos con sus hijos.
                //[] es igual a un contador desde 0 y aumenta de 1 en 1
            }
        }
        return $build;
    }
    public function objectToArray($object){
        if (is_object($object) || is_array($object)) {
          
        }

    } 
}