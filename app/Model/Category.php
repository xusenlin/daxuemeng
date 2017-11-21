<?php

namespace App\Model;

use Baum\Node;

class Category extends Node
{

    const ROOT_NAME = "ROOT";
    const ROOT_CATEGORY_ID = 1;

    /**
     * 获取一个分类的所有子元素id
     * @param $id
     * @return array
     */
    static public function getAllSiblingsAndSelfId($id){
        $root = Category::find($id);
        $result = $root->getDescendantsAndSelf();
        $categoryId = array();
        foreach ($result as $item){
            $categoryId[] = $item->id;
        }
        return $categoryId;
    }

}
