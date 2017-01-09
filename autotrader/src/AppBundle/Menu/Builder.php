<?php

namespace AppBundle\Menu;

class Builder{

    public function mainMenu(MenuFactory $factory, array $options){
      $menu = $factory->createItem('root');
      $menu->addChild('Home', ['route' => 'homepage']);
      return $menu;
    }
}


 ?>
