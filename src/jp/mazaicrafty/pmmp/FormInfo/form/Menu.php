<?php

/*
 * ___  ___               _ _____            __ _
 * |  \/  |              (_)  __ \          / _| |
 * | .  . | __ _ ______ _ _| /  \/_ __ __ _| |_| |_ _   _
 * | |\/| |/ _` |_  / _` | | |   | '__/ _` |  _| __| | | |
 * | |  | | (_| |/ / (_| | | \__/\ | | (_| | | | |_| |_| |
 * \_|  |_/\__,_/___\__,_|_|\____/_|  \__,_|_|  \__|\__, |
 *                                                   __/ |
 *                                                  |___/
 * Copyright (C) 2017-2018 @MazaiCrafty (https://twitter.com/MazaiCrafty)
 *
 * This program is free plugin.
 */

namespace jp\mazaicrafty\pmmp\FormInfo\form;

# Player
use pocketmine\Server;
use pocketmine\Player;

# FormInfo
use jp\mazaicrafty\pmmp\FormInfo\Main;
use jp\mazaicrafty\pmmp\FormInfo\interfaces\CallAction;
use jp\mazaicrafty\pmmp\FormInfo\{EventListener, Provider};

class Menu implements CallAction{

    const CLOSE_BUTTON = 0;
    const STATUS_BUTTON = 1;
    const CONSOLE_BUTTON = 2;

    /**
     * @var Main
     */
    private $main;

    /**
     * @param Main $main
     */
    public function __construct(Main $main){
        $this->main = $main;
    }

    /**
     * @param Player $player
     */
    public function createMenu(Player $player){
        $form = $this->getMain()->getForm()->createSimpleForm(
            function (Player $player, $result) {
                if($result === null) return;// NOTE: Cancelled

                switch ($result){
                    case Menu::CLOSE_BUTTON:
                    // Close the Menu
                    return;

                    case Menu::STATUS_BUTTON:
                    $this->getMain()->getStatus()->createStatus($player);
                    return;

                    case Menu::CONSOLE_BUTTON:
                    $this->getMain()->getConsole()->createConsole($player);
                    return;
                }
            }
        );

        $form->setTitle($this->getMain()->getProvider()->getMessage("menu.setTitle"));
        $form->setContent($this->getMain()->getProvider()->getMessage("menu.setContent"));
        $form->addButton($this->getMain()->getProvider()->getMessage("menu.addButton.close")); // Close the Menu
        $form->addButton($this->getMain()->getProvider()->getMessage("menu.addButton.status")); // createStatus()
        $form->addButton($this->getMain()->getProvider()->getMessage("menu.addButton.console")); // createConsole()

        $form->sendToPlayer($player);
    }

    /**
     * @return Main
     */
    public function getMain(): Main{
        return $this->main;
    }

}
