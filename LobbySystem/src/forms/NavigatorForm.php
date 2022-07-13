<?php

declare(strict_types=1);

namespace LobbySystem\forms;

use LobbySystem\Lobby;
use LobbySystem\pmforms\MenuForm;
use LobbySystem\pmforms\MenuOption;
use pocketmine\player\Player;
use pocketmine\world\Position;

class NavigatorForm
{
    public function __construct(private Lobby $plugin)
    {
    }

    public function createNavigationForm(): MenuForm
    {
        return new MenuForm(
            "Navigation",
            "Wähle ein Spielmodus",
            [
                new MenuOption("Survival"),
                new MenuOption("PvP")
            ],
            function (Player $submitter, int $selected): void {
                switch ($selected) {
                    case 0:
                        $form = self::createSurvivalNavForm();
                        $submitter->sendForm($form);
                        break;
                    case 1:
                        $form = self::createPvPNavForm();
                        $submitter->sendForm($form);
                        break;
                }
            }
        );
    }

    public function createSurvivalNavForm(): MenuForm
    {
        return new MenuForm(
            "Survival",
            "Wähle ein Spielmodus",
            [
                new MenuOption("CityBuild"),
                new MenuOption("SkyBlock"),
                new MenuOption("§cZurück")
            ],
            function (Player $submitter, int $selected): void {
                switch ($selected) {
                    case 0:
                        $submitter->sendTitle("§aCityBuild");
                        $submitter->teleport(new Position(1000, 500, 1000, $this->plugin->getServer()->getWorldManager()->getDefaultWorld()));
                        break;
                    case 1:
                        $submitter->sendTitle("§eSkyBlock");
                        $submitter->teleport(new Position(1000, 500, 1000, $this->plugin->getServer()->getWorldManager()->getDefaultWorld()));
                        break;
                    case 2:
                        $form = new NavigatorForm($this->plugin);
                        $submitter->sendForm($form->createNavigationForm());
                        break;
                }
            }
        );
    }

    public function createPvPNavForm(): MenuForm
    {
        return new MenuForm(
            "PvP",
            "Wähle ein Spielmodus",
            [
                new MenuOption("§cBed§fWars"),
                new MenuOption("§cZurück")
                /**
                 * new MenuOption("SkyWars"),
                 * new MenuOption("FFAs"),
                 * new MenuOption("EnderGames"),
                 * new MenuOption("1vs1"),
                 * new MenuOption("TryJump"),
                 * new MenuOption("Quick SG"),
                 * new MenuOption("Survival Games")
                 */
            ],
            function (Player $submitter, int $selected): void {
                switch ($selected) {
                    case 0:
                        $submitter->sendTitle("§cBedWars");
                        $submitter->teleport(new Position(1000, 500, 1000, $this->plugin->getServer()->getWorldManager()->getDefaultWorld()));
                        break;
                    case 1:
                        $form = self::createNavigationForm();
                        $submitter->sendForm($form);
                        break;
                }
            }
        );
    }
}