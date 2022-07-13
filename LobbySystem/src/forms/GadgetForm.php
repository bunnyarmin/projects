<?php

declare(strict_types=1);

namespace LobbySystem\forms;

use LobbySystem\Lobby;
use LobbySystem\pmforms\MenuForm;
use LobbySystem\pmforms\MenuOption;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\Config;
use pocketmine\world\particle\FlameParticle;

class GadgetForm
{
    public function __construct(private Lobby $plugin)
    {
    }

    public function createGadgetForm(): MenuForm
    {
        return new MenuForm(
            "Gadgets",
            "Wähle ein Gadget aus",
            [
                new MenuOption("Walk Partikel"),
                new MenuOption("Wings"),
                new MenuOption("§cZurück")
            ],
            function (Player $submitter, int $selected): void {
                switch ($selected) {
                    case 0:
                        $form = self::createWalkParForm();
                        $submitter->sendForm($form);
                        break;
                    case 1:
                        break;
                    case 2:
                        break;
                }
            }
        );
    }

    public function createWalkParForm(): MenuForm
    {
        return new MenuForm(
            "Walk Particle",
            "Wähle ein Gadget aus",
            [
                new MenuOption("Flammen"),
                new MenuOption("Diamanten"),
                new MenuOption("§cZurück")
            ],
            function (Player $submitter, int $selected): void {
                switch ($selected) {
                    case 0:
                        $pdata = new Config($this->plugin->getDataFolder() . $submitter->getName() . ".json", Config::JSON);
                        $pdata->set("gadget", "flammen");
                        $pdata->save();

                        $this->plugin->getScheduler()->scheduleRepeatingTask(new ClosureTask(
                            function () use ($submitter, $pdata) {
                                if ($pdata->get("gadget") === "flammen") {
                                    }
                                }
                            }
                        ), 15);
                        break;
                    case 1:
                        $submitter->sendMessage("");
                        break;
                    case 2:
                        $submitter->sendMessage("1");
                        break;
                }
            });
    }
}