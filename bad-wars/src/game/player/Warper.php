<?php

declare(strict_types=1);

namespace BedWars\game\player;

use BedWars\arena\Converter;
use BedWars\BedWars;
use pocketmine\item\RawBeef;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Warper
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function setTeamForPlayer(Player $player): void
    {
        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);

        if ($arena->get("team.".$player->getName()) === ""){
            if ($arena->get("teams") === 2){
                if ($arena->get("rotTeam") === 0){
                    $arena->set("team.".$player->getName(), "rot");
                    $arena->set("rotTeam", $arena->get("rotTeam") + 1);
                    $arena->save();
                }else{
                    $arena->set("team.".$player->getName(), "gelb");
                    $arena->set("gelbTeam", $arena->get("gelbTeam") + 1);
                    $arena->save();
                }
            }elseif ($arena->get("teams") === 4){
                if ($arena->get("rotTeam") === 0 or $arena->get("rotTeam") === 1){
                    $arena->set("team.".$player->getName(), "rot");
                    $arena->set("rotTeam", $arena->get("rotTeam") + 1);
                    $arena->save();
                }elseif($arena->get("gelbTeam") === 0 or $arena->get("gelbTeam") === 1){
                    $arena->set("team.".$player->getName(), "gelb");
                    $arena->set("gelbTeam", $arena->get("gelbTeam") + 1);
                    $arena->save();
                }elseif($arena->get("grünTeam") === 0 or $arena->get("grünTeam") === 1){
                    $arena->set("team.".$player->getName(), "grün");
                    $arena->set("grünTeam", $arena->get("grünTeam") + 1);
                    $arena->save();
                }elseif($arena->get("cyanTeam") === 0 or $arena->get("cyanTeam") === 1){
                    $arena->set("team.".$player->getName(), "cyan");
                    $arena->set("cyanTeam", $arena->get("cyanTeam") + 1);
                    $arena->save();
                }
            }elseif ($arena->get("teams") === 8){
                if ($arena->get("rotTeam") === 0){
                    $arena->set("team.".$player->getName(), "rot");
                    $arena->set("rotTeam", $arena->get("rotTeam") + 1);
                    $arena->save();
                }elseif($arena->get("gelbTeam") === 0){
                    $arena->set("team.".$player->getName(), "gelb");
                    $arena->set("gelbTeam", $arena->get("gelbTeam") + 1);
                    $arena->save();
                }elseif($arena->get("grünTeam") === 0){
                    $arena->set("team.".$player->getName(), "grün");
                    $arena->set("grünTeam", $arena->get("grünTeam") + 1);
                    $arena->save();
                }elseif($arena->get("cyanTeam") === 0){
                    $arena->set("team.".$player->getName(), "cyan");
                    $arena->set("cyanTeam", $arena->get("cyanTeam") + 1);
                    $arena->save();
                }elseif($arena->get("blauTeam") === 0){
                    $arena->set("team.".$player->getName(), "blau");
                    $arena->set("blauTeam", $arena->get("blauTeam") + 1);
                    $arena->save();
                }elseif($arena->get("magentaTeam") === 0){
                    $arena->set("team.".$player->getName(), "magenta");
                    $arena->set("magentaTeam", $arena->get("magentaTeam") + 1);
                    $arena->save();
                }elseif($arena->get("schwarzTeam") === 0){
                    $arena->set("team.".$player->getName(), "schwarz");
                    $arena->set("schwarzTeam", $arena->get("schwarzTeam") + 1);
                    $arena->save();
                }elseif($arena->get("weißTeam") === 0){
                    $arena->set("team.".$player->getName(), "weiß");
                    $arena->set("weißTeam", $arena->get("weißTeam") + 1);
                    $arena->save();
                }
            }
        }
    }

    public function teleportToSpawn(Player $player): void
    {
        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
        $data = new Config($this->plugin->getDataFolder() . "ArenaData.json", Config::JSON);

        $team = $arena->get("team.".$player->getName());

        $teamSpawn = $data->get("team.{$team}.spawn");
        $x = (int)$teamSpawn["x"];
        $y = (int)$teamSpawn["y"];
        $z = (int)$teamSpawn["z"];

        $player->teleport(new Vector3($x, $y, $z));

        $player->getInventory()->clearAll();

        $player->sendMessage("§fBed§7Wars §8» §7Die Kämpfe können beginnen!");
    }
}