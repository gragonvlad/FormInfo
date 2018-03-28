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
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
# FormInfo
use jp\mazaicrafty\pmmp\FormInfo\Main;
use jp\mazaicrafty\pmmp\FormInfo\interfaces\CallAction;
use jp\mazaicrafty\pmmp\FormInfo\{EventListener, Provider};

class Status implements CallAction{

    const BACK_BUTTON = 0;

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
    public function createStatus(Player $player){
        $form = $this->getMain()->getForm()->createSimpleForm(
            function (Player $player, $result){
                if($result === null) return;// NOTE: Cancelled

                switch ($result){
                    case Status::BACK_BUTTON:
                    // Back to Menu
                    $this->getMain()->getMenu()->createMenu($player);
                    return;
                }
            }
        );

        $money = $this->getMain()->getEconomy()->myMoney($player->getName());
        $replace = ["%MONEY%", "%PLAYER%", "%X%", "%Y%", "%Z%", "{NL}"];
        $str = [$money, $player->getName(), $player->getX(), $player->getY(), $player->getZ(), "\n"];
        $content = str_replace($replace , $str, $this->getMain()->getProvider()->getMessage("status.setContent"));

        $form->setTitle($this->getMain()->getProvider()->getMessage("status.setTitle"));
        $form->addButton($this->getMain()->getProvider()->getMessage("status.addButton.back")); // Close the Menu
        $form->setContent($content);

        $form->sendToPlayer($player);
    }

    /**
     * @return Main
     */
    public function getMain(): Main{
        return $this->main;
    }

}
