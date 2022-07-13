<?php

declare(strict_types=1);

namespace BedWars\forms\menu;

use BedWars\apis\invmenu\InvMenu;
use BedWars\apis\invmenu\transaction\InvMenuTransaction;
use BedWars\apis\invmenu\transaction\InvMenuTransactionResult;
use BedWars\apis\invmenu\type\InvMenuTypeIds;
use BedWars\forms\menu\shop\ArmorShop;
use BedWars\forms\menu\shop\BlockShop;
use BedWars\forms\menu\shop\BowShop;
use BedWars\forms\menu\shop\PickaxeShop;
use BedWars\forms\menu\shop\PotionShop;
use BedWars\forms\menu\shop\SnackShop;
use BedWars\forms\menu\shop\SpecialShop;
use BedWars\forms\menu\shop\SwordShop;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemIds;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class VillagerShop
{
    //Main Page
    public function sendItemShop(Player $player): void
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);

        $menu->setName("§cShop");

        $inventory = $menu->getInventory();
        self::sendFirstPage($inventory);

        $menu->setListener(function (InvMenuTransaction $transaction) use ($inventory): InvMenuTransactionResult {
            $player = $transaction->getPlayer();
            $item = $transaction->getItemClicked();

            switch ($item->getId()) {
                //MENU
                case ItemIds::DIAMOND_SWORD:
                    $swordShop = new SwordShop();
                    $swordShop->sendSwordPage($inventory);
                    break;
                case ItemIds::DIAMOND_PICKAXE:
                    $pickaxeShop = new PickaxeShop();
                    $pickaxeShop->sendPickaxePage($inventory);
                    break;
                case ItemIds::RED_SANDSTONE:
                    $blockShop = new BlockShop();
                    $blockShop->sendBlockPage($inventory);
                    break;
                case ItemIds::COOKIE:
                    $snackShop = new SnackShop();
                    $snackShop->sendSnackPage($inventory);
                    break;
                case ItemIds::DIAMOND_CHESTPLATE:
                    $armorShop = new ArmorShop();
                    $armorShop->sendArmorPage($inventory);
                    break;
                case ItemIds::BOW:
                    if ($item->getCustomName() === "§7Bögen") {
                        $bowShop = new BowShop();
                        $bowShop->sendBowPage($inventory);
                    } elseif ($item->getCustomName() === "§7Bogen") {
                        $price = $player->getInventory()->contains(VanillaItems::GOLD_INGOT()->setCount(1));
                        if ($price === true) {
                            $player->getInventory()->removeItem(VanillaItems::GOLD_INGOT()->setCount(1));
                            $player->getInventory()->addItem(VanillaItems::BOW()->setCustomName("§7Bogen"));
                        }
                    } elseif ($item->getCustomName() === "§7Bogen 2") {
                        $price = $player->getInventory()->contains(VanillaItems::GOLD_INGOT()->setCount(4));
                        if ($price === true) {
                            $player->getInventory()->removeItem(VanillaItems::GOLD_INGOT()->setCount(4));
                            $enchantment = new EnchantmentInstance(VanillaEnchantments::POWER(), 1);
                            $player->getInventory()->addItem(VanillaItems::BOW()->setCustomName("§7Bogen 2")->addEnchantment($enchantment));
                        }
                    }
                    break;
                case ItemIds::POTION:
                    $potionShop = new PotionShop();
                    $potionShop->sendPotionPage($inventory);
                    break;
                case ItemIds::TNT:
                    $specialShop = new SpecialShop();
                    $specialShop->sendSpecialPage($inventory);
                    break;

                //First Page Items
                case ItemIds::STICK:
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(8));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(8));
                        $enchantment = new EnchantmentInstance(VanillaEnchantments::KNOCKBACK(), 1);
                        $player->getInventory()->addItem(VanillaItems::STICK()->setCustomName("§7Stick")->addEnchantment($enchantment));
                    }
                    break;
                case ItemIds::WOODEN_PICKAXE:
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(4));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(4));
                        $player->getInventory()->addItem(VanillaItems::WOODEN_PICKAXE()->setCustomName("§7Holz-Spitzhacke"));
                    }
                    break;
                case ItemIds::SANDSTONE:
                    if ($item->getCount() === 1) {
                        foreach ($player->getInventory()->getContents() as $content) {
                            if ($content->getId() === ItemIds::BRICK) {
                                $count = $content->getCount();
                                $count2 = $count * 2;
                                $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount($count));
                                if ($price === true) {
                                    $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount($count));
                                    $player->getInventory()->addItem(VanillaBlocks::SANDSTONE()->asItem()->setCustomName("§7Sandstein")->setCount($count2));
                                }
                            }
                        }
                    } else {
                        $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(2));
                        if ($price === true) {
                            $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(2));
                            $player->getInventory()->addItem(VanillaBlocks::SANDSTONE()->asItem()->setCustomName("§7Sandstein")->setCount(4));
                        }
                    }
                    break;
                case ItemIds::GOLDEN_SWORD:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(2));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(2));
                        $enchantment = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2);
                        $player->getInventory()->addItem(VanillaItems::GOLDEN_SWORD()->setCustomName("§7Gold-Schwert")->addEnchantment($enchantment));
                    }
                    break;
                case ItemIds::LEATHER_CAP:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(1));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(1));
                        $player->getInventory()->addItem(VanillaItems::LEATHER_CAP()->setCustomName("§7Kappe"));
                    }
                    break;
                case ItemIds::CHAINMAIL_CHESTPLATE:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(3));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(3));
                        $player->getInventory()->addItem(VanillaItems::CHAINMAIL_CHESTPLATE()->setCustomName("§7Ketten-Brustplatte"));
                    }
                    break;
                case ItemIds::LEATHER_PANTS:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(3));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(3));
                        $player->getInventory()->addItem(VanillaItems::LEATHER_PANTS()->setCustomName("§7Leggings"));
                    }
                    break;
                case ItemIds::LEATHER_BOOTS:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(1));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(1));
                        $player->getInventory()->addItem(VanillaItems::LEATHER_BOOTS()->setCustomName("§7Schuhe"));
                    }
                    break;

                //ArmorShop
                case ItemIds::IRON_CHESTPLATE:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(6));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(6));
                        $player->getInventory()->addItem(VanillaItems::IRON_CHESTPLATE()->setCustomName("§7Eisen-Brustplatte"));
                    }
                    break;

                //BlockShop
                case ItemIds::END_STONE:
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(6));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(6));
                        $player->getInventory()->addItem(VanillaBlocks::END_STONE()->asItem()->setCustomName("§7End-Stein"));
                    }
                    break;
                case ItemIds::CHEST:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(2));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(2));
                        $player->getInventory()->addItem(VanillaBlocks::CHEST()->asItem()->setCustomName("§7Kiste"));
                    }
                    break;
                case ItemIds::LADDER:
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(10));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(10));
                        $player->getInventory()->addItem(VanillaBlocks::LADDER()->asItem()->setCustomName("§7Leiter")->setCount(6));
                    }
                    break;

                //Bow Shop
                case ItemIds::ARROW:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(1));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(2));
                        $player->getInventory()->addItem(VanillaItems::ARROW()->setCustomName("§7Pfeile"));
                    }
                    break;

                //Pickaxe Shop
                case ItemIds::STONE_PICKAXE:
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(12));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(12));
                        $player->getInventory()->addItem(VanillaItems::STONE_PICKAXE()->setCustomName("§7Stein-Spitzhacke"));
                    }
                    break;
                case ItemIds::IRON_PICKAXE:
                    $price = $player->getInventory()->contains(VanillaItems::IRON_INGOT()->setCount(4));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::IRON_INGOT()->setCount(4));
                        $player->getInventory()->addItem(VanillaItems::IRON_PICKAXE()->setCustomName("§7Eisen-Spitzhacke"));
                    }
                    break;

                //Snack Shop
                case ItemIds::BREAD;
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(1));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(1));
                        $player->getInventory()->addItem(VanillaItems::BREAD()->setCustomName("§7Brot"));
                    }
                    break;
                case ItemIds::COOKED_PORKCHOP:
                    $price = $player->getInventory()->contains(VanillaItems::BRICK()->setCount(3));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::BRICK()->setCount(3));
                        $player->getInventory()->addItem(VanillaItems::COOKED_PORKCHOP()->setCustomName("§7Haram Flesich"));
                    }
                    break;
                case ItemIds::GOLDEN_APPLE:
                    $price = $player->getInventory()->contains(VanillaItems::GOLD_INGOT()->setCount(2));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::GOLD_INGOT()->setCount(2));
                        $player->getInventory()->addItem(VanillaItems::GOLDEN_APPLE()->setCustomName("§7Goldener Apfel"));
                    }
                    break;

                //Sword Shop
                case ItemIds::IRON_SWORD:
                    $price = $player->getInventory()->contains(VanillaItems::GOLD_INGOT()->setCount(6));
                    if ($price === true) {
                        $player->getInventory()->removeItem(VanillaItems::GOLD_INGOT()->setCount(6));
                        $player->getInventory()->addItem(VanillaItems::IRON_SWORD()->setCustomName("§7Eisen-Schwert"));
                    }
                    break;
            }
            return $transaction->discard();
        });
        $menu->send($player);
    }

    public function sendFirstPage(Inventory $inventory): void
    {
        $inventory->clearAll();

        //1 Line
        $inventory->setItem(0, VanillaItems::DIAMOND_SWORD()->setCustomName("§7Schwerter"));
        $inventory->setItem(1, VanillaItems::DIAMOND_PICKAXE()->setCustomName("§7Spitzhacken"));
        $inventory->setItem(2, VanillaBlocks::RED_SANDSTONE()->asItem()->setCustomName("§7Blöcke"));
        $inventory->setItem(3, VanillaItems::COOKIE()->setCustomName("§7Futter"));

        $inventory->setItem(5, VanillaItems::DIAMOND_CHESTPLATE()->setCustomName("§7Rüstung"));
        $inventory->setItem(6, VanillaItems::BOW()->setCustomName("§7Bögen"));
        $inventory->setItem(7, VanillaItems::HEALING_POTION()->setCustomName("§7Tränke"));
        $inventory->setItem(8, VanillaBlocks::TNT()->asItem()->setCustomName("§7Special Item"));

        //2 Line
        $inventory->setItem(9, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(10, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(11, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(12, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(13, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" Danke an HimmelKreis4865 "));
        $inventory->setItem(14, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(15, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(16, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));
        $inventory->setItem(17, VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "));

        //3 Line
        $enchantment1 = new EnchantmentInstance(VanillaEnchantments::KNOCKBACK(), 1);
        $inventory->setItem(18, VanillaItems::STICK()->setCustomName("§7Stick")->addEnchantment($enchantment1)->setLore(["§l§c8 Bronze"]));
        $inventory->setItem(19, VanillaItems::WOODEN_PICKAXE()->setCustomName("§7Holz-Spitzhacke")->setLore(["§l§c4 Bronze"]));
        $inventory->setItem(20, VanillaBlocks::SANDSTONE()->asItem()->setCustomName("§7Sandstein")->setLore(["§l§c1 Bronze", "§l§a2 Blöcke"]));

        $enchantment2 = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $inventory->setItem(22, VanillaItems::GOLDEN_SWORD()->setCustomName("§7Gold-Schwert")->addEnchantment($enchantment2)->setLore(["§l§c2 Eisen"]));
        $inventory->setItem(23, VanillaItems::LEATHER_CAP()->setCustomName("§7Kappe")->setLore(["§l§c1 Eisen"]));
        $inventory->setItem(24, VanillaItems::CHAINMAIL_CHESTPLATE()->setCustomName("§7Ketten-Brustplatte")->setLore(["§l§c3 Eisen"]));
        $inventory->setItem(25, VanillaItems::LEATHER_PANTS()->setCustomName("§7Leggings")->setLore(["§l§c1 Eisen"]));
        $inventory->setItem(26, VanillaItems::LEATHER_BOOTS()->setCustomName("§7Schuhe")->setLore(["§l§c1 Eisen"]));
    }
}