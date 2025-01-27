<?php

/**
 *
 *    ____ _                   _
 *  / ___| | _____      _____| |_ ___  _ __   ___
 * | |  _| |/ _ \ \ /\ / / __| __/ _ \| '_ \ / _ \
 * | |_| | | (_) \ V  V /\__ \ || (_) | | | |  __/
 *  \____|_|\___/ \_/\_/ |___/\__\___/|_| |_|\___|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Glowstone (Lunarelly)
 * @link https://github.com/Lunarelly
 *
 */

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\Fence;
use pocketmine\block\Flower;
use pocketmine\entity\Entity;
use pocketmine\inventory\Fuel;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\level\Level;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Binary;
use pocketmine\utils\Config;

class Item
{
    /** @var NBT */
    private static $cachedParser = null;

    private static function parseCompoundTag(string $tag): CompoundTag
    {
        if (self::$cachedParser === null) {
            self::$cachedParser = new NBT(NBT::LITTLE_ENDIAN);
        }

        self::$cachedParser->read($tag);
        return self::$cachedParser->getData();
    }

    private static function writeCompoundTag(CompoundTag $tag): string
    {
        if (self::$cachedParser === null) {
            self::$cachedParser = new NBT(NBT::LITTLE_ENDIAN);
        }

        self::$cachedParser->setData($tag);
        return self::$cachedParser->write();
    }

    //All Block IDs are here too
    const AIR = 0;
    const STONE = 1;
    const GRASS = 2;
    const DIRT = 3;
    const COBBLESTONE = 4;
    const COBBLE = 4;
    const PLANK = 5;
    const PLANKS = 5;
    const WOODEN_PLANK = 5;
    const WOODEN_PLANKS = 5;
    const SAPLING = 6;
    const SAPLINGS = 6;
    const BEDROCK = 7;
    const WATER = 8;
    const STILL_WATER = 9;
    const LAVA = 10;
    const STILL_LAVA = 11;
    const SAND = 12;
    const GRAVEL = 13;
    const GOLD_ORE = 14;
    const IRON_ORE = 15;
    const COAL_ORE = 16;
    const LOG = 17;
    const WOOD = 17;
    const TRUNK = 17;
    const LEAVES = 18;
    const LEAVE = 18;
    const SPONGE = 19;
    const GLASS = 20;
    const LAPIS_ORE = 21;
    const LAPIS_BLOCK = 22;

    const DISPENSER = 23;

    const SANDSTONE = 24;
    const NOTEBLOCK = 25;
    const BED_BLOCK = 26;
    const POWERED_RAIL = 27;
    const DETECTOR_RAIL = 28;
    const COBWEB = 30;
    const TALL_GRASS = 31;
    const BUSH = 32;
    const DEAD_BUSH = 32;
    const WOOL = 35;
    const DANDELION = 37;
    const POPPY = 38;
    const ROSE = 38;
    const RED_FLOWER = 38;
    const BROWN_MUSHROOM = 39;
    const RED_MUSHROOM = 40;
    const GOLD_BLOCK = 41;
    const IRON_BLOCK = 42;
    const DOUBLE_SLAB = 43;
    const DOUBLE_SLABS = 43;
    const SLAB = 44;
    const SLABS = 44;
    const BRICKS = 45;
    const BRICKS_BLOCK = 45;
    const TNT = 46;
    const BOOKSHELF = 47;
    const MOSS_STONE = 48;
    const MOSSY_STONE = 48;
    const OBSIDIAN = 49;
    const TORCH = 50;
    const FIRE = 51;
    const MONSTER_SPAWNER = 52;
    const WOOD_STAIRS = 53;
    const WOODEN_STAIRS = 53;
    const OAK_WOOD_STAIRS = 53;
    const OAK_WOODEN_STAIRS = 53;
    const CHEST = 54;
    const REDSTONE_WIRE = 55;
    const DIAMOND_ORE = 56;
    const DIAMOND_BLOCK = 57;
    const CRAFTING_TABLE = 58;
    const WORKBENCH = 58;
    const WHEAT_BLOCK = 59;
    const FARMLAND = 60;
    const FURNACE = 61;
    const BURNING_FURNACE = 62;
    const LIT_FURNACE = 62;
    const SIGN_POST = 63;
    const DOOR_BLOCK = 64;
    const WOODEN_DOOR_BLOCK = 64;
    const WOOD_DOOR_BLOCK = 64;
    const LADDER = 65;
    const RAIL = 66;
    const COBBLE_STAIRS = 67;
    const COBBLESTONE_STAIRS = 67;
    const WALL_SIGN = 68;
    const LEVER = 69;
    const STONE_PRESSURE_PLATE = 70;
    const IRON_DOOR_BLOCK = 71;
    const WOODEN_PRESSURE_PLATE = 72;
    const REDSTONE_ORE = 73;
    const GLOWING_REDSTONE_ORE = 74;
    const LIT_REDSTONE_ORE = 74;
    const REDSTONE_TORCH = 75;
    const LIT_REDSTONE_TORCH = 76;
    const UNLIT_REDSTONE_TORCH = 75;
    const STONE_BUTTON = 77;
    const SNOW = 78;
    const SNOW_LAYER = 78;
    const ICE = 79;
    const SNOW_BLOCK = 80;
    const CACTUS = 81;
    const CLAY_BLOCK = 82;
    const REEDS = 83;
    const SUGARCANE_BLOCK = 83;

    const FENCE = 85;
    const PUMPKIN = 86;
    const NETHERRACK = 87;
    const SOUL_SAND = 88;
    const GLOWSTONE = 89;
    const GLOWSTONE_BLOCK = 89;

    const PORTAL_BLOCK = 90;
    const PORTAL = 90;
    const LIT_PUMPKIN = 91;
    const JACK_O_LANTERN = 91;
    const CAKE_BLOCK = 92;

    const UNPOWERED_REPEATER = 93;
    const POWERED_REPEATER = 94;

    const TRAPDOOR = 96;
    const MONSTER_EGG_BLOCK = 97;
    const STONE_BRICKS = 98;
    const STONE_BRICK = 98;
    const BROWN_MUSHROOM_BLOCK = 99;
    const RED_MUSHROOM_BLOCK = 100;
    const IRON_BAR = 101;
    const IRON_BARS = 101;
    const GLASS_PANE = 102;
    const GLASS_PANEL = 102;
    const MELON_BLOCK = 103;
    const PUMPKIN_STEM = 104;
    const MELON_STEM = 105;
    const VINE = 106;
    const VINES = 106;
    const FENCE_GATE = 107;
    const BRICK_STAIRS = 108;
    const STONE_BRICK_STAIRS = 109;
    const MYCELIUM = 110;
    const WATER_LILY = 111;
    const LILY_PAD = 111;
    const NETHER_BRICKS = 112;
    const NETHER_BRICK_BLOCK = 112;
    const NETHER_BRICK_FENCE = 113;
    const NETHER_BRICKS_STAIRS = 114;
    const NETHER_WART_BLOCK = 115;
    const ENCHANTING_TABLE = 116;
    const ENCHANT_TABLE = 116;
    const ENCHANTMENT_TABLE = 116;
    const BREWING_STAND_BLOCK = 117;

    const END_PORTAL = 120;
    const END_STONE = 121;
    const REDSTONE_LAMP = 122;
    const LIT_REDSTONE_LAMP = 123;
    const INACTIVE_REDSTONE_LAMP = 123;
    const ACTIVE_REDSTONE_LAMP = 124;

    const DROPPER = 125;

    const ACTIVATOR_RAIL = 126;
    const COCOA_BLOCK = 127;
    const COCOA_PODS = 127;
    const SANDSTONE_STAIRS = 128;
    const EMERALD_ORE = 129;

    const TRIPWIRE_HOOK = 131;
    const TRIPWIRE = 132;
    const EMERALD_BLOCK = 133;
    const SPRUCE_WOOD_STAIRS = 134;
    const SPRUCE_WOODEN_STAIRS = 134;
    const BIRCH_WOOD_STAIRS = 135;
    const BIRCH_WOODEN_STAIRS = 135;
    const JUNGLE_WOOD_STAIRS = 136;
    const JUNGLE_WOODEN_STAIRS = 136;

    const COBBLE_WALL = 139;
    const STONE_WALL = 139;
    const COBBLESTONE_WALL = 139;
    const FLOWER_POT_BLOCK = 140;
    const CARROT_BLOCK = 141;
    const POTATO_BLOCK = 142;
    const WOODEN_BUTTON = 143;
    const MOB_HEAD_BLOCK = 144;
    const SKULL_BLOCK = 144;
    const TRAPPED_CHEST = 146;
    const ANVIL = 145;
    const WEIGHTED_PRESSURE_PLATE_LIGHT = 147;
    const WEIGHTED_PRESSURE_PLATE_HEAVY = 148;
    const LIGHT_WEIGHTED_PRESSURE_PLATE = 147;
    const HEAVY_WEIGHTED_PRESSURE_PLATE = 148;

    const DAYLIGHT_SENSOR = 151;
    const REDSTONE_BLOCK = 152;
    const NETHER_QUARTZ_ORE = 153;

    const HOPPER = 154;

    const QUARTZ_BLOCK = 155;
    const QUARTZ_STAIRS = 156;
    const DOUBLE_WOOD_SLAB = 157;
    const DOUBLE_WOODEN_SLAB = 157;
    const DOUBLE_WOOD_SLABS = 157;
    const DOUBLE_WOODEN_SLABS = 157;
    const WOOD_SLAB = 158;
    const WOODEN_SLAB = 158;
    const WOOD_SLABS = 158;
    const WOODEN_SLABS = 158;
    const STAINED_CLAY = 159;
    const STAINED_HARDENED_CLAY = 159;

    const LEAVES2 = 161;
    const LEAVE2 = 161;
    const WOOD2 = 162;
    const TRUNK2 = 162;
    const LOG2 = 162;
    const ACACIA_WOOD_STAIRS = 163;
    const ACACIA_WOODEN_STAIRS = 163;
    const DARK_OAK_WOOD_STAIRS = 164;
    const DARK_OAK_WOODEN_STAIRS = 164;
    const SLIME_BLOCK = 165;
    const IRON_TRAPDOOR = 167;

    const HAY_BALE = 170;
    const CARPET = 171;
    const HARDENED_CLAY = 172;
    const COAL_BLOCK = 173;
    const PACKED_ICE = 174;
    const DOUBLE_PLANT = 175;

    const INVERTED_DAYLIGHT_SENSOR = 178;
    const DAYLIGHT_SENSOR_INVERTED = 178;

    const RED_SANDSTONE = 179;
    const RED_SANDSTONE_STAIRS = 180;
    const DOUBLE_RED_SANDSTONE_SLAB = 181;
    const RED_SANDSTONE_SLAB = 182;

    const FENCE_GATE_SPRUCE = 183;
    const FENCE_GATE_BIRCH = 184;
    const FENCE_GATE_JUNGLE = 185;
    const FENCE_GATE_DARK_OAK = 186;
    const FENCE_GATE_ACACIA = 187;

    const SPRUCE_DOOR_BLOCK = 193;
    const BIRCH_DOOR_BLOCK = 194;
    const JUNGLE_DOOR_BLOCK = 195;
    const ACACIA_DOOR_BLOCK = 196;
    const DARK_OAK_DOOR_BLOCK = 197;

    const GRASS_PATH = 198;

    const ITEM_FRAME_BLOCK = 199;

    const PODZOL = 243;
    const BEETROOT_BLOCK = 244;
    const STONECUTTER = 245;
    const GLOWING_OBSIDIAN = 246;
    const NETHER_REACTOR = 247;


    //Normal Item IDs
    const IRON_SHOVEL = 256;
    const IRON_PICKAXE = 257;
    const IRON_AXE = 258;
    const FLINT_STEEL = 259;
    const FLINT_AND_STEEL = 259;
    const APPLE = 260;
    const BOW = 261;
    const ARROW = 262;
    const COAL = 263;
    const DIAMOND = 264;
    const IRON_INGOT = 265;
    const GOLD_INGOT = 266;
    const IRON_SWORD = 267;
    const WOODEN_SWORD = 268;
    const WOODEN_SHOVEL = 269;
    const WOODEN_PICKAXE = 270;
    const WOODEN_AXE = 271;
    const STONE_SWORD = 272;
    const STONE_SHOVEL = 273;
    const STONE_PICKAXE = 274;
    const STONE_AXE = 275;
    const DIAMOND_SWORD = 276;
    const DIAMOND_SHOVEL = 277;
    const DIAMOND_PICKAXE = 278;
    const DIAMOND_AXE = 279;
    const STICK = 280;
    const STICKS = 280;
    const BOWL = 281;
    const MUSHROOM_STEW = 282;
    const GOLD_SWORD = 283;
    const GOLD_SHOVEL = 284;
    const GOLD_PICKAXE = 285;
    const GOLD_AXE = 286;
    const GOLDEN_SWORD = 283;
    const GOLDEN_SHOVEL = 284;
    const GOLDEN_PICKAXE = 285;
    const GOLDEN_AXE = 286;
    const STRING = 287;
    const FEATHER = 288;
    const GUNPOWDER = 289;
    const WOODEN_HOE = 290;
    const STONE_HOE = 291;
    const IRON_HOE = 292;
    const DIAMOND_HOE = 293;
    const GOLD_HOE = 294;
    const GOLDEN_HOE = 294;
    const SEEDS = 295;
    const WHEAT_SEEDS = 295;
    const WHEAT = 296;
    const BREAD = 297;
    const LEATHER_CAP = 298;
    const LEATHER_TUNIC = 299;
    const LEATHER_PANTS = 300;
    const LEATHER_BOOTS = 301;
    const CHAIN_HELMET = 302;
    const CHAIN_CHESTPLATE = 303;
    const CHAIN_LEGGINGS = 304;
    const CHAIN_BOOTS = 305;
    const IRON_HELMET = 306;
    const IRON_CHESTPLATE = 307;
    const IRON_LEGGINGS = 308;
    const IRON_BOOTS = 309;
    const DIAMOND_HELMET = 310;
    const DIAMOND_CHESTPLATE = 311;
    const DIAMOND_LEGGINGS = 312;
    const DIAMOND_BOOTS = 313;
    const GOLD_HELMET = 314;
    const GOLD_CHESTPLATE = 315;
    const GOLD_LEGGINGS = 316;
    const GOLD_BOOTS = 317;
    const FLINT = 318;
    const RAW_PORKCHOP = 319;
    const COOKED_PORKCHOP = 320;
    const PAINTING = 321;
    const GOLDEN_APPLE = 322;
    const SIGN = 323;
    const WOODEN_DOOR = 324;
    const BUCKET = 325;

    const MINECART = 328;
    const SADDLE = 329;
    const IRON_DOOR = 330;
    const REDSTONE = 331;
    const REDSTONE_DUST = 331;
    const SNOWBALL = 332;
    const BOAT = 333;
    const LEATHER = 334;

    const BRICK = 336;
    const CLAY = 337;
    const SUGARCANE = 338;
    const SUGAR_CANE = 338;
    const SUGAR_CANES = 338;
    const PAPER = 339;
    const BOOK = 340;
    const SLIMEBALL = 341;

    const MINECART_WITH_CHEST = 342;

    const EGG = 344;
    const COMPASS = 345;
    const FISHING_ROD = 346;
    const CLOCK = 347;
    const GLOWSTONE_DUST = 348;
    const RAW_FISH = 349;
    const COOKED_FISH = 350;
    const DYE = 351;
    const BONE = 352;
    const SUGAR = 353;
    const CAKE = 354;
    const BED = 355;

    const REPEATER = 356;

    const COOKIE = 357;

    const FILLED_MAP = 358;

    const SHEARS = 359;
    const MELON = 360;
    const MELON_SLICE = 360;
    const PUMPKIN_SEEDS = 361;
    const MELON_SEEDS = 362;
    const RAW_BEEF = 363;
    const STEAK = 364;
    const COOKED_BEEF = 364;
    const RAW_CHICKEN = 365;
    const COOKED_CHICKEN = 366;
    const ROTTEN_FLESH = 367;

    const ENDER_PEARL = 368;

    const BLAZE_ROD = 369;
    const GHAST_TEAR = 370;
    const GOLD_NUGGET = 371;
    const GOLDEN_NUGGET = 371;
    const NETHER_WART = 372;
    const POTION = 373;
    const GLASS_BOTTLE = 374;
    const SPIDER_EYE = 375;
    const FERMENTED_SPIDER_EYE = 376;
    const BLAZE_POWDER = 377;
    const MAGMA_CREAM = 378;

    const BREWING_STAND = 379;
    const CAULDRON = 380;

    const GLISTERING_MELON = 382;
    const SPAWN_EGG = 383;
    const BOTTLE_O_ENCHANTING = 384;
    const ENCHANTING_BOTTLE = 384;

    const EMERALD = 388;

    const ITEM_FRAME = 389;

    const FLOWER_POT = 390;
    const CARROT = 391;
    const CARROTS = 391;
    const POTATO = 392;
    const POTATOES = 392;
    const BAKED_POTATO = 393;
    const BAKED_POTATOES = 393;
    const POISONOUS_POTATO = 394;

    const EMPTY_MAP = 395;

    const GOLDEN_CARROT = 396;
    const MOB_HEAD = 397;
    const SKULL = 397;
    const PUMPKIN_PIE = 400;

    const ENCHANTED_BOOK = 403;

    const COMPARATOR = 404;

    const NETHER_BRICK = 405;
    const QUARTZ = 406;
    const NETHER_QUARTZ = 406;

    const MINECART_WITH_TNT = 407;
    const MINECART_WITH_HOPPER = 408;

    const RAW_RABBIT = 411;
    const COOKED_RABBIT = 412;
    const RABBIT_STEW = 413;
    const RABBIT_FOOT = 414;
    const RABBIT_HIDE = 415;
    const SPRUCE_DOOR = 427;
    const BIRCH_DOOR = 428;
    const JUNGLE_DOOR = 429;
    const ACACIA_DOOR = 430;
    const DARK_OAK_DOOR = 431;
    const SPLASH_POTION = 438;
    const SPRUCE_BOAT = 444;
    const BIRCH_BOAT = 445;
    const JUNGLE_BOAT = 446;
    const ACACIA_BOAT = 447;
    const DARK_OAK_BOAT = 448;

    const CAMERA = 439;
    const BEETROOT = 457;
    const BEETROOT_SEEDS = 458;
    const BEETROOT_SEED = 458;
    const BEETROOT_SOUP = 459;

    const RAW_SALMON = 460;
    const CLOWN_FISH = 461;
    const PUFFER_FISH = 462;
    const COOKED_SALMON = 463;

    const ENCHANTING_GOLDEN_APPLE = 466;


    /** @var \SplFixedArray */
    public static $list = null;
    protected $block;
    protected $id;
    protected $meta;
    private $tags = "";
    private $cachedNBT = null;
    public $count;
    protected $durability = 0;
    protected $name;

    public function canBeActivated(): bool
    {
        return false;
    }

    public static function init($readFromJson = false)
    {
        if (self::$list === null) {
            self::$list = new \SplFixedArray(65536);
            self::$list[self::SUGARCANE] = Sugarcane::class;
            self::$list[self::WHEAT_SEEDS] = WheatSeeds::class;
            self::$list[self::PUMPKIN_SEEDS] = PumpkinSeeds::class;
            self::$list[self::MELON_SEEDS] = MelonSeeds::class;
            self::$list[self::MUSHROOM_STEW] = MushroomStew::class;
            self::$list[self::RABBIT_STEW] = RabbitStew::class;
            self::$list[self::BEETROOT_SOUP] = BeetrootSoup::class;
            self::$list[self::CARROT] = Carrot::class;
            self::$list[self::POTATO] = Potato::class;
            self::$list[self::BEETROOT_SEEDS] = BeetrootSeeds::class;
            self::$list[self::SIGN] = Sign::class;
            self::$list[self::WOODEN_DOOR] = WoodenDoor::class;
            self::$list[self::SPRUCE_DOOR] = SpruceDoor::class;
            self::$list[self::BIRCH_DOOR] = BirchDoor::class;
            self::$list[self::JUNGLE_DOOR] = JungleDoor::class;
            self::$list[self::ACACIA_DOOR] = AcaciaDoor::class;
            self::$list[self::DARK_OAK_DOOR] = DarkOakDoor::class;
            self::$list[self::BUCKET] = Bucket::class;
            self::$list[self::IRON_DOOR] = IronDoor::class;
            self::$list[self::CAKE] = Cake::class;
            self::$list[self::BED] = Bed::class;
            self::$list[self::PAINTING] = Painting::class;
            self::$list[self::COAL] = Coal::class;
            self::$list[self::APPLE] = Apple::class;
            self::$list[self::SPAWN_EGG] = SpawnEgg::class;
            self::$list[self::DIAMOND] = Diamond::class;
            self::$list[self::STICK] = Stick::class;
            self::$list[self::SNOWBALL] = Snowball::class;
            self::$list[self::BOWL] = Bowl::class;
            self::$list[self::FEATHER] = Feather::class;
            self::$list[self::BRICK] = Brick::class;
            self::$list[self::LEATHER_CAP] = LeatherCap::class;
            self::$list[self::LEATHER_TUNIC] = LeatherTunic::class;
            self::$list[self::LEATHER_PANTS] = LeatherPants::class;
            self::$list[self::LEATHER_BOOTS] = LeatherBoots::class;
            self::$list[self::CHAIN_HELMET] = ChainHelmet::class;
            self::$list[self::CHAIN_CHESTPLATE] = ChainChestplate::class;
            self::$list[self::CHAIN_LEGGINGS] = ChainLeggings::class;
            self::$list[self::CHAIN_BOOTS] = ChainBoots::class;
            self::$list[self::IRON_HELMET] = IronHelmet::class;
            self::$list[self::IRON_CHESTPLATE] = IronChestplate::class;
            self::$list[self::IRON_LEGGINGS] = IronLeggings::class;
            self::$list[self::IRON_BOOTS] = IronBoots::class;
            self::$list[self::GOLD_HELMET] = GoldHelmet::class;
            self::$list[self::GOLD_CHESTPLATE] = GoldChestplate::class;
            self::$list[self::GOLD_LEGGINGS] = GoldLeggings::class;
            self::$list[self::GOLD_BOOTS] = GoldBoots::class;
            self::$list[self::DIAMOND_HELMET] = DiamondHelmet::class;
            self::$list[self::DIAMOND_CHESTPLATE] = DiamondChestplate::class;
            self::$list[self::DIAMOND_LEGGINGS] = DiamondLeggings::class;
            self::$list[self::DIAMOND_BOOTS] = DiamondBoots::class;
            self::$list[self::IRON_SWORD] = IronSword::class;
            self::$list[self::IRON_INGOT] = IronIngot::class;
            self::$list[self::GOLD_INGOT] = GoldIngot::class;
            self::$list[self::IRON_SHOVEL] = IronShovel::class;
            self::$list[self::IRON_PICKAXE] = IronPickaxe::class;
            self::$list[self::IRON_AXE] = IronAxe::class;
            self::$list[self::IRON_HOE] = IronHoe::class;
            self::$list[self::DIAMOND_SWORD] = DiamondSword::class;
            self::$list[self::DIAMOND_SHOVEL] = DiamondShovel::class;
            self::$list[self::DIAMOND_PICKAXE] = DiamondPickaxe::class;
            self::$list[self::DIAMOND_AXE] = DiamondAxe::class;
            self::$list[self::DIAMOND_HOE] = DiamondHoe::class;
            self::$list[self::GOLD_SWORD] = GoldSword::class;
            self::$list[self::GOLD_SHOVEL] = GoldShovel::class;
            self::$list[self::GOLD_PICKAXE] = GoldPickaxe::class;
            self::$list[self::GOLD_AXE] = GoldAxe::class;
            self::$list[self::GOLD_HOE] = GoldHoe::class;
            self::$list[self::STONE_SWORD] = StoneSword::class;
            self::$list[self::STONE_SHOVEL] = StoneShovel::class;
            self::$list[self::STONE_PICKAXE] = StonePickaxe::class;
            self::$list[self::STONE_AXE] = StoneAxe::class;
            self::$list[self::STONE_HOE] = StoneHoe::class;
            self::$list[self::WOODEN_SWORD] = WoodenSword::class;
            self::$list[self::WOODEN_SHOVEL] = WoodenShovel::class;
            self::$list[self::WOODEN_PICKAXE] = WoodenPickaxe::class;
            self::$list[self::WOODEN_AXE] = WoodenAxe::class;
            self::$list[self::WOODEN_HOE] = WoodenHoe::class;
            self::$list[self::FLINT_STEEL] = FlintSteel::class;
            self::$list[self::SHEARS] = Shears::class;
            self::$list[self::BOW] = Bow::class;

            self::$list[self::RAW_FISH] = Fish::class;
            self::$list[self::COOKED_FISH] = CookedFish::class;

            self::$list[self::NETHER_QUARTZ] = NetherQuartz::class;
            self::$list[self::POTION] = Potion::class;
            self::$list[self::GLASS_BOTTLE] = GlassBottle::class;
            self::$list[self::SPLASH_POTION] = SplashPotion::class;
            self::$list[self::ENCHANTING_BOTTLE] = EnchantingBottle::class;
            self::$list[self::BOAT] = Boat::class;
            self::$list[self::MINECART] = Minecart::class;
            self::$list[self::MINECART_WITH_CHEST] = MinecartWithChest::class;
            self::$list[self::MINECART_WITH_HOPPER] = MinecartWithHopper::class;
            self::$list[self::MINECART_WITH_TNT] = MinecartWithTNT::class;

            self::$list[self::ARROW] = Arrow::class;
            self::$list[self::STRING] = ItemString::class;
            self::$list[self::GUNPOWDER] = Gunpowder::class;
            self::$list[self::WHEAT] = Wheat::class;
            self::$list[self::BREAD] = Bread::class;
            self::$list[self::FLINT] = Flint::class;
            self::$list[self::FLINT] = Flint::class;
            self::$list[self::RAW_PORKCHOP] = RawPorkchop::class;
            self::$list[self::COOKED_PORKCHOP] = CookedPorkchop::class;
            self::$list[self::GOLDEN_APPLE] = GoldenApple::class;
            self::$list[self::MINECART] = Minecart::class;
            self::$list[self::REDSTONE] = Redstone::class;
            self::$list[self::LEATHER] = Leather::class;
            self::$list[self::CLAY] = Clay::class;
            self::$list[self::PAPER] = Paper::class;
            self::$list[self::BOOK] = Book::class;
            self::$list[self::SLIMEBALL] = Slimeball::class;
            self::$list[self::EGG] = Egg::class;
            self::$list[self::COMPASS] = Compass::class;
            self::$list[self::CLOCK] = Clock::class;
            self::$list[self::GLOWSTONE_DUST] = GlowstoneDust::class;
            self::$list[self::DYE] = Dye::class;
            self::$list[self::BONE] = Bone::class;
            self::$list[self::SUGAR] = Sugar::class;
            self::$list[self::COOKIE] = Cookie::class;
            self::$list[self::MELON] = Melon::class;
            self::$list[self::RAW_BEEF] = RawBeef::class;
            self::$list[self::STEAK] = Steak::class;
            self::$list[self::RAW_CHICKEN] = RawChicken::class;
            self::$list[self::COOKED_CHICKEN] = CookedChicken::class;
            self::$list[self::GOLD_NUGGET] = GoldNugget::class;
            self::$list[self::EMERALD] = Emerald::class;
            self::$list[self::BAKED_POTATO] = BakedPotato::class;
            self::$list[self::PUMPKIN_PIE] = PumpkinPie::class;
            self::$list[self::NETHER_BRICK] = NetherBrick::class;
            self::$list[self::QUARTZ] = Quartz::class;
            self::$list[self::BREWING_STAND] = BrewingStand::class;
            self::$list[self::CAMERA] = Camera::class;
            self::$list[self::BEETROOT] = Beetroot::class;
            self::$list[self::FLOWER_POT] = FlowerPot::class;
            self::$list[self::SKULL] = Skull::class;
            self::$list[self::COOKED_RABBIT] = CookedRabbit::class;
            self::$list[self::GOLDEN_CARROT] = GoldenCarrot::class;
            self::$list[self::NETHER_WART] = NetherWart::class;
            self::$list[self::SPIDER_EYE] = SpiderEye::class;
            self::$list[self::FERMENTED_SPIDER_EYE] = FermentedSpiderEye::class;
            self::$list[self::BLAZE_POWDER] = BlazePowder::class;
            self::$list[self::MAGMA_CREAM] = MagmaCream::class;
            self::$list[self::GLISTERING_MELON] = GlisteringMelon::class;
            self::$list[self::ITEM_FRAME] = ItemFrame::class;
            self::$list[self::ENCHANTED_BOOK] = EnchantedBook::class;
            self::$list[self::REPEATER] = Repeater::class;
            self::$list[self::CAULDRON] = Cauldron::class;
            self::$list[self::ENCHANTING_GOLDEN_APPLE] = EnchantedGoldenApple::class;
            self::$list[self::ROTTEN_FLESH] = RottenFlesh::class;

            self::$list[self::HOPPER] = Hopper::class;
            self::$list[self::COMPARATOR] = Comparator::class;
            self::$list[self::ENDER_PEARL] = EnderPearl::class;
            self::$list[self::EMPTY_MAP] = EmptyMap::class;
            self::$list[self::FILLED_MAP] = FilledMap::class;

            for ($i = 0; $i < 256; ++$i) {
                if (Block::$list[$i] !== null) {
                    self::$list[$i] = Block::$list[$i];
                }
            }
        }

        self::initCreativeItems($readFromJson);
    }

    private static $creative = [];

    private static function initCreativeItems($readFromJson = false)
    {
        self::clearCreativeItems();
        if (!$readFromJson) {
            //Building
            self::addCreativeItem(Item::get(Item::COBBLESTONE, 0));
            self::addCreativeItem(Item::get(Item::STONE_BRICKS, 0));
            self::addCreativeItem(Item::get(Item::STONE_BRICKS, 1));
            self::addCreativeItem(Item::get(Item::STONE_BRICKS, 2));
            self::addCreativeItem(Item::get(Item::STONE_BRICKS, 3));
            self::addCreativeItem(Item::get(Item::MOSS_STONE, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_PLANKS, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_PLANKS, 1));
            self::addCreativeItem(Item::get(Item::WOODEN_PLANKS, 2));
            self::addCreativeItem(Item::get(Item::WOODEN_PLANKS, 3));
            self::addCreativeItem(Item::get(Item::WOODEN_PLANKS, 4));
            self::addCreativeItem(Item::get(Item::WOODEN_PLANKS, 5));
            self::addCreativeItem(Item::get(Item::BRICKS, 0));
            self::addCreativeItem(Item::get(Item::STONE, 0));
            self::addCreativeItem(Item::get(Item::STONE, 1));
            self::addCreativeItem(Item::get(Item::STONE, 2));
            self::addCreativeItem(Item::get(Item::STONE, 3));
            self::addCreativeItem(Item::get(Item::STONE, 4));
            self::addCreativeItem(Item::get(Item::STONE, 5));
            self::addCreativeItem(Item::get(Item::STONE, 6));
            self::addCreativeItem(Item::get(Item::DIRT, 0));
            self::addCreativeItem(Item::get(Item::PODZOL, 0));
            self::addCreativeItem(Item::get(Item::GRASS, 0));
            self::addCreativeItem(Item::get(Item::MYCELIUM, 0));
            self::addCreativeItem(Item::get(Item::CLAY_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::HARDENED_CLAY, 0));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 0));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 1));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 2));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 3));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 4));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 5));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 6));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 7));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 8));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 9));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 10));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 11));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 12));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 13));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 14));
            self::addCreativeItem(Item::get(Item::STAINED_CLAY, 15));
            self::addCreativeItem(Item::get(Item::SANDSTONE, 0));
            self::addCreativeItem(Item::get(Item::SANDSTONE, 1));
            self::addCreativeItem(Item::get(Item::SANDSTONE, 2));
            self::addCreativeItem(Item::get(Item::RED_SANDSTONE, 0));
            self::addCreativeItem(Item::get(Item::RED_SANDSTONE, 1));
            self::addCreativeItem(Item::get(Item::RED_SANDSTONE, 2));
            self::addCreativeItem(Item::get(Item::SAND, 0));
            self::addCreativeItem(Item::get(Item::SAND, 1));
            self::addCreativeItem(Item::get(Item::GRAVEL, 0));
            self::addCreativeItem(Item::get(Item::TRUNK, 0));
            self::addCreativeItem(Item::get(Item::TRUNK, 1));
            self::addCreativeItem(Item::get(Item::TRUNK, 2));
            self::addCreativeItem(Item::get(Item::TRUNK, 3));
            self::addCreativeItem(Item::get(Item::TRUNK2, 0));
            self::addCreativeItem(Item::get(Item::TRUNK2, 1));
            self::addCreativeItem(Item::get(Item::NETHER_BRICKS, 0));
            self::addCreativeItem(Item::get(Item::NETHERRACK, 0));
            self::addCreativeItem(Item::get(Item::SOUL_SAND, 0));
            self::addCreativeItem(Item::get(Item::BEDROCK, 0));
            self::addCreativeItem(Item::get(Item::COBBLESTONE_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::OAK_WOODEN_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::SPRUCE_WOODEN_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::BIRCH_WOODEN_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::JUNGLE_WOODEN_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::ACACIA_WOODEN_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::DARK_OAK_WOODEN_STAIRS, 0));

            self::addCreativeItem(Item::get(Item::SLIME_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::BRICK_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::SANDSTONE_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::RED_SANDSTONE_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::STONE_BRICK_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::NETHER_BRICKS_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::QUARTZ_STAIRS, 0));
            self::addCreativeItem(Item::get(Item::SLAB, 0));
            self::addCreativeItem(Item::get(Item::SLAB, 3));
            self::addCreativeItem(Item::get(Item::WOODEN_SLAB, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_SLAB, 1));
            self::addCreativeItem(Item::get(Item::WOODEN_SLAB, 2));
            self::addCreativeItem(Item::get(Item::WOODEN_SLAB, 3));
            self::addCreativeItem(Item::get(Item::WOODEN_SLAB, 4));
            self::addCreativeItem(Item::get(Item::WOODEN_SLAB, 5));
            self::addCreativeItem(Item::get(Item::SLAB, 4));
            self::addCreativeItem(Item::get(Item::SLAB, 1));
            self::addCreativeItem(Item::get(Item::SLAB, 5));
            self::addCreativeItem(Item::get(Item::SLAB, 6));
            self::addCreativeItem(Item::get(Item::SLAB, 7));
            self::addCreativeItem(Item::get(Item::RED_SANDSTONE_SLAB, 0));
            self::addCreativeItem(Item::get(Item::QUARTZ_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::QUARTZ_BLOCK, 1));
            self::addCreativeItem(Item::get(Item::QUARTZ_BLOCK, 2));
            self::addCreativeItem(Item::get(Item::COAL_ORE, 0));
            self::addCreativeItem(Item::get(Item::IRON_ORE, 0));
            self::addCreativeItem(Item::get(Item::GOLD_ORE, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_ORE, 0));
            self::addCreativeItem(Item::get(Item::LAPIS_ORE, 0));
            self::addCreativeItem(Item::get(Item::REDSTONE_ORE, 0));
            self::addCreativeItem(Item::get(Item::EMERALD_ORE, 0));
            self::addCreativeItem(Item::get(Item::NETHER_QUARTZ_ORE, 0));
            self::addCreativeItem(Item::get(Item::OBSIDIAN, 0));
            self::addCreativeItem(Item::get(Item::ICE, 0));
            self::addCreativeItem(Item::get(Item::PACKED_ICE, 0));
            self::addCreativeItem(Item::get(Item::SNOW_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::END_STONE, 0));
            //Decoration
            self::addCreativeItem(Item::get(Item::COBBLESTONE_WALL, 0));
            self::addCreativeItem(Item::get(Item::COBBLESTONE_WALL, 1));
            self::addCreativeItem(Item::get(Item::WATER_LILY, 0));
            self::addCreativeItem(Item::get(Item::GOLD_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::IRON_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::LAPIS_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::COAL_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::EMERALD_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::REDSTONE_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::SNOW_LAYER, 0));
            self::addCreativeItem(Item::get(Item::GLASS, 0));
            self::addCreativeItem(Item::get(Item::GLOWSTONE_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::VINES, 0));
            self::addCreativeItem(Item::get(Item::LADDER, 0));
            self::addCreativeItem(Item::get(Item::SPONGE, 0));
            self::addCreativeItem(Item::get(Item::GLASS_PANE, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_DOOR, 0));
            self::addCreativeItem(Item::get(Item::SPRUCE_DOOR, 0));
            self::addCreativeItem(Item::get(Item::BIRCH_DOOR, 0));
            self::addCreativeItem(Item::get(Item::JUNGLE_DOOR, 0));
            self::addCreativeItem(Item::get(Item::ACACIA_DOOR, 0));
            self::addCreativeItem(Item::get(Item::DARK_OAK_DOOR, 0));
            self::addCreativeItem(Item::get(Item::IRON_DOOR, 0));
            self::addCreativeItem(Item::get(Item::TRAPDOOR, 0));
            self::addCreativeItem(Item::get(Item::IRON_TRAPDOOR, 0));
            self::addCreativeItem(Item::get(Item::FENCE, Fence::FENCE_OAK));
            self::addCreativeItem(Item::get(Item::FENCE, Fence::FENCE_SPRUCE));
            self::addCreativeItem(Item::get(Item::FENCE, Fence::FENCE_BIRCH));
            self::addCreativeItem(Item::get(Item::FENCE, Fence::FENCE_JUNGLE));
            self::addCreativeItem(Item::get(Item::FENCE, Fence::FENCE_ACACIA));
            self::addCreativeItem(Item::get(Item::FENCE, Fence::FENCE_DARKOAK));
            self::addCreativeItem(Item::get(Item::NETHER_BRICK_FENCE, 0));
            self::addCreativeItem(Item::get(Item::FENCE_GATE, 0));
            self::addCreativeItem(Item::get(Item::FENCE_GATE_BIRCH, 0));
            self::addCreativeItem(Item::get(Item::FENCE_GATE_SPRUCE, 0));
            self::addCreativeItem(Item::get(Item::FENCE_GATE_DARK_OAK, 0));
            self::addCreativeItem(Item::get(Item::FENCE_GATE_JUNGLE, 0));
            self::addCreativeItem(Item::get(Item::FENCE_GATE_ACACIA, 0));
            self::addCreativeItem(Item::get(Item::IRON_BARS, 0));
            self::addCreativeItem(Item::get(Item::BED, 0));
            self::addCreativeItem(Item::get(Item::BOOKSHELF, 0));
            self::addCreativeItem(Item::get(Item::PAINTING, 0));
            self::addCreativeItem(Item::get(Item::ITEM_FRAME, 0));
            self::addCreativeItem(Item::get(Item::WORKBENCH, 0));
            self::addCreativeItem(Item::get(Item::STONECUTTER, 0));
            self::addCreativeItem(Item::get(Item::CHEST, 0));
            self::addCreativeItem(Item::get(Item::TRAPPED_CHEST, 0));
            self::addCreativeItem(Item::get(Item::FURNACE, 0));
            self::addCreativeItem(Item::get(Item::BREWING_STAND, 0));
            self::addCreativeItem(Item::get(Item::CAULDRON, 0));
            self::addCreativeItem(Item::get(Item::NOTEBLOCK, 0));
            self::addCreativeItem(Item::get(Item::END_PORTAL, 0));
            self::addCreativeItem(Item::get(Item::ANVIL, 0));
            self::addCreativeItem(Item::get(Item::ANVIL, 4));
            self::addCreativeItem(Item::get(Item::ANVIL, 8));
            self::addCreativeItem(Item::get(Item::DANDELION, 0));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_POPPY));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_BLUE_ORCHID));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_ALLIUM));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_AZURE_BLUET));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_RED_TULIP));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_ORANGE_TULIP));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_WHITE_TULIP));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_PINK_TULIP));
            self::addCreativeItem(Item::get(Item::RED_FLOWER, Flower::TYPE_OXEYE_DAISY));
            self::addCreativeItem(Item::get(Item::DOUBLE_PLANT, 0));
            self::addCreativeItem(Item::get(Item::DOUBLE_PLANT, 1));
            self::addCreativeItem(Item::get(Item::DOUBLE_PLANT, 2));
            self::addCreativeItem(Item::get(Item::DOUBLE_PLANT, 3));
            self::addCreativeItem(Item::get(Item::DOUBLE_PLANT, 4));
            self::addCreativeItem(Item::get(Item::DOUBLE_PLANT, 5));
            self::addCreativeItem(Item::get(Item::BROWN_MUSHROOM, 0));
            self::addCreativeItem(Item::get(Item::RED_MUSHROOM, 0));
            self::addCreativeItem(Item::get(Item::BROWN_MUSHROOM_BLOCK, 14));
            self::addCreativeItem(Item::get(Item::RED_MUSHROOM_BLOCK, 14));
            self::addCreativeItem(Item::get(Item::BROWN_MUSHROOM_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::BROWN_MUSHROOM_BLOCK, 10));
            self::addCreativeItem(Item::get(Item::CACTUS, 0));
            self::addCreativeItem(Item::get(Item::MELON_BLOCK, 0));
            self::addCreativeItem(Item::get(Item::PUMPKIN, 0));
            self::addCreativeItem(Item::get(Item::LIT_PUMPKIN, 0));
            self::addCreativeItem(Item::get(Item::COBWEB, 0));
            self::addCreativeItem(Item::get(Item::HAY_BALE, 0));
            self::addCreativeItem(Item::get(Item::TALL_GRASS, 1));
            self::addCreativeItem(Item::get(Item::TALL_GRASS, 2));
            self::addCreativeItem(Item::get(Item::DEAD_BUSH, 0));
            self::addCreativeItem(Item::get(Item::SAPLING, 0));
            self::addCreativeItem(Item::get(Item::SAPLING, 1));
            self::addCreativeItem(Item::get(Item::SAPLING, 2));
            self::addCreativeItem(Item::get(Item::SAPLING, 3));
            self::addCreativeItem(Item::get(Item::SAPLING, 4));
            self::addCreativeItem(Item::get(Item::SAPLING, 5));
            self::addCreativeItem(Item::get(Item::LEAVES, 0));
            self::addCreativeItem(Item::get(Item::LEAVES, 1));
            self::addCreativeItem(Item::get(Item::LEAVES, 2));
            self::addCreativeItem(Item::get(Item::LEAVES, 3));
            self::addCreativeItem(Item::get(Item::LEAVES2, 0));
            self::addCreativeItem(Item::get(Item::LEAVES2, 1));
            self::addCreativeItem(Item::get(Item::CAKE, 0));
            self::addCreativeItem(Item::get(Item::SKULL, 0));
            self::addCreativeItem(Item::get(Item::SKULL, 1));
            self::addCreativeItem(Item::get(Item::SKULL, 2));
            self::addCreativeItem(Item::get(Item::SKULL, 3));
            self::addCreativeItem(Item::get(Item::SKULL, 4));
            self::addCreativeItem(Item::get(Item::SIGN, 0));
            self::addCreativeItem(Item::get(Item::FLOWER_POT, 0));
            self::addCreativeItem(Item::get(Item::MONSTER_SPAWNER, 0));
            self::addCreativeItem(Item::get(Item::ENCHANTING_TABLE, 0));
            self::addCreativeItem(Item::get(Item::WOOL, 0));
            self::addCreativeItem(Item::get(Item::WOOL, 8));
            self::addCreativeItem(Item::get(Item::WOOL, 7));
            self::addCreativeItem(Item::get(Item::WOOL, 15));
            self::addCreativeItem(Item::get(Item::WOOL, 12));
            self::addCreativeItem(Item::get(Item::WOOL, 14));
            self::addCreativeItem(Item::get(Item::WOOL, 1));
            self::addCreativeItem(Item::get(Item::WOOL, 4));
            self::addCreativeItem(Item::get(Item::WOOL, 5));
            self::addCreativeItem(Item::get(Item::WOOL, 13));
            self::addCreativeItem(Item::get(Item::WOOL, 9));
            self::addCreativeItem(Item::get(Item::WOOL, 3));
            self::addCreativeItem(Item::get(Item::WOOL, 11));
            self::addCreativeItem(Item::get(Item::WOOL, 10));
            self::addCreativeItem(Item::get(Item::WOOL, 2));
            self::addCreativeItem(Item::get(Item::WOOL, 6));
            self::addCreativeItem(Item::get(Item::CARPET, 0));
            self::addCreativeItem(Item::get(Item::CARPET, 8));
            self::addCreativeItem(Item::get(Item::CARPET, 7));
            self::addCreativeItem(Item::get(Item::CARPET, 15));
            self::addCreativeItem(Item::get(Item::CARPET, 12));
            self::addCreativeItem(Item::get(Item::CARPET, 14));
            self::addCreativeItem(Item::get(Item::CARPET, 1));
            self::addCreativeItem(Item::get(Item::CARPET, 4));
            self::addCreativeItem(Item::get(Item::CARPET, 5));
            self::addCreativeItem(Item::get(Item::CARPET, 13));
            self::addCreativeItem(Item::get(Item::CARPET, 9));
            self::addCreativeItem(Item::get(Item::CARPET, 3));
            self::addCreativeItem(Item::get(Item::CARPET, 11));
            self::addCreativeItem(Item::get(Item::CARPET, 10));
            self::addCreativeItem(Item::get(Item::CARPET, 2));
            self::addCreativeItem(Item::get(Item::CARPET, 6));
            //Tools
            self::addCreativeItem(Item::get(Item::RAIL, 0));
            self::addCreativeItem(Item::get(Item::POWERED_RAIL, 0));
            self::addCreativeItem(Item::get(Item::DETECTOR_RAIL, 0));
            self::addCreativeItem(Item::get(Item::ACTIVATOR_RAIL, 0));
            self::addCreativeItem(Item::get(Item::TORCH, 0));
            self::addCreativeItem(Item::get(Item::BUCKET, 0));
            self::addCreativeItem(Item::get(Item::BUCKET, 1));
            self::addCreativeItem(Item::get(Item::BUCKET, 8));
            self::addCreativeItem(Item::get(Item::BUCKET, 10));
            self::addCreativeItem(Item::get(Item::TNT, 0));
            self::addCreativeItem(Item::get(Item::REDSTONE, 0));
            self::addCreativeItem(Item::get(Item::BOW, 0));
            self::addCreativeItem(Item::get(Item::FISHING_ROD, 0));
            self::addCreativeItem(Item::get(Item::FLINT_AND_STEEL, 0));
            self::addCreativeItem(Item::get(Item::SHEARS, 0));
            self::addCreativeItem(Item::get(Item::CLOCK, 0));
            self::addCreativeItem(Item::get(Item::COMPASS, 0));
            self::addCreativeItem(Item::get(Item::MINECART, 0));
            self::addCreativeItem(Item::get(Item::MINECART_WITH_CHEST, 0));
            self::addCreativeItem(Item::get(Item::MINECART_WITH_HOPPER, 0));
            self::addCreativeItem(Item::get(Item::MINECART_WITH_TNT, 0));
            for ($i = 0; $i <= 5; $i++) {
                self::addCreativeItem(Item::get(Item::BOAT, $i));
            }
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 15));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 10));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 11));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 12));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 13));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 14));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 22));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 16));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 19));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 18));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 33));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 38));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 39));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 34));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 37));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 35));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 32));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 36));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 17));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 40));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 45));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 42));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 41));
            self::addCreativeItem(Item::get(Item::SPAWN_EGG, 43));
            self::addCreativeItem(Item::get(Item::WOODEN_SWORD, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_HOE, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_SHOVEL, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_PICKAXE, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_AXE, 0));
            self::addCreativeItem(Item::get(Item::STONE_SWORD, 0));
            self::addCreativeItem(Item::get(Item::STONE_HOE, 0));
            self::addCreativeItem(Item::get(Item::STONE_SHOVEL, 0));
            self::addCreativeItem(Item::get(Item::STONE_PICKAXE, 0));
            self::addCreativeItem(Item::get(Item::STONE_AXE, 0));
            self::addCreativeItem(Item::get(Item::IRON_SWORD, 0));
            self::addCreativeItem(Item::get(Item::IRON_HOE, 0));
            self::addCreativeItem(Item::get(Item::IRON_SHOVEL, 0));
            self::addCreativeItem(Item::get(Item::IRON_PICKAXE, 0));
            self::addCreativeItem(Item::get(Item::IRON_AXE, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_SWORD, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_HOE, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_SHOVEL, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_PICKAXE, 0));
            self::addCreativeItem(Item::get(Item::DIAMOND_AXE, 0));
            self::addCreativeItem(Item::get(Item::GOLD_SWORD, 0));
            self::addCreativeItem(Item::get(Item::GOLD_HOE, 0));
            self::addCreativeItem(Item::get(Item::GOLD_SHOVEL, 0));
            self::addCreativeItem(Item::get(Item::GOLD_PICKAXE, 0));
            self::addCreativeItem(Item::get(Item::GOLD_AXE, 0));
            for ($i = 298; $i < 318; $i++) { //All armor
                self::addCreativeItem(Item::get($i, 0));
            }
            self::addCreativeItem(Item::get(Item::LEVER, 0));
            self::addCreativeItem(Item::get(Item::INACTIVE_REDSTONE_LAMP, 0));
            self::addCreativeItem(Item::get(Item::LIT_REDSTONE_TORCH, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_PRESSURE_PLATE, 0));
            self::addCreativeItem(Item::get(Item::STONE_PRESSURE_PLATE, 0));
            self::addCreativeItem(Item::get(Item::LIGHT_WEIGHTED_PRESSURE_PLATE, 0));
            self::addCreativeItem(Item::get(Item::HEAVY_WEIGHTED_PRESSURE_PLATE, 0));
            self::addCreativeItem(Item::get(Item::WOODEN_BUTTON, 0));
            self::addCreativeItem(Item::get(Item::STONE_BUTTON, 0));
            self::addCreativeItem(Item::get(Item::DAYLIGHT_SENSOR, 0));
            self::addCreativeItem(Item::get(Item::TRIPWIRE_HOOK, 0));
            self::addCreativeItem(Item::get(Item::REPEATER, 0));
            self::addCreativeItem(Item::get(Item::COMPARATOR, 0));
            self::addCreativeItem(Item::get(Item::DROPPER, 3));
            self::addCreativeItem(Item::get(Item::DISPENSER, 3));
            self::addCreativeItem(Item::get(Item::HOPPER, 0));
            self::addCreativeItem(Item::get(Item::SNOWBALL, 0));
            //Seeds
            self::addCreativeItem(Item::get(Item::COAL, 0));
            self::addCreativeItem(Item::get(Item::COAL, 1));
            self::addCreativeItem(Item::get(Item::DIAMOND, 0));
            self::addCreativeItem(Item::get(Item::IRON_INGOT, 0));
            self::addCreativeItem(Item::get(Item::GOLD_INGOT, 0));
            self::addCreativeItem(Item::get(Item::EMERALD, 0));
            self::addCreativeItem(Item::get(Item::STICKS, 0));
            self::addCreativeItem(Item::get(Item::BOWL, 0));
            self::addCreativeItem(Item::get(Item::STRING, 0));
            self::addCreativeItem(Item::get(Item::FEATHER, 0));
            self::addCreativeItem(Item::get(Item::FLINT, 0));
            self::addCreativeItem(Item::get(Item::LEATHER, 0));
            self::addCreativeItem(Item::get(Item::RABBIT_HIDE, 0));
            self::addCreativeItem(Item::get(Item::CLAY, 0));
            self::addCreativeItem(Item::get(Item::SUGAR, 0));
            self::addCreativeItem(Item::get(Item::QUARTZ, 0));
            self::addCreativeItem(Item::get(Item::PAPER, 0));
            self::addCreativeItem(Item::get(Item::BOOK, 0));
            self::addCreativeItem(Item::get(Item::ARROW, 0));
            self::addCreativeItem(Item::get(Item::BONE, 0));
            self::addCreativeItem(Item::get(Item::EMPTY_MAP, 0));
            self::addCreativeItem(Item::get(Item::SUGAR_CANES, 0));
            self::addCreativeItem(Item::get(Item::WHEAT, 0));
            self::addCreativeItem(Item::get(Item::SEEDS, 0));
            self::addCreativeItem(Item::get(Item::PUMPKIN_SEEDS, 0));
            self::addCreativeItem(Item::get(Item::MELON_SEEDS, 0));
            self::addCreativeItem(Item::get(Item::BEETROOT_SEEDS, 0));
            self::addCreativeItem(Item::get(Item::APPLE, 0));
            self::addCreativeItem(Item::get(Item::GOLDEN_APPLE, 0));
            self::addCreativeItem(Item::get(Item::ENCHANTING_GOLDEN_APPLE, 0));
            self::addCreativeItem(Item::get(Item::RAW_FISH, 0));
            for ($i = 0; $i <= 2; $i++) {
                self::addCreativeItem(Item::get(460 + $i, 0));
            }//All kinds of fish
            self::addCreativeItem(Item::get(Item::COOKED_FISH, 0));
            self::addCreativeItem(Item::get(Item::COOKED_SALMON, 0));//Cooked Fish
            self::addCreativeItem(Item::get(Item::ROTTEN_FLESH, 0));
            self::addCreativeItem(Item::get(Item::MUSHROOM_STEW, 0));
            self::addCreativeItem(Item::get(Item::BREAD, 0));
            self::addCreativeItem(Item::get(Item::RAW_PORKCHOP, 0));
            self::addCreativeItem(Item::get(Item::COOKED_PORKCHOP, 0));
            self::addCreativeItem(Item::get(Item::RAW_CHICKEN, 0));
            self::addCreativeItem(Item::get(Item::COOKED_CHICKEN, 0));
            self::addCreativeItem(Item::get(Item::RAW_BEEF, 0));
            self::addCreativeItem(Item::get(Item::STEAK, 0));
            self::addCreativeItem(Item::get(Item::MELON, 0));
            self::addCreativeItem(Item::get(Item::CARROT, 0));
            self::addCreativeItem(Item::get(Item::POTATO, 0));
            self::addCreativeItem(Item::get(Item::BAKED_POTATO, 0));
            self::addCreativeItem(Item::get(Item::POISONOUS_POTATO, 0));
            self::addCreativeItem(Item::get(Item::BEETROOT, 0));
            self::addCreativeItem(Item::get(Item::COOKIE, 0));
            self::addCreativeItem(Item::get(Item::PUMPKIN_PIE, 0));
            self::addCreativeItem(Item::get(Item::RAW_RABBIT, 0));
            self::addCreativeItem(Item::get(Item::COOKED_RABBIT, 0));
            self::addCreativeItem(Item::get(Item::RABBIT_STEW, 0));
            self::addCreativeItem(Item::get(Item::MAGMA_CREAM, 0));
            self::addCreativeItem(Item::get(Item::BLAZE_ROD, 0));
            self::addCreativeItem(Item::get(Item::GOLD_NUGGET, 0));
            self::addCreativeItem(Item::get(Item::GOLDEN_CARROT, 0));
            self::addCreativeItem(Item::get(Item::GLISTERING_MELON, 0));
            self::addCreativeItem(Item::get(Item::RABBIT_FOOT, 0));
            self::addCreativeItem(Item::get(Item::GHAST_TEAR, 0));
            self::addCreativeItem(Item::get(Item::SLIMEBALL, 0));
            self::addCreativeItem(Item::get(Item::BLAZE_POWDER, 0));
            self::addCreativeItem(Item::get(Item::NETHER_WART, 0));
            self::addCreativeItem(Item::get(Item::GUNPOWDER, 0));
            self::addCreativeItem(Item::get(Item::GLOWSTONE_DUST, 0));
            self::addCreativeItem(Item::get(Item::SPIDER_EYE, 0));
            self::addCreativeItem(Item::get(Item::FERMENTED_SPIDER_EYE, 0));
            self::addCreativeItem(Item::get(Item::ENCHANTING_BOTTLE, 0));
            for ($i = 0; $i <= 79; $i++) {
                self::addCreativeItem(Item::get(Item::ENCHANTED_BOOK, $i));
            }
            self::addCreativeItem(Item::get(Item::DYE, 0));
            self::addCreativeItem(Item::get(Item::DYE, 8));
            self::addCreativeItem(Item::get(Item::DYE, 7));
            self::addCreativeItem(Item::get(Item::DYE, 15));
            self::addCreativeItem(Item::get(Item::DYE, 12));
            self::addCreativeItem(Item::get(Item::DYE, 14));
            self::addCreativeItem(Item::get(Item::DYE, 1));
            self::addCreativeItem(Item::get(Item::DYE, 4));
            self::addCreativeItem(Item::get(Item::DYE, 5));
            self::addCreativeItem(Item::get(Item::DYE, 13));
            self::addCreativeItem(Item::get(Item::DYE, 9));
            self::addCreativeItem(Item::get(Item::DYE, 3));
            self::addCreativeItem(Item::get(Item::DYE, 11));
            self::addCreativeItem(Item::get(Item::DYE, 10));
            self::addCreativeItem(Item::get(Item::DYE, 2));
            self::addCreativeItem(Item::get(Item::DYE, 6));
            self::addCreativeItem(Item::get(Item::GLASS_BOTTLE, 0));
            for ($i = 0; $i <= 35; $i++) {
                self::addCreativeItem(Item::get(Item::POTION, $i));
            }
            for ($i = 0; $i <= 35; $i++) {
                self::addCreativeItem(Item::get(Item::SPLASH_POTION, $i));
            }
        } else {
            $creativeItems = new Config(Server::getInstance()->getFilePath() . "src/pocketmine/resources/creativeitems.json", Config::JSON, []);
            foreach ($creativeItems->getAll() as $item) {
                self::addCreativeItem(Item::get($item["ID"], $item["Damage"]));
            }
        }
    }

    public static function clearCreativeItems()
    {
        Item::$creative = [];
    }

    public static function getCreativeItems(): array
    {
        return Item::$creative;
    }

    public static function addCreativeItem(Item $item)
    {
        Item::$creative[] = Item::get($item->getId(), $item->getDamage());
    }

    public static function removeCreativeItem(Item $item)
    {
        $index = self::getCreativeItemIndex($item);
        if ($index !== -1) {
            unset(Item::$creative[$index]);
        }
    }

    public static function isCreativeItem(Item $item): bool
    {
        foreach (Item::$creative as $i => $d) {
            if ($item->equals($d, !$item->isTool())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $index
     * @return Item
     */
    public static function getCreativeItem(int $index)
    {
        return isset(Item::$creative[$index]) ? Item::$creative[$index] : null;
    }

    public static function getCreativeItemIndex(Item $item): int
    {
        foreach (Item::$creative as $i => $d) {
            if ($item->equals($d, !$item->isTool())) {
                return $i;
            }
        }

        return -1;
    }

    public static function get($id, $meta = 0, int $count = 1, $tags = ""): Item
    {
        try {
            if (is_string($id)) {
                $item = Item::fromString($id);
                $item->setCount($count);
                $item->setDamage($meta);
                return $item;
            }
            $class = self::$list[$id];
            if ($class === null) {
                return (new Item($id, $meta, $count))->setCompoundTag($tags);
            } elseif ($id < 256) {
                return (new ItemBlock(new $class($meta), $meta, $count))->setCompoundTag($tags);
            } else {
                return (new $class($meta, $count))->setCompoundTag($tags);
            }
        } catch (\RuntimeException $e) {
            return (new Item($id, $meta, $count))->setCompoundTag($tags);
        }
    }

    /**
     * @param string $str
     * @param bool $multiple
     * @return Item[]|Item
     */
    public static function fromString(string $str, bool $multiple = false)
    {
        if ($multiple === true) {
            $blocks = [];
            foreach (explode(",", $str) as $b) {
                $blocks[] = self::fromString($b, false);
            }

            return $blocks;
        } else {
            $b = explode(":", str_replace([" ", "minecraft:"], ["_", ""], trim($str)));
            if (!isset($b[1])) {
                $meta = 0;
            } else {
                $meta = $b[1] & 0xFFFF;
            }

            if (defined(Item::class . "::" . strtoupper($b[0]))) {
                $item = self::get(constant(Item::class . "::" . strtoupper($b[0])), $meta);
                if ($item->getId() === self::AIR and strtoupper($b[0]) !== "AIR") {
                    $item = self::get($b[0] & 0xFFFF, $meta);
                }
            } else {
                $item = self::get($b[0] & 0xFFFF, $meta);
            }

            return $item;
        }
    }

    public function __construct($id, $meta = 0, int $count = 1, string $name = "Unknown")
    {
        if (is_string($id)) {
            $item = Item::fromString($id);
            $id = $item->getId();
            if ($item->getDamage() != $meta) $meta = $item->getDamage();
            $name = $item->getName();
        }
        $this->id = $id & 0xffff;
        $this->meta = (int)$meta !== null ? (int)$meta & 0xffff : null;
        $this->count = $count;
        $this->name = $name;
        if (!isset($this->block) and (int)$this->id <= 0xff and isset(Block::$list[$this->id])) {
            $this->block = Block::get($this->id, $this->meta);
            $this->name = $this->block->getName();
        }
    }

    public function setCompoundTag($tags)
    {
        if ($tags instanceof CompoundTag) {
            $this->setNamedTag($tags);
        } else {
            $this->tags = $tags;
            $this->cachedNBT = null;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCompoundTag()
    {
        return $this->tags;
    }

    public function hasCompoundTag(): bool
    {
        return $this->tags !== "" and $this->tags !== null;
    }

    public function hasCustomBlockData(): bool
    {
        if (!$this->hasCompoundTag()) {
            return false;
        }

        $tag = $this->getNamedTag();
        if (isset($tag->BlockEntityTag) and $tag->BlockEntityTag instanceof CompoundTag) {
            return true;
        }

        return false;
    }

    public function clearCustomBlockData()
    {
        if (!$this->hasCompoundTag()) {
            return $this;
        }
        $tag = $this->getNamedTag();

        if (isset($tag->BlockEntityTag) and $tag->BlockEntityTag instanceof CompoundTag) {
            unset($tag->display->BlockEntityTag);
            $this->setNamedTag($tag);
        }

        return $this;
    }

    public function setCustomBlockData(CompoundTag $compound)
    {
        $tags = clone $compound;
        $tags->setName("BlockEntityTag");

        if (!$this->hasCompoundTag()) {
            $tag = new CompoundTag("", []);
        } else {
            $tag = $this->getNamedTag();
        }

        $tag->BlockEntityTag = $tags;
        $this->setNamedTag($tag);

        return $this;
    }

    public function getCustomBlockData()
    {
        if (!$this->hasCompoundTag()) {
            return null;
        }

        $tag = $this->getNamedTag();
        if (isset($tag->BlockEntityTag) and $tag->BlockEntityTag instanceof CompoundTag) {
            return $tag->BlockEntityTag;
        }

        return null;
    }

    public function hasEnchantments(): bool
    {
        if (!$this->hasCompoundTag()) {
            return false;
        }

        $tag = $this->getNamedTag();
        if (isset($tag->ench)) {
            $tag = $tag->ench;
            if ($tag instanceof ListTag) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $id
     * @return Enchantment|null
     */
    public function getEnchantment(int $id)
    {
        if (!$this->hasEnchantments()) {
            return null;
        }

        foreach ($this->getNamedTag()->ench as $entry) {
            if ($entry["id"] === $id) {
                $e = Enchantment::getEnchantment($entry["id"]);
                $e->setLevel($entry["lvl"]);
                return $e;
            }
        }

        return null;
    }

    /**
     * @param int $slot
     * @param string $tagName
     * @return CompoundTag
     */
    public function nbtSerialize(int $slot = -1, string $tagName = ""): CompoundTag
    {
        $tag = new CompoundTag($tagName, [
            "id" => new ShortTag("id", Binary::signShort($this->id)),
            "Count" => new ByteTag("Count", Binary::signByte($this->count)),
            "Damage" => new ShortTag("Damage", $this->meta),
        ]);

        if ($this->hasCompoundTag()) {
            $tag->tag = clone $this->getNamedTag();
            $tag->tag->setName("tag");
        }

        if ($slot !== -1) {
            $tag->Slot = new ByteTag("Slot", $slot);
        }

        return $tag;
    }

    /**
     * @param CompoundTag $tag
     * @return Item
     */
    public static function nbtDeserialize(CompoundTag $tag): Item
    {
        if (!isset($tag->id) or !isset($tag->Count)) {
            return Item::get(0);
        }

        $count = Binary::unsignByte($tag->Count->getValue());
        $meta = isset($tag->Damage) ? $tag->Damage->getValue() : 0;

        if ($tag->id instanceof ShortTag) {
            $item = Item::get(Binary::unsignShort($tag->id->getValue()), $meta, $count);
        } elseif($tag->id instanceof StringTag) {
            try {
                $item = Item::fromString($tag->id->getValue());
            } catch(\InvalidArgumentException $e) {
                return Item::get(Item::AIR, 0, 0);
            }
            $item->setDamage($meta);
            $item->setCount($count);
        } else {
            throw new \InvalidArgumentException("Item CompoundTag ID must be an instance of StringTag or ShortTag, " . get_class($tag->id) . " given");
        }

        if (isset($tag->tag) and $tag->tag instanceof CompoundTag) {
            $t = clone $tag->tag;
            $t->setName("");
            $item->setNamedTag($t);
        }

        return $item;
    }

    /**
     * @param $id
     * @return Int level|0(for null)
     */
    public function getEnchantmentLevel(int $id): int
    {
        if (!$this->hasEnchantments()) {
            return 0;
        }

        foreach ($this->getNamedTag()->ench as $entry) {
            if ($entry["id"] === $id) {
                $e = Enchantment::getEnchantment($entry["id"]);
                $e->setLevel($entry["lvl"]);
                $E_level = $e->getLevel() > Enchantment::getEnchantMaxLevel($id) ? Enchantment::getEnchantMaxLevel($id) : $e->getLevel();
                return $E_level;
            }
        }

        return 0;
    }

    /**
     * @param Enchantment $ench
     */
    public function addEnchantment(Enchantment $ench)
    {
        if (!$this->hasCompoundTag()) {
            $tag = new CompoundTag("", []);
        } else {
            $tag = $this->getNamedTag();
        }

        if (!isset($tag->ench)) {
            $tag->ench = new ListTag("ench", []);
            $tag->ench->setTagType(NBT::TAG_Compound);
        }

        $found = false;

        foreach ($tag->ench as $k => $entry) {
            if ($entry["id"] === $ench->getId()) {
                $tag->ench->{$k} = new CompoundTag("", [
                    "id" => new ShortTag("id", $ench->getId()),
                    "lvl" => new ShortTag("lvl", $ench->getLevel())
                ]);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $count = 0;
            foreach ($tag->ench as $key => $value) {
                if (is_numeric($key)) {
                    $count++;
                }
            }
            $tag->ench->{$count + 1} = new CompoundTag("", [
                "id" => new ShortTag("id", $ench->getId()),
                "lvl" => new ShortTag("lvl", $ench->getLevel())
            ]);
        }

        $this->setNamedTag($tag);
    }

    /**
     * @return Enchantment[]
     */
    public function getEnchantments(): array
    {
        if (!$this->hasEnchantments()) {
            return [];
        }

        $enchantments = [];

        foreach ($this->getNamedTag()->ench as $entry) {
            $e = Enchantment::getEnchantment($entry["id"]);
            $e->setLevel($entry["lvl"]);
            $enchantments[] = $e;
        }

        return $enchantments;
    }

    public function hasCustomName(): bool
    {
        if (!$this->hasCompoundTag()) {
            return false;
        }

        $tag = $this->getNamedTag();
        if (isset($tag->display)) {
            $tag = $tag->display;
            if ($tag instanceof CompoundTag and isset($tag->Name) and $tag->Name instanceof StringTag) {
                return true;
            }
        }

        return false;
    }

    public function getCustomName(): string
    {
        if (!$this->hasCompoundTag()) {
            return "";
        }

        $tag = $this->getNamedTag();
        if (isset($tag->display)) {
            $tag = $tag->display;
            if ($tag instanceof CompoundTag and isset($tag->Name) and $tag->Name instanceof StringTag) {
                return $tag->Name->getValue();
            }
        }

        return "";
    }

    public function setCustomName(string $name)
    {
        if ($name === "") {
            $this->clearCustomName();
        }

        if (!($hadCompoundTag = $this->hasCompoundTag())) {
            $tag = new CompoundTag("", []);
        } else {
            $tag = $this->getNamedTag();
        }

        if (isset($tag->display) and $tag->display instanceof CompoundTag) {
            $tag->display->Name = new StringTag("Name", $name);
        } else {
            $tag->display = new CompoundTag("display", [
                "Name" => new StringTag("Name", $name)
            ]);
        }

        if (!$hadCompoundTag) {
            $this->setCompoundTag($tag);
        }

        return $this;
    }

    public function clearCustomName()
    {
        if (!$this->hasCompoundTag()) {
            return $this;
        }
        $tag = $this->getNamedTag();

        if (isset($tag->display) and $tag->display instanceof CompoundTag) {
            unset($tag->display->Name);
            if ($tag->display->getCount() === 0) {
                unset($tag->display);
            }

            $this->setNamedTag($tag);
        }

        return $this;
    }

    public function getNamedTagEntry($name)
    {
        $tag = $this->getNamedTag();
        if ($tag !== null) {
            return isset($tag->{$name}) ? $tag->{$name} : null;
        }

        return null;
    }

    public function getNamedTag()
    {
        if (!$this->hasCompoundTag()) {
            return null;
        } elseif ($this->cachedNBT !== null) {
            return $this->cachedNBT;
        }
        return $this->cachedNBT = self::parseCompoundTag($this->tags);
    }

    public function setNamedTag(CompoundTag $tag)
    {
        if ($tag->getCount() === 0) {
            return $this->clearNamedTag();
        }

        $this->cachedNBT = $tag;
        $this->tags = self::writeCompoundTag($tag);

        return $this;
    }

    public function clearNamedTag()
    {
        return $this->setCompoundTag("");
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count)
    {
        $this->count = $count;
    }

    final public function getName(): string
    {
        return $this->hasCustomName() ? $this->getCustomName() : $this->name;
    }

    final public function canBePlaced(): bool
    {
        return $this->block !== null and $this->block->canBePlaced();
    }

    final public function isPlaceable(): bool
    {
        return $this->canBePlaced();
    }

    public function getBlock(): Block
    {
        if ($this->block instanceof Block) {
            return clone $this->block;
        } else {
            return Block::get(self::AIR);
        }
    }

    final public function getId(): int
    {
        return $this->id;
    }

    final public function getDamage()
    {
        return $this->meta;
    }

    public function setDamage($meta)
    {
        $this->meta = $meta !== null ? $meta & 0xFFFF : null;
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    final public function getFuelTime()
    {
        if (!isset(Fuel::$duration[$this->id])) {
            return null;
        }
        if ($this->id !== self::BUCKET or $this->meta === 10) {
            return Fuel::$duration[$this->id];
        }

        return null;
    }

    /**
     * @param Entity|Block $object
     *
     * @return bool
     */
    public function useOn($object)
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isTool()
    {
        return false;
    }

    /**
     * @return int|bool
     */
    public function getMaxDurability()
    {
        return false;
    }

    public function isPickaxe()
    {
        return false;
    }

    public function isAxe()
    {
        return false;
    }

    public function isSword()
    {
        return false;
    }

    public function isShovel()
    {
        return false;
    }

    public function isHoe()
    {
        return false;
    }

    public function isShears()
    {
        return false;
    }

    public function isArmor()
    {
        return false;
    }

    public function getArmorValue()
    {
        return false;
    }

    public function isBoots()
    {
        return false;
    }

    public function isHelmet()
    {
        return false;
    }

    public function isLegging()
    {
        return false;
    }

    public function isChestplate()
    {
        return false;
    }

    final public function __toString()
    { //Get error here..
        return "Item " . $this->name . " (" . $this->id . ":" . ($this->meta === null ? "?" : $this->meta) . ")x" . $this->count . ($this->hasCompoundTag() ? " tags:0x" . bin2hex($this->getCompoundTag()) : "");
    }

    public function getDestroySpeed(Block $block, Player $player)
    {
        return 1;
    }

    public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz)
    {
        return false;
    }

    public final function equals(Item $item, bool $checkDamage = true, bool $checkCompound = true, bool $checkCount = false): bool
    {
        return $this->id === $item->getId() and ($checkCount === false or $this->getCount() === $item->getCount()) and ($checkDamage === false or $this->getDamage() === $item->getDamage()) and ($checkCompound === false or $this->getCompoundTag() === $item->getCompoundTag());
    }

    public final function deepEquals(Item $item, bool $checkDamage = true, bool $checkCompound = true, bool $checkCount = false): bool
    {
        if ($this->equals($item, $checkDamage, $checkCompound, $checkCount)) {
            return true;
        } elseif ($item->hasCompoundTag() and $this->hasCompoundTag()) {
            return NBT::matchTree($this->getNamedTag(), $item->getNamedTag());
        }

        return false;
    }
}
