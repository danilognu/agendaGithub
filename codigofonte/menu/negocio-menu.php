<?php
include 'persistencia-menu.php';

class menuBO{ 



    public function ListaMenu(){


        $loMenu = new menuBOA();

        $loListaMenu =  $loMenu->ListaMenu();

        return $loListaMenu;

     
    }

    public function ListaSubMenu($mbArea){
        
         $loMenu = new menuBOA();

        $loListaMenu =  $loMenu->ListaSubMenu($mbArea);

        return $loListaMenu;

    }


}  






?>