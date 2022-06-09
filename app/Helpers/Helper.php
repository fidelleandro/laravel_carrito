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
    
    public static function buildTreeHtml(&$html,array $lista,$parent_id = 0){
        //$html= '';
        foreach ($lista as $key => $item) { 
            //******************BLOQUE 1 - IF************** */
            if ($parent_id == 0) { // Si es superior
                if (0 < $item['Count']) {//si el privilegio padre tiene hijos, hacer
                    $html.= '<li class="nav-item">';
                    $html.=   '<a href="" class="">'; 
                    $html.=     '<i class="nav-icon fas fa-search"></i>';
                    $html.=     '<p>'.$item["label"].'<i class="fas fa-angle-left right"></i></p>';
                    $html.=   '</a>';
                    $html.=   '<ul class="nav nav-treeview">';
                }
                else{ //El menu superior no tiene hijos
                    $html.= '<li class="nav-item">';
                    $html.=   '<a href="" class="">'; 
                    $html.=     '<i class="nav-icon fas fa-search"></i>';
                    $html.=     '<p>'.$item["label"].'</p>';
                    $html.=   '</a>';
                    $html.= '</li>';
                }
            }
            else{
                    $html.= '<li class="nav-item">';
                    $html.=   '<a href="" class="">'; 
                    $html.=     '<i class="nav-icon fas fa-search"></i>';
                    $html.=     '<p>'.$item["label"].'</p>';
                    $html.=   '</a>';
                    $html.= '</li>';
            }
            //*****************FIN BLOQUE 1 IF*************** */
            //****************BLOQUE 2 IF**************** */
            if (isset($item["children"])) {//EL ELEMENTO TIENE HIJOS???
                $html.= Helper::buildTreeHtml($html,$item["children"],$item["id"]);
                $html.= '</ul>';
                $html.= '</li>';
            }
            //******************************** */
        }
        //return $html;
    }
    public static function objectToArray($object){
        if (is_object($object) || is_array($object)) {
            $data = (array)$object;//conversion forzada de objecto a array
            foreach ($data as $key => &$item) {
                $item = Helper::objectToArray($item);
            }
            return $data;
        }
        else{
            return $object;
        }
    } 
}