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

namespace pocketmine;

use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\block\Fire;
use pocketmine\block\PressurePlate;
use pocketmine\command\CommandSender;
use pocketmine\entity\Animal;
use pocketmine\entity\Arrow;
use pocketmine\entity\Attribute;
use pocketmine\entity\AttributeMap;
use pocketmine\entity\Boat;
use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\entity\FishingHook;
use pocketmine\entity\Human;
use pocketmine\entity\Item as DroppedItem;
use pocketmine\entity\Living;
use pocketmine\entity\Minecart;
use pocketmine\entity\Projectile;
use pocketmine\entity\ThrownExpBottle;
use pocketmine\entity\ThrownPotion;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\ItemFrameDropItemEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityEatItemEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\event\inventory\InventoryPickupArrowEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\player\PlayerAchievementAwardedEvent;
use pocketmine\event\player\PlayerAnimationEvent;
use pocketmine\event\player\PlayerBedEnterEvent;
use pocketmine\event\player\PlayerBedLeaveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExperienceChangeEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerHungerChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerTextPreSendEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\event\player\PlayerToggleSprintEvent;
use pocketmine\event\player\PlayerUseFishingRodEvent;
use pocketmine\event\player\PlayerTransferEvent;
use pocketmine\event\player\PlayerUpdatePingEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\event\TextContainer;
use pocketmine\event\Timings;
use pocketmine\event\TranslationContainer;
use pocketmine\inventory\BaseTransaction;
use pocketmine\inventory\BigShapedRecipe;
use pocketmine\inventory\BigShapelessRecipe;
use pocketmine\inventory\EnchantInventory;
use pocketmine\inventory\FurnaceInventory;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\inventory\PlayerInventory;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\inventory\ShapelessRecipe;
use pocketmine\inventory\SimpleTransactionGroup;
use pocketmine\item\FoodSource;
use pocketmine\item\Item;
use pocketmine\item\Potion;
use pocketmine\level\ChunkLoader;
use pocketmine\level\format\FullChunk;
use pocketmine\level\Level;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\level\sound\LaunchSound;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\metadata\MetadataValue;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\LongTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\Network;
use pocketmine\network\protocol\AdventureSettingsPacket;
use pocketmine\network\protocol\AnimatePacket;
use pocketmine\network\protocol\BatchPacket;
use pocketmine\network\protocol\ChangeDimensionPacket;
use pocketmine\network\protocol\ChunkRadiusUpdatePacket;
use pocketmine\network\protocol\ContainerClosePacket;
use pocketmine\network\protocol\ContainerSetContentPacket;
use pocketmine\network\protocol\DataPacket;
use pocketmine\network\protocol\DisconnectPacket;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\network\protocol\FullChunkDataPacket;
use pocketmine\network\protocol\Info as ProtocolInfo;
use pocketmine\network\protocol\InteractPacket;
use pocketmine\network\protocol\MovePlayerPacket;
use pocketmine\network\protocol\PlayerActionPacket;
use pocketmine\network\protocol\PlayStatusPacket;
use pocketmine\network\protocol\RespawnPacket;
use pocketmine\network\protocol\SetDifficultyPacket;
use pocketmine\network\protocol\SetEntityMotionPacket;
use pocketmine\network\protocol\SetHealthPacket;
use pocketmine\network\protocol\SetPlayerGameTypePacket;
use pocketmine\network\protocol\SetSpawnPositionPacket;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\network\protocol\StartGamePacket;
use pocketmine\network\protocol\TakeItemEntityPacket;
use pocketmine\network\protocol\TextPacket;
use pocketmine\network\protocol\UpdateAttributesPacket;
use pocketmine\network\protocol\UpdateBlockPacket;
use pocketmine\network\protocol\UseItemPacket;
use pocketmine\network\protocol\TransferPacket;
use pocketmine\network\SourceInterface;
use pocketmine\permission\PermissibleBase;
use pocketmine\permission\PermissionAttachment;
use pocketmine\plugin\Plugin;
use pocketmine\tile\ItemFrame;
use pocketmine\tile\Sign;
use pocketmine\tile\Spawnable;
use pocketmine\tile\Tile;
use pocketmine\utils\TextFormat;
use raklib\Binary;

/**
 * Main class that handles networking, recovery, and packet sending to the server part
 */
class Player extends Human implements CommandSender, InventoryHolder, ChunkLoader, IPlayer
{

    const SURVIVAL = 0;
    const CREATIVE = 1;
    const ADVENTURE = 2;
    const SPECTATOR = 3;
    const VIEW = Player::SPECTATOR;

    const SURVIVAL_SLOTS = 36;
    const CREATIVE_SLOTS = 112;

    /** @var SourceInterface */
    protected $interface;

    /** @var bool */
    public $playedBefore = false;
    public $spawned = false;
    public $loggedIn = false;
    public $gamemode;
    public $lastBreak;

    protected $windowCnt = 2;
    /** @var \SplObjectStorage<Inventory> */
    protected $windows;
    /** @var Inventory[] */
    protected $windowIndex = [];

    protected $messageCounter = 2;

    protected $sendIndex = 0;

    private $clientSecret;

    /** @var Vector3 */
    public $speed = null;

    public $blocked = false;
    public $achievements = [];
    public $lastCorrect;
    /** @var SimpleTransactionGroup */
    protected $currentTransaction = null;
    public $craftingType = 0; //0 = 2x2 crafting, 1 = 3x3 crafting, 2 = stonecutter

    protected $isCrafting = false;

    /**
     * @var array
     */
    public $loginData = [];

    public $creationTime = 0;

    protected $randomClientId;

    protected $protocol;

    protected $lastMovement = 0;
    /** @var Vector3 */
    protected $forceMovement = null;
    /** @var Vector3 */
    protected $teleportPosition = null;
    protected $connected = true;
    protected $ip;
    protected $removeFormat = false;
    protected $port;
    protected $username;
    protected $iusername;
    protected $displayName;
    protected $startAction = -1;
    /** @var Vector3 */
    protected $sleeping = null;
    protected $clientID = null;

    private $loaderId = null;

    protected $stepHeight = 0.6;

    public $usedChunks = [];
    protected $chunkLoadCount = 0;
    protected $loadQueue = [];
    protected $nextChunkOrderRun = 5;

    /** @var Player[] */
    protected $hiddenPlayers = [];

    /** @var Vector3 */
    protected $newPosition;

    protected $viewDistance;
    protected $chunksPerTick;
    protected $spawnThreshold;
    /** @var null|Position */
    protected $spawnPosition = null;

    protected $inAirTicks = 0;
    protected $startAirTicks = 5;

    protected $autoJump = true;

    protected $allowFlight = false;

    private $needACK = [];

    private $batchedPackets = [];

    /** @var PermissibleBase */
    private $perm = null;

    public $weatherData = [0, 0, 0];

    /** @var Vector3 */
    public $fromPos = null;
    private $portalTime = 0;
    protected $shouldSendStatus = false;
    /** @var  Position */
    private $shouldResPos;

    /** @var FishingHook */
    public $fishingHook = null;

    /** @var Position[] */
    public $selectedPos = [];
    /** @var Level[] */
    public $selectedLev = [];

    /** @var Item[] */
    protected $personalCreativeItems = [];

    /** @var int */
    protected $ping = 0;

    /** @var string */
    protected $locale = "en_US";

    /** @var string */
    protected $xuid = "";

    /**
     * @var array
     */
    private $lookup = [];

    /**
     * @return int
     */
    public function getPing(): int
    {
        return $this->ping;
    }

    /**
     * @param int $ping
     * @return void
     */
    public function setPing(int $ping)
    {
        $event = new PlayerUpdatePingEvent($this);
        $this->getServer()->getPluginManager()->callEvent($event);

        $this->ping = $ping;
    }

    /**
     * @return string
     *
     * Not done yet
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     *
     * Not done yet
     */
    public function getXuid(): string
    {
        return $this->xuid;
    }

    /**
     * @param string $address
     * @return mixed|string|null
     */
    private function lookupAddress(string $address)
    {
        // IP address
        if (preg_match("/^[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}$/", $address) > 0) {
            return $address;
        }

        $address = strtolower($address);

        if (isset($this->lookup[$address])) {
            return $this->lookup[$address];
        }

        $host = gethostbyname($address);
        if ($host === $address) {
            return null;
        }

        $this->lookup[$address] = $host;
        return $host;
    }

    /**
     * @param string $address
     * @param int $port
     * @param string $message
     * @return bool
     *
     * Doesn't work on 0.14.X (? or maybe...)
     */
    public function transfer(string $address, int $port = 19132, string $message = "Transferring..."): bool
    {
        $event = new PlayerTransferEvent($this, $address, $port, $message);
        $this->getServer()->getPluginManager()->callEvent($event);
        if ($event->isCancelled()) {
            return false;
        }

        $address = $this->lookupAddress($address);

        if ($address === null) {
            return false;
        }

        if ($message !== null && $message !== "") {
            $this->sendMessage($message);
        }

        $packet = new TransferPacket();

        $packet->address = $address;
        $packet->port = $port;

        $this->dataPacket($packet->setChannel(Network::CHANNEL_ENTITY_SPAWNING));
        return true;
    }

    /**
     * @return string
     *
     * Returns player's username in lowercase
     */
    public function getLowerCaseName(): string
    {
        return $this->iusername;
    }

    public function linkHookToPlayer(FishingHook $entity): bool
    {
        if ($entity->isAlive()) {
            $this->setFishingHook($entity);
            $pk = new EntityEventPacket();
            $pk->eid = $this->getFishingHook()->getId();
            $pk->event = EntityEventPacket::FISH_HOOK_POSITION;
            $this->server->broadcastPacket($this->level->getPlayers(), $pk);
            return true;
        }
        return false;
    }

    public function unlinkHookFromPlayer(): bool
    {
        if ($this->fishingHook instanceof FishingHook) {
            $pk = new EntityEventPacket();
            $pk->eid = $this->fishingHook->getId();
            $pk->event = EntityEventPacket::FISH_HOOK_TEASE;
            $this->server->broadcastPacket($this->level->getPlayers(), $pk);
            $this->setFishingHook();
            return true;
        }
        return false;
    }

    public function isFishing()
    {
        return ($this->fishingHook instanceof FishingHook);
    }

    public function getFishingHook()
    {
        return $this->fishingHook;
    }

    public function setFishingHook(FishingHook $entity = null)
    {
        if ($entity == null and $this->fishingHook instanceof FishingHook) {
            $this->fishingHook->close();
        }
        $this->fishingHook = $entity;
    }

    public function getItemInHand()
    {
        return $this->inventory->getItemInHand();
    }

    public function getLeaveMessage()
    {
        return new TranslationContainer(TextFormat::YELLOW . "%multiplayer.player.left", [
            $this->getName()
        ]);
    }

    protected $expLevel = 0;
    protected $exp = 0;

    public function setExperienceAndLevel(int $exp, int $level)
    {
        $this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, $exp, $level));
        if (!$ev->isCancelled()) {
            $this->expLevel = $level;
            $this->exp = $exp;
            $this->calcExpLevel();
            $this->updateExperience();
            return true;
        }
        return false;
    }

    public function setExp(int $exp)
    {
        $this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, $exp, 0));
        if ($ev->isCancelled()) {
            $this->exp = $ev->getExp();
            $this->calcExpLevel();
            $this->updateExperience();
            return true;
        }
        return false;
    }

    public function setExpLevel(int $level)
    {
        $this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, 0, $level));
        if (!$ev->isCancelled()) {
            $this->expLevel = $level;
            $this->exp = $this->server->getExpectedExperience($level);
            $this->updateExperience();
            return true;
        }
        return false;
    }

    public function getExpectedExperience()
    {
        return $this->server->getExpectedExperience($this->expLevel + 1);
    }

    public function getLevelUpExpectedExperience()
    {
        return $this->getExpectedExperience() - $this->server->getExpectedExperience($this->expLevel);
    }

    public function calcExpLevel()
    {
        while ($this->exp >= $this->getExpectedExperience()) {
            $this->expLevel++;
        }
        while ($this->exp < $this->server->getExpectedExperience($this->expLevel - 1)) {
            $this->expLevel--;
        }
    }

    public function addExperience(int $exp)
    {
        $this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, $exp, 0, PlayerExperienceChangeEvent::ADD_EXPERIENCE));
        if (!$ev->isCancelled()) {
            $this->exp = $this->exp + $ev->getExp();
            $this->calcExpLevel();
            $this->updateExperience();
            return true;
        }
        return false;
    }

    public function addExpLevel(int $level): bool
    {
        $this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, 0, $level, PlayerExperienceChangeEvent::ADD_EXPERIENCE));

        if (!$ev->isCancelled()) {
            $this->expLevel = $this->expLevel + $ev->getExpLevel();

            $this->calcExpLevel();
            $this->updateExperience();
            return true;
        }
        return false;
    }

    public function getExp()
    {
        return $this->exp;
    }

    public function getExpLevel()
    {
        return $this->expLevel;
    }

    public function updateExperience()
    {
        if ($this->getAttributeMap() instanceof AttributeMap) {
            $this->getAttributeMap()->getAttribute(Attribute::EXPERIENCE)->setValue(($this->exp - $this->server->getExpectedExperience($this->expLevel)) / ($this->getLevelUpExpectedExperience()));
            $this->getAttributeMap()->getAttribute(Attribute::EXPERIENCE_LEVEL)->setValue($this->expLevel);
        }
    }

    /**
     * This might disappear in the future.
     * Please use getUniqueId() instead (IP + clientId + name combo, in the future it'll change to real UUID for online
     * auth)
     */
    public function getClientId()
    {
        return $this->randomClientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function isBanned(): bool
    {
        return $this->server->getNameBans()->isBanned(strtolower($this->getName()));
    }

    public function setBanned($value)
    {
        if ($value === true) {
            $this->server->getNameBans()->addBan($this->getName(), null, null, null);
            $this->kick("You have been banned");
        } else {
            $this->server->getNameBans()->remove($this->getName());
        }
    }

    public function isWhitelisted(): bool
    {
        return $this->server->isWhitelisted(strtolower($this->getName()));
    }

    public function setWhitelisted($value)
    {
        if ($value === true) {
            $this->server->addWhitelist(strtolower($this->getName()));
        } else {
            $this->server->removeWhitelist(strtolower($this->getName()));
        }
    }

    public function getPlayer()
    {
        return $this;
    }

    public function getFirstPlayed()
    {
        return $this->namedtag instanceof CompoundTag ? $this->namedtag["firstPlayed"] : null;
    }

    public function getLastPlayed()
    {
        return $this->namedtag instanceof CompoundTag ? $this->namedtag["lastPlayed"] : null;
    }

    public function hasPlayedBefore()
    {
        return $this->playedBefore;
    }

    public function setAllowFlight($value)
    {
        $this->allowFlight = (bool)$value;
        $this->sendSettings();
    }

    public function getAllowFlight(): bool
    {
        return $this->allowFlight;
    }

    public function setAutoJump($value)
    {
        $this->autoJump = $value;
        $this->sendSettings();
    }

    public function hasAutoJump(): bool
    {
        return $this->autoJump;
    }

    /**
     * @param Player $player
     */
    public function spawnTo(Player $player)
    {
        if ($this->spawned and $player->spawned and $this->isAlive() and $player->isAlive() and $player->getLevel() === $this->level and $player->canSee($this) and !$this->isSpectator()) {
            parent::spawnTo($player);
        }
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return bool
     */
    public function getRemoveFormat()
    {
        return $this->removeFormat;
    }

    /**
     * @param bool $remove
     */
    public function setRemoveFormat($remove = true)
    {
        $this->removeFormat = (bool)$remove;
    }

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function canSee(Player $player): bool
    {
        return !isset($this->hiddenPlayers[$player->getRawUniqueId()]);
    }

    /**
     * @param Player $player
     */
    public function hidePlayer(Player $player)
    {
        if ($player === $this) {
            return;
        }
        $this->hiddenPlayers[$player->getRawUniqueId()] = $player;
        $player->despawnFrom($this);
    }

    /**
     * @param Player $player
     */
    public function showPlayer(Player $player)
    {
        if ($player === $this) {
            return;
        }
        unset($this->hiddenPlayers[$player->getRawUniqueId()]);
        if ($player->isOnline()) {
            $player->spawnTo($this);
        }
    }

    public function canCollideWith(Entity $entity): bool
    {
        return false;
    }

    public function resetFallDistance()
    {
        parent::resetFallDistance();
        if ($this->inAirTicks !== 0) {
            $this->startAirTicks = 5;
        }
        $this->inAirTicks = 0;
    }

    /**
     * @return bool
     */
    public function isOnline(): bool
    {
        return $this->connected === true and $this->loggedIn === true;
    }

    /**
     * @return bool
     */
    public function isOp(): bool
    {
        return $this->server->isOp($this->getName());
    }

    /**
     * @param bool $value
     */
    public function setOp($value)
    {
        if ($value === $this->isOp()) {
            return;
        }

        if ($value === true) {
            $this->server->addOp($this->getName());
        } else {
            $this->server->removeOp($this->getName());
        }

        $this->recalculatePermissions();
    }

    /**
     * @param permission\Permission|string $name
     *
     * @return bool
     */
    public function isPermissionSet($name)
    {
        return $this->perm->isPermissionSet($name);
    }

    /**
     * @param permission\Permission|string $name
     *
     * @return bool
     */
    public function hasPermission($name): bool
    {
        if ($this->perm == null) return false; else return $this->perm->hasPermission($name);
    }

    /**
     * @param Plugin $plugin
     * @param string $name
     * @param bool $value
     *
     * @return bool|PermissionAttachment
     */
    public function addAttachment(Plugin $plugin, $name = null, $value = null)
    {
        if ($this->perm == null) return false;
        return $this->perm->addAttachment($plugin, $name, $value);
    }


    /**
     * @param PermissionAttachment $attachment
     * @return bool
     */
    public function removeAttachment(PermissionAttachment $attachment)
    {
        if ($this->perm == null) {
            return false;
        }
        $this->perm->removeAttachment($attachment);
        return true;
    }

    public function recalculatePermissions()
    {
        $this->server->getPluginManager()->unsubscribeFromPermission(Server::BROADCAST_CHANNEL_USERS, $this);
        $this->server->getPluginManager()->unsubscribeFromPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE, $this);

        if ($this->perm === null) {
            return;
        }

        $this->perm->recalculatePermissions();

        if ($this->hasPermission(Server::BROADCAST_CHANNEL_USERS)) {
            $this->server->getPluginManager()->subscribeToPermission(Server::BROADCAST_CHANNEL_USERS, $this);
        }
        if ($this->hasPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE)) {
            $this->server->getPluginManager()->subscribeToPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE, $this);
        }
    }

    /**
     * @return permission\PermissionAttachmentInfo[]
     */
    public function getEffectivePermissions()
    {
        return $this->perm->getEffectivePermissions();
    }


    /**
     * @param SourceInterface $interface
     * @param null $clientID
     * @param string $ip
     * @param int $port
     */
    public function __construct(SourceInterface $interface, $clientID, $ip, $port)
    {
        $this->interface = $interface;
        $this->windows = new \SplObjectStorage();
        $this->perm = new PermissibleBase($this);
        $this->namedtag = new CompoundTag();
        $this->server = Server::getInstance();
        $this->lastBreak = PHP_INT_MAX;
        $this->ip = $ip;
        $this->port = $port;
        $this->clientID = $clientID;
        $this->loaderId = Level::generateChunkLoaderId($this);
        $this->chunksPerTick = (int)$this->server->getProperty("chunk-sending.per-tick", 4);
        $this->spawnThreshold = (int)$this->server->getProperty("chunk-sending.spawn-threshold", 56);
        $this->spawnPosition = null;
        $this->gamemode = $this->server->getGamemode();
        $this->setLevel($this->server->getDefaultLevel());
        $this->viewDistance = $this->server->getViewDistance();
        $this->newPosition = new Vector3(0, 0, 0);
        $this->boundingBox = new AxisAlignedBB(0, 0, 0, 0, 0, 0);

        $this->uuid = null;
        $this->rawUUID = null;

        $this->creationTime = microtime(true);

        $this->exp = 0;
        $this->expLevel = 0;
        $this->food = 20;
        Entity::setHealth(20);
    }

    /**
     * @param string $achievementId
     */
    public function removeAchievement($achievementId)
    {
        if ($this->hasAchievement($achievementId)) {
            $this->achievements[$achievementId] = false;
        }
    }

    /**
     * @param string $achievementId
     *
     * @return bool
     */
    public function hasAchievement($achievementId): bool
    {
        if (!isset(Achievement::$list[$achievementId]) or !isset($this->achievements)) {
            $this->achievements = [];

            return false;
        }

        return isset($this->achievements[$achievementId]) and $this->achievements[$achievementId] != false;
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->connected === true;
    }

    /**
     * Gets the "friendly" name to display of this player to use in the chat.
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $name
     */
    public function setDisplayName(string $name)
    {
        $this->displayName = $name;
        if ($this->spawned) {
            $this->server->updatePlayerListData($this->getUniqueId(), $this->getId(), $this->getDisplayName(), $this->getSkinName(), $this->getSkinData());
        }
    }

    public function setSkin($str, $skinName)
    {
        parent::setSkin($str, $skinName);
        if ($this->spawned) {
            $this->server->updatePlayerListData($this->getUniqueId(), $this->getId(), $this->getDisplayName(), $skinName, $str);
        }
    }

    /**
     * Gets the player IP address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    public function getNextPosition()
    {
        return $this->newPosition !== null ? new Position($this->newPosition->x, $this->newPosition->y, $this->newPosition->z, $this->level) : $this->getPosition();
    }

    /**
     * @return bool
     */
    public function isSleeping(): bool
    {
        return $this->sleeping !== null;
    }

    public function getInAirTicks(): int
    {
        return $this->inAirTicks;
    }

    protected function switchLevel(Level $targetLevel)
    {
        $oldLevel = $this->level;
        if (parent::switchLevel($targetLevel)) {
            foreach ($this->usedChunks as $index => $d) {
                Level::getXZ($index, $X, $Z);
                $this->unloadChunk($X, $Z, $oldLevel);
            }

            $this->usedChunks = [];
            $pk = new SetTimePacket();
            $pk->time = $this->level->getTime();
            $pk->started = $this->level->stopTime == false;
            $this->dataPacket($pk);

            $targetLevel->getWeather()->sendWeather($this);
            if ($targetLevel->getDimension() != $oldLevel->getDimension()) {
                $pk = new ChangeDimensionPacket();
                $pk->dimension = $targetLevel->getDimension();
                $this->dataPacket($pk);
                $this->shouldSendStatus = true;
            }

            if ($this->spawned) {
                $this->spawnToAll();
            }
        }
    }

    private function unloadChunk($x, $z, Level $level = null)
    {
        $level = $level === null ? $this->level : $level;
        $index = Level::chunkHash($x, $z);
        if (isset($this->usedChunks[$index])) {
            foreach ($level->getChunkEntities($x, $z) as $entity) {
                if ($entity !== $this) {
                    $entity->despawnFrom($this);
                }
            }

            unset($this->usedChunks[$index]);
        }
        $level->unregisterChunkLoader($this, $x, $z);
        unset($this->loadQueue[$index]);
    }

    /**
     * @return Position
     */
    public function getSpawn(): Position
    {
        if ($this->spawnPosition instanceof Position and $this->spawnPosition->getLevel() instanceof Level) {
            return $this->spawnPosition;
        } else {
            $level = $this->server->getDefaultLevel();

            return $level->getSafeSpawn();
        }
    }

    public function sendChunk($x, $z, $payload, $ordering = FullChunkDataPacket::ORDER_COLUMNS)
    {
        if ($this->connected === false) {
            return;
        }

        $this->usedChunks[Level::chunkHash($x, $z)] = true;
        $this->chunkLoadCount++;

        if ($payload instanceof DataPacket) {
            $this->dataPacket($payload);
        } else {
            $pk = new FullChunkDataPacket();
            $pk->chunkX = $x;
            $pk->chunkZ = $z;
            $pk->order = $ordering;
            $pk->data = $payload;
            $this->batchDataPacket($pk);
        }

        if ($this->spawned) {
            foreach ($this->level->getChunkEntities($x, $z) as $entity) {
                if ($entity !== $this and !$entity->closed and $entity->isAlive()) {
                    $entity->spawnTo($this);
                }
            }
        }
    }

    protected function sendNextChunk()
    {
        if ($this->connected === false) {
            return;
        }

        Timings::$playerChunkSendTimer->startTiming();

        $count = 0;
        foreach ($this->loadQueue as $index => $distance) {
            if ($count >= $this->chunksPerTick) {
                break;
            }

            $X = null;
            $Z = null;
            Level::getXZ($index, $X, $Z);

            ++$count;

            $this->usedChunks[$index] = false;
            $this->level->registerChunkLoader($this, $X, $Z, true);

            if (!$this->level->populateChunk($X, $Z)) {
                if ($this->spawned and $this->teleportPosition === null) {
                    continue;
                } else {
                    break;
                }
            }

            unset($this->loadQueue[$index]);
            $this->level->requestChunk($X, $Z, $this);
            if ((count($this->loadQueue) == 0) and $this->shouldSendStatus) {
                $this->shouldSendStatus = false;

                /*$pos = $this->shouldResPos;
				$pk = new RespawnPacket();
				$pk->x = $pos->x;
				$pk->y = $pos->y;
				$pk->z = $pos->z;
				$this->dataPacket($pk);*/

                $pk = new PlayStatusPacket();
                $pk->status = PlayStatusPacket::PLAYER_SPAWN;
                $this->dataPacket($pk);
            }
        }

        if ($this->chunkLoadCount >= $this->spawnThreshold and $this->spawned === false and $this->teleportPosition === null) {
            $this->doFirstSpawn();
        }

        Timings::$playerChunkSendTimer->stopTiming();
    }

    protected function doFirstSpawn()
    {
        $this->spawned = true;

        $this->sendSettings();
        $this->sendPotionEffects($this);
        $this->sendData($this);

        $pk = new SetTimePacket();
        $pk->time = $this->level->getTime();
        $pk->started = $this->level->stopTime == false;
        $this->dataPacket($pk);

        $pos = $this->level->getSafeSpawn($this);

        $this->server->getPluginManager()->callEvent($ev = new PlayerRespawnEvent($this, $pos));

        $pos = $ev->getRespawnPosition();
        if ($pos->getY() < 127) $pos = $pos->add(0, 0.2, 0);

        $pk = new RespawnPacket();
        $pk->x = $pos->x;
        $pk->y = $pos->y;
        $pk->z = $pos->z;
        $this->dataPacket($pk);

        $pk = new PlayStatusPacket();
        $pk->status = PlayStatusPacket::PLAYER_SPAWN;
        $this->dataPacket($pk);

        $this->noDamageTicks = 60;

        foreach ($this->usedChunks as $index => $c) {
            Level::getXZ($index, $chunkX, $chunkZ);
            foreach ($this->level->getChunkEntities($chunkX, $chunkZ) as $entity) {
                if ($entity !== $this and !$entity->closed and $entity->isAlive()) {
                    $entity->spawnTo($this);
                }
            }
        }

        $this->teleport($pos);

        $this->server->getPluginManager()->callEvent($ev = new PlayerJoinEvent($this, new TranslationContainer(TextFormat::YELLOW . "%multiplayer.player.joined", [
            $this->getName()
        ])));

        if (strlen(trim($msg = $ev->getJoinMessage())) > 0) {
            if ($this->server->playerMsgType === Server:: PLAYER_MSG_TYPE_MESSAGE) $this->server->broadcastMessage($msg);
            elseif ($this->server->playerMsgType === Server::PLAYER_MSG_TYPE_TIP) $this->server->broadcastTip(str_replace("@player", $this->getName(), $this->server->playerLoginMsg));
            elseif ($this->server->playerMsgType === Server::PLAYER_MSG_TYPE_POPUP) $this->server->broadcastPopup(str_replace("@player", $this->getName(), $this->server->playerLoginMsg));
        }

        $this->setAllowFlight($this->gamemode == 3 || $this->gamemode == 1);

        $this->server->onPlayerLogin($this);
        $this->spawnToAll();

        $this->level->getWeather()->sendWeather($this);
        if ($this->server->expEnabled) {
            //$this->checkExpLevel();
            $this->updateExperience();
        }
        $this->setHealth($this->getHealth());
        if ($this->server->foodEnabled) $this->setFood($this->getFood());
        else $this->setFood(20);

        if ($this->server->dserverConfig["enable"] and $this->server->dserverConfig["queryAutoUpdate"]) $this->server->updateQuery();

        /*if($this->server->getUpdater()->hasUpdate() and $this->hasPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE)){
			$this->server->getUpdater()->showPlayerUpdate($this);
		}*/

        if ($this->getHealth() <= 0) {
            $pk = new RespawnPacket();
            $pos = $this->getSpawn();
            $pk->x = $pos->x;
            $pk->y = $pos->y;
            $pk->z = $pos->z;
            $this->dataPacket($pk);
        }

        $this->inventory->sendContents($this);
        $this->inventory->sendArmorContents($this);
    }

    protected function orderChunks()
    {
        if ($this->connected === false) {
            return false;
        }

        Timings::$playerChunkOrderTimer->startTiming();

        $this->nextChunkOrderRun = 200;

        $viewDistance = $this->server->getMemoryManager()->getViewDistance($this->viewDistance);

        $newOrder = [];
        $lastChunk = $this->usedChunks;

        $centerX = $this->x >> 4;
        $centerZ = $this->z >> 4;

        $layer = 1;
        $leg = 0;
        $x = 0;
        $z = 0;

        for ($i = 0; $i < $viewDistance; ++$i) {

            $chunkX = $x + $centerX;
            $chunkZ = $z + $centerZ;

            if (!isset($this->usedChunks[$index = Level::chunkHash($chunkX, $chunkZ)]) or $this->usedChunks[$index] === false) {
                $newOrder[$index] = true;
            }
            unset($lastChunk[$index]);

            switch ($leg) {
                case 0:
                    ++$x;
                    if ($x === $layer) {
                        ++$leg;
                    }
                    break;
                case 1:
                    ++$z;
                    if ($z === $layer) {
                        ++$leg;
                    }
                    break;
                case 2:
                    --$x;
                    if (-$x === $layer) {
                        ++$leg;
                    }
                    break;
                case 3:
                    --$z;
                    if (-$z === $layer) {
                        $leg = 0;
                        ++$layer;
                    }
                    break;
            }
        }

        foreach ($lastChunk as $index => $bool) {
            Level::getXZ($index, $X, $Z);
            $this->unloadChunk($X, $Z);
        }

        $this->loadQueue = $newOrder;


        Timings::$playerChunkOrderTimer->stopTiming();

        return true;
    }

    /**
     * Batch a Data packet into the channel list to send at the end of the tick
     *
     * @param DataPacket $packet
     *
     * @return bool
     */
    public function batchDataPacket(DataPacket $packet)
    {
        if ($this->connected === false) {
            return false;
        }

        $timings = Timings::getSendDataPacketTimings($packet);
        $timings->startTiming();
        $this->server->getPluginManager()->callEvent($ev = new DataPacketSendEvent($this, $packet));
        if ($ev->isCancelled()) {
            $timings->stopTiming();
            return false;
        }

        if (!isset($this->batchedPackets)) {
            $this->batchedPackets = [];
        }

        $this->batchedPackets[] = clone $packet;
        $timings->stopTiming();
        return true;
    }

    /**
     * Sends an ordered DataPacket to the send buffer
     *
     * @param DataPacket $packet
     * @param bool $needACK
     *
     * @return int|bool
     */
    public function dataPacket(DataPacket $packet, $needACK = false)
    {
        if (!$this->connected) {
            return false;
        }

        $timings = Timings::getSendDataPacketTimings($packet);
        $timings->startTiming();

        $this->server->getPluginManager()->callEvent($ev = new DataPacketSendEvent($this, $packet));
        if ($ev->isCancelled()) {
            $timings->stopTiming();
            return false;
        }

        $identifier = $this->interface->putPacket($this, $packet, $needACK, false);

        if ($needACK and $identifier !== null) {
            $this->needACK[$identifier] = false;

            $timings->stopTiming();
            return $identifier;
        }

        $timings->stopTiming();
        return true;
    }

    /**
     * @param DataPacket $packet
     * @param bool $needACK
     *
     * @return bool|int
     */
    public function directDataPacket(DataPacket $packet, $needACK = false)
    {
        if ($this->connected === false) {
            return false;
        }

        $timings = Timings::getSendDataPacketTimings($packet);
        $timings->startTiming();
        $this->server->getPluginManager()->callEvent($ev = new DataPacketSendEvent($this, $packet));
        if ($ev->isCancelled()) {
            $timings->stopTiming();
            return false;
        }

        $identifier = $this->interface->putPacket($this, $packet, $needACK, true);

        if ($needACK and $identifier !== null) {
            $this->needACK[$identifier] = false;

            $timings->stopTiming();
            return $identifier;
        }

        $timings->stopTiming();
        return true;
    }

    /**
     * @param Vector3 $pos
     *
     * @return boolean
     */
    public function sleepOn(Vector3 $pos)
    {
        if (!$this->isOnline()) {
            return false;
        }

        foreach ($this->level->getNearbyEntities($this->boundingBox->grow(2, 1, 2), $this) as $p) {
            if ($p instanceof Player) {
                if ($p->sleeping !== null and $pos->distance($p->sleeping) <= 0.1) {
                    return false;
                }
            }
        }

        $this->server->getPluginManager()->callEvent($ev = new PlayerBedEnterEvent($this, $this->level->getBlock($pos)));
        if ($ev->isCancelled()) {
            return false;
        }

        $this->sleeping = clone $pos;
        $this->teleport(new Position($pos->x + 0.5, $pos->y - 1, $pos->z + 0.5, $this->level));

        $this->setDataProperty(self::DATA_PLAYER_BED_POSITION, self::DATA_TYPE_POS, [$pos->x, $pos->y, $pos->z]);
        $this->setDataFlag(self::DATA_PLAYER_FLAGS, self::DATA_PLAYER_FLAG_SLEEP, true);

        $this->setSpawn($pos);

        $this->level->sleepTicks = 60;


        return true;
    }

    /**
     * Sets the spawnpoint of the player (and the compass direction) to a Vector3, or set it on another world with a
     * Position object
     *
     * @param Vector3|Position $pos
     */
    public function setSpawn(Vector3 $pos)
    {
        if (!($pos instanceof Position)) {
            $level = $this->level;
        } else {
            $level = $pos->getLevel();
        }
        $this->spawnPosition = new Position($pos->x, $pos->y, $pos->z, $level);
        $pk = new SetSpawnPositionPacket();
        $pk->x = (int)$this->spawnPosition->x;
        $pk->y = (int)$this->spawnPosition->y;
        $pk->z = (int)$this->spawnPosition->z;
        $this->dataPacket($pk);
    }

    public function stopSleep()
    {
        if ($this->sleeping instanceof Vector3) {
            $this->server->getPluginManager()->callEvent($ev = new PlayerBedLeaveEvent($this, $this->level->getBlock($this->sleeping)));

            $this->sleeping = null;
            $this->setDataProperty(self::DATA_PLAYER_BED_POSITION, self::DATA_TYPE_POS, [0, 0, 0]);
            $this->setDataFlag(self::DATA_PLAYER_FLAGS, self::DATA_PLAYER_FLAG_SLEEP, false);


            $this->level->sleepTicks = 0;

            $pk = new AnimatePacket();
            $pk->eid = 0;
            $pk->action = 3; //Wake up
            $this->dataPacket($pk);
        }

    }

    /**
     * @param string $achievementId
     *
     * @return bool
     */
    public function awardAchievement($achievementId)
    {
        if (isset(Achievement::$list[$achievementId]) and !$this->hasAchievement($achievementId)) {
            foreach (Achievement::$list[$achievementId]["requires"] as $requerimentId) {
                if (!$this->hasAchievement($requerimentId)) {
                    return false;
                }
            }
            $this->server->getPluginManager()->callEvent($ev = new PlayerAchievementAwardedEvent($this, $achievementId));
            if (!$ev->isCancelled()) {
                $this->achievements[$achievementId] = true;
                Achievement::broadcast($this, $achievementId);

                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function getGamemode(): int
    {
        return $this->gamemode;
    }

    /**
     * Sets the gamemode, and if needed, kicks the Player.
     *
     * @param int $gm
     *
     * @return bool
     */
    public function setGamemode(int $gm)
    {
        if ($gm < 0 or $gm > 3 or $this->gamemode === $gm) {
            return false;
        }

        $this->server->getPluginManager()->callEvent($ev = new PlayerGameModeChangeEvent($this, $gm));
        if ($ev->isCancelled()) {
            return false;
        }

        if ($this->server->autoClearInv) $this->inventory->clearAll();

        $this->gamemode = $gm;

        $this->allowFlight = $this->isCreative();

        if ($this->isSpectator()) {
            $this->despawnFromAll();
        } else {
            $this->spawnToAll();
        }

        $this->namedtag->playerGameType = new IntTag("playerGameType", $this->gamemode);

        /*$spawnPosition = $this->getSpawn();

		$pk = new StartGamePacket();
		$pk->seed = -1;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->spawnX = (int)$spawnPosition->x;
		$pk->spawnY = (int)$spawnPosition->y;
		$pk->spawnZ = (int)$spawnPosition->z;
		$pk->generator = 1; //0 old, 1 infinite, 2 flat
		$pk->gamemode = $this->gamemode & 0x01;
		$pk->eid = 0;*/
        $pk = new SetPlayerGameTypePacket();
        $pk->gamemode = $this->gamemode & 0x01;
        $this->dataPacket($pk);
        $this->sendSettings();

        if ($this->gamemode === Player::SPECTATOR) {
            $pk = new ContainerSetContentPacket();
            $pk->windowid = ContainerSetContentPacket::SPECIAL_CREATIVE;
            $this->dataPacket($pk);
        } else {
            $pk = new ContainerSetContentPacket();
            $pk->windowid = ContainerSetContentPacket::SPECIAL_CREATIVE;
            $pk->slots = array_merge(Item::getCreativeItems(), $this->personalCreativeItems);
            $this->dataPacket($pk);
        }

        $this->inventory->sendContents($this);
        $this->inventory->sendContents($this->getViewers());
        $this->inventory->sendHeldItem($this->hasSpawned);
        return true;
    }

    /**
     * Sends all the option flags
     */
    public function sendSettings()
    {
        /*
		 bit mask | flag name
		0x00000001 world_inmutable
		0x00000002 no_pvp
		0x00000004 no_pvm
		0x00000008 no_mvp
		0x00000010 static_time
		0x00000020 nametags_visible
		0x00000040 auto_jump
		0x00000080 allow_fly
		0x00000100 noclip
		0x00000200 ?
		0x00000400 ?
		0x00000800 ?
		0x00001000 ?
		0x00002000 ?
		0x00004000 ?
		0x00008000 ?
		0x00010000 ?
		0x00020000 ?
		0x00040000 ?
		0x00080000 ?
		0x00100000 ?
		0x00200000 ?
		0x00400000 ?
		0x00800000 ?
		0x01000000 ?
		0x02000000 ?
		0x04000000 ?
		0x08000000 ?
		0x10000000 ?
		0x20000000 ?
		0x40000000 ?
		0x80000000 ?
		*/
        $flags = 0;
        if ($this->isAdventure()) {
            $flags |= 0x01; //Do not allow placing/breaking blocks, adventure mode
        }

        /*if($nametags !== false){
			$flags |= 0x20; //Show Nametags
		}*/

        if ($this->autoJump) {
            $flags |= 0x40;
        }

        if ($this->allowFlight) {
            $flags |= 0x80;
        }

        if ($this->isSpectator()) {
            $flags |= 0x100;
        }

        $pk = new AdventureSettingsPacket();
        $pk->flags = $flags;
        $pk->userPermission = 2;
        $pk->globalPermission = 2;
        $this->dataPacket($pk);
    }

    public function isSurvival(): bool
    {
        return ($this->gamemode & 0x01) === 0;
    }

    public function isCreative(): bool
    {
        return ($this->gamemode & 0x01) > 0;
    }

    public function isSpectator(): bool
    {
        return $this->gamemode === 3;
    }

    public function isAdventure(): bool
    {
        return ($this->gamemode & 0x02) > 0;
    }

    public function getDrops(): array
    {
        if (!$this->isCreative()) {
            return parent::getDrops();
        }

        return [];
    }

    /**
     * @param $entityId
     * @param $x
     * @param $y
     * @param $z
     * @deprecated
     */
    public function addEntityMotion($entityId, $x, $y, $z)
    {

    }

    /**
     * @param      $entityId
     * @param      $x
     * @param      $y
     * @param      $z
     * @param      $yaw
     * @param      $pitch
     * @param null $headYaw
     * @deprecated
     */
    public function addEntityMovement($entityId, $x, $y, $z, $yaw, $pitch, $headYaw = null)
    {

    }

    public function setDataProperty($id, $type, $value)
    {
        if (parent::setDataProperty($id, $type, $value)) {
            $this->sendData($this, [$id => $this->dataProperties[$id]]);
            return true;
        }

        return false;
    }

    protected function checkGroundState($movX, $movY, $movZ, $dx, $dy, $dz)
    {
        if (!$this->onGround or $movY != 0) {
            $bb = clone $this->boundingBox;
            $bb->maxY = $bb->minY + 0.5;
            $bb->minY -= 1;
            if (count($this->level->getCollisionBlocks($bb, true)) > 0) {
                $this->onGround = true;
            } else {
                $this->onGround = false;
            }
        }
        $this->isCollided = $this->onGround;
    }

    protected function checkBlockCollision()
    {
        foreach ($blocksaround = $this->getBlocksAround() as $block) {
            $block->onEntityCollide($this);
            if ($this->getServer()->redstoneEnabled) {
                if ($block instanceof PressurePlate) {
                    $this->activatedPressurePlates[Level::blockHash($block->x, $block->y, $block->z)] = $block;
                }
            }
        }

        if ($this->getServer()->redstoneEnabled) {
            /** @var \pocketmine\block\PressurePlate $block * */
            foreach ($this->activatedPressurePlates as $key => $block) {
                if (!isset($blocksaround[$key])) $block->checkActivation();
            }
        }
    }

    protected function checkNearEntities($tickDiff)
    {
        foreach ($this->level->getNearbyEntities($this->boundingBox->grow(0.5, 0.5, 0.5), $this) as $entity) {
            $entity->scheduleUpdate();

            if (!$entity->isAlive()) {
                continue;
            }

            if ($entity instanceof Arrow and $entity->hadCollision) {
                $item = Item::get(Item::ARROW, 0, 1);
                if ($this->isSurvival() and !$this->inventory->canAddItem($item)) {
                    continue;
                }

                $this->server->getPluginManager()->callEvent($ev = new InventoryPickupArrowEvent($this->inventory, $entity));
                if ($ev->isCancelled()) {
                    continue;
                }

                /*$pk = new TakeItemEntityPacket();
				$pk->eid = $this->getId();
				$pk->target = $entity->getId();
				Server::broadcastPacket($entity->getViewers(), $pk);

				$pk = new TakeItemEntityPacket();
				$pk->eid = 0;
				$pk->target = $entity->getId();
				$this->dataPacket($pk);*/
                //This may cause client crash

                if (!$this->isCreative()) $this->inventory->addItem(clone $item);
                $entity->kill();
            } elseif ($entity instanceof DroppedItem) {
                if ($entity->getPickupDelay() <= 0) {
                    $item = $entity->getItem();

                    if ($item instanceof Item) {
                        if ($this->isSurvival() and !$this->inventory->canAddItem($item)) {
                            continue;
                        }

                        $this->server->getPluginManager()->callEvent($ev = new InventoryPickupItemEvent($this->inventory, $entity));
                        if ($ev->isCancelled()) {
                            continue;
                        }

                        switch ($item->getId()) {
                            case Item::WOOD:
                                $this->awardAchievement("mineWood");
                                break;
                            case Item::DIAMOND:
                                $this->awardAchievement("diamond");
                                break;
                        }

                        $pk = new TakeItemEntityPacket();
                        $pk->eid = $this->getId();
                        $pk->target = $entity->getId();
                        Server::broadcastPacket($entity->getViewers(), $pk);

                        $pk = new TakeItemEntityPacket();
                        $pk->eid = 0;
                        $pk->target = $entity->getId();
                        $this->dataPacket($pk);

                        $this->inventory->addItem(clone $item);
                        $entity->kill();
                    }
                }
            }
        }
    }

    protected function processMovement($tickDiff)
    {
        if (!$this->isAlive() or !$this->spawned or $this->newPosition === null or $this->teleportPosition !== null) {
            $this->setMoving(false);
            return;
        }

        $newPos = $this->newPosition;
        $distanceSquared = $newPos->distanceSquared($this);

        $revert = false;

        if ($this->server->checkMovement) {
            if (($distanceSquared / ($tickDiff ** 2)) > 200) {
                $revert = true;
            } else {
                if ($this->chunk === null or !$this->chunk->isGenerated()) {
                    $chunk = $this->level->getChunk($newPos->x >> 4, $newPos->z >> 4, false);
                    if ($chunk === null or !$chunk->isGenerated()) {
                        $revert = true;
                        $this->nextChunkOrderRun = 0;
                    } else {
                        if ($this->chunk !== null) {
                            $this->chunk->removeEntity($this);
                        }
                        $this->chunk = $chunk;
                    }
                }
            }
        } else {
            if ($this->chunk === null or !$this->chunk->isGenerated()) {
                $chunk = $this->level->getChunk($newPos->x >> 4, $newPos->z >> 4, false);
                if ($chunk === null or !$chunk->isGenerated()) {
                    $revert = true;
                    $this->nextChunkOrderRun = 0;
                } else {
                    if ($this->chunk !== null) {
                        $this->chunk->removeEntity($this);
                    }
                    $this->chunk = $chunk;
                }
            }
        }

        if (!$revert and $distanceSquared != 0) {
            $dx = $newPos->x - $this->x;
            $dy = $newPos->y - $this->y;
            $dz = $newPos->z - $this->z;

            $this->move($dx, $dy, $dz);

            $diffX = $this->x - $newPos->x;
            $diffY = $this->y - $newPos->y;
            $diffZ = $this->z - $newPos->z;

            $yS = 0.5 + $this->ySize;
            if ($diffY >= -$yS or $diffY <= $yS) {
                $diffY = 0;
            }

            $diff = ($diffX ** 2 + $diffY ** 2 + $diffZ ** 2) / ($tickDiff ** 2);

            /*if($this->isSurvival()){
				if(!$revert and !$this->isSleeping()){
					if($diff > 0.0625){
						$revert = true;
						$this->server->getLogger()->warning($this->getServer()->getLanguage()->translateString("pocketmine.player.invalidMove", [$this->getName()]));
					}
				}
			}

			if($diff > 0){
				$this->x = $newPos->x;
				$this->y = $newPos->y;
				$this->z = $newPos->z;
				$radius = $this->width / 2;
				$this->boundingBox->setBounds($this->x - $radius, $this->y, $this->z - $radius, $this->x + $radius, $this->y + $this->height, $this->z + $radius);
			}*/
        }

        $from = new Location($this->lastX, $this->lastY, $this->lastZ, $this->lastYaw, $this->lastPitch, $this->level);
        $to = $this->getLocation();

        $delta = pow($this->lastX - $to->x, 2) + pow($this->lastY - $to->y, 2) + pow($this->lastZ - $to->z, 2);
        $deltaAngle = abs($this->lastYaw - $to->yaw) + abs($this->lastPitch - $to->pitch);

        if (!$revert and ($delta > (1 / 16) or $deltaAngle > 10)) {

            $isFirst = ($this->lastX === null or $this->lastY === null or $this->lastZ === null);

            $this->lastX = $to->x;
            $this->lastY = $to->y;
            $this->lastZ = $to->z;

            $this->lastYaw = $to->yaw;
            $this->lastPitch = $to->pitch;

            if (!$isFirst) {
                $ev = new PlayerMoveEvent($this, $from, $to);
                $this->setMoving(true);

                $this->server->getPluginManager()->callEvent($ev);

                if (!($revert = $ev->isCancelled())) { //Yes, this is intended
                    //$teleported = false;
                    if ($this->server->netherEnabled) {
                        if ($this->isInsideOfPortal()) {
                            if ($this->portalTime == 0) {
                                $this->portalTime = $this->server->getTick();
                            }
                        } else {
                            $this->portalTime = 0;
                        }
                    }

                    //if($this->server->redstoneEnabled) $this->getLevel()->updateAround($ev->getTo()->round());

                    //	if(!$teleported){
                    if ($to->distanceSquared($ev->getTo()) > 0.01) { //If plugins modify the destination
                        $this->teleport($ev->getTo());
                    } else {
                        $this->level->addEntityMovement($this->x >> 4, $this->z >> 4, $this->getId(), $this->x, $this->y + $this->getEyeHeight(), $this->z, $this->yaw, $this->pitch, $this->yaw);
                    }

                    if ($this->fishingHook instanceof FishingHook) {
                        if ($this->distance($this->fishingHook) > 33 or $this->inventory->getItemInHand()->getId() !== Item::FISHING_ROD) {
                            $this->setFishingHook();
                        }
                    }
                    //	}

                    /*if($this->server->expEnabled){
						/** @var \pocketmine\entity\ExperienceOrb $e *
						foreach($this->level->getNearbyExperienceOrb(new AxisAlignedBB($this->x - 1, $this->y - 1, $this->z - 1, $this->x + 1, $this->y + 2, $this->z + 1)) as $e){
							if($e->getExperience() > 0){
								$e->close();
								$this->addExperience($e->getExperience());
							}
						}
					}*/
                }
            }

            if (!$this->isSpectator()) {
                $this->checkNearEntities($tickDiff);
            }

            $this->speed = $from->subtract($to);
        } elseif ($distanceSquared == 0) {
            $this->speed = new Vector3(0, 0, 0);
            $this->setMoving(false);
        }

        if ($revert && !$this->isSpectator()) {

            $this->lastX = $from->x;
            $this->lastY = $from->y;
            $this->lastZ = $from->z;

            $this->lastYaw = $from->yaw;
            $this->lastPitch = $from->pitch;

            $this->sendPosition($from, $from->yaw, $from->pitch, 1);
            $this->forceMovement = new Vector3($from->x, $from->y, $from->z);
        } else {
            $this->forceMovement = null;
            if ($distanceSquared != 0 and $this->nextChunkOrderRun > 20) {
                $this->nextChunkOrderRun = 20;
            }
        }

        $this->newPosition = null;
    }

    public function setMotion(Vector3 $mot)
    {
        if (parent::setMotion($mot)) {
            if ($this->chunk !== null) {
                $this->level->addEntityMotion($this->chunk->getX(), $this->chunk->getZ(), $this->getId(), $this->motionX, $this->motionY, $this->motionZ);
                $pk = new SetEntityMotionPacket();
                $pk->entities[] = [0, $mot->x, $mot->y, $mot->z];
                $this->dataPacket($pk);
            }

            if ($this->motionY > 0) {
                $this->startAirTicks = (-(log($this->gravity / ($this->gravity + $this->drag * $this->motionY))) / $this->drag) * 2 + 5;
            }

            return true;
        }
        return false;
    }


    protected function updateMovement()
    {

    }

    public $foodTick = 0;

    public $starvationTick = 0;

    public $foodUsageTime = 0;

    protected $moving = false;

    public function setMoving($moving)
    {
        $this->moving = $moving;
    }

    public function isMoving(): bool
    {
        return $this->moving;
    }

    public function sendAttributes()
    {
        $entries = $this->attributeMap->needSend();
        if (count($entries) > 0) {
            $pk = new UpdateAttributesPacket();
            $pk->entityId = 0;
            $pk->entries = $entries;
            $this->dataPacket($pk);
            foreach ($entries as $entry) {
                $entry->markSynchronized();
            }
        }
    }

    public function onUpdate($currentTick)
    {
        if (!$this->loggedIn) {
            return false;
        }

        $tickDiff = $currentTick - $this->lastUpdate;

        if ($tickDiff <= 0) {
            return true;
        }

        $this->messageCounter = 2;

        $this->lastUpdate = $currentTick;

        $this->sendAttributes();

        if (!$this->isAlive() and $this->spawned) {
            ++$this->deadTicks;
            if ($this->deadTicks >= 10) {
                $this->despawnFromAll();
            }
            return true;
        }

        $this->timings->startTiming();

        if ($this->spawned) {
            if ($this->server->netherEnabled) {
                if (($this->isCreative() or $this->isSurvival() and $this->server->getTick() - $this->portalTime >= 30) and $this->portalTime > 0) {
                    if ($this->server->netherLevel instanceof Level) {
                        if ($this->getLevel() != $this->server->netherLevel) {
                            $this->fromPos = $this->getPosition();
                            $this->fromPos->x = ((int)$this->fromPos->x) + 0.5;
                            $this->fromPos->z = ((int)$this->fromPos->z) + 0.5;
                            $this->teleport($this->shouldResPos = $this->server->netherLevel->getSafeSpawn());
                        } elseif ($this->fromPos instanceof Position) {
                            if (!($this->getLevel()->isChunkLoaded($this->fromPos->x, $this->fromPos->z))) {
                                $this->getLevel()->loadChunk($this->fromPos->x, $this->fromPos->z);
                            }
                            $add = [1, 0, -1, 0, 0, 1, 0, -1];
                            $tempos = null;
                            for ($j = 2; $j < 5; $j++) {
                                for ($i = 0; $i < 4; $i++) {
                                    if ($this->fromPos->getLevel()->getBlock($this->temporalVector->fromObjectAdd($this->fromPos, $add[$i] * $j, 0, $add[$i + 4] * $j))->getId() === Block::AIR) {
                                        if ($this->fromPos->getLevel()->getBlock($this->temporalVector->fromObjectAdd($this->fromPos, $add[$i] * $j, 1, $add[$i + 4] * $j))->getId() === Block::AIR) {
                                            $tempos = $this->fromPos->add($add[$i] * $j, 0, $add[$i + 4] * $j);
                                            //$this->getLevel()->getServer()->getLogger()->debug($tempos);
                                            break;
                                        }
                                    }
                                }
                                if ($tempos != null) {
                                    break;
                                }
                            }
                            if ($tempos == null) {
                                $tempos = $this->fromPos->add(mt_rand(-2, 2), 0, mt_rand(-2, 2));
                            }
                            $this->teleport($this->shouldResPos = $tempos);
                            $add = null;
                            $tempos = null;
                            $this->fromPos = null;
                        } else {
                            $this->teleport($this->shouldResPos = $this->server->getDefaultLevel()->getSafeSpawn());
                        }
                        $this->portalTime = 0;
                    }
                }
            }
            $this->processMovement($tickDiff);

            if (!$this->isSpectator()) $this->entityBaseTick($tickDiff);

            if ($this->isOnFire() or $this->lastUpdate % 10 == 0) {
                if ($this->isCreative() and !$this->isInsideOfFire()) {
                    $this->extinguish();
                } elseif ($this->getLevel()->getWeather()->isRainy()) {
                    if ($this->getLevel()->canBlockSeeSky($this)) {
                        $this->extinguish();
                    }
                }
            }

            if ($this->server->antiFly) {
                if (!$this->isSpectator() and $this->speed !== null) {
                    if ($this->onGround) {
                        if ($this->inAirTicks !== 0) {
                            $this->startAirTicks = 5;
                        }
                        $this->inAirTicks = 0;
                    } else {
                        if (!$this->allowFlight and $this->inAirTicks > 10 and !$this->isSleeping() and $this->getDataProperty(self::DATA_NO_AI) !== 1) {
                            //expectedVelocity here is not calculated correctly
                            //This causes players to fall too fast when bouncing on slime when antiFly is enabled
                            $expectedVelocity = (-$this->gravity) / $this->drag - ((-$this->gravity) / $this->drag) * exp(-$this->drag * ($this->inAirTicks - $this->startAirTicks));
                            $diff = ($this->speed->y - $expectedVelocity) ** 2;
                            if (!$this->hasEffect(Effect::JUMP) and $diff > 0.6 and $expectedVelocity < $this->speed->y and !$this->server->getAllowFlight()) {
                                $this->setMotion($this->temporalVector->setComponents(0, $expectedVelocity, 0));
                                /*if($this->inAirTicks < 1000){

								}elseif($this->kick("§8[§cAC§8] §6Fly detected!")){
									$this->timings->stopTiming();
									return false;
								}*/
                            }
                        }
                        ++$this->inAirTicks;
                    }
                }
            }

            if ($this->server->foodEnabled) {
                if ($this->starvationTick >= 20) {
                    $ev = new EntityDamageEvent($this, EntityDamageEvent::CAUSE_STARVATION, 1);
                    if ($this->getHealth() > $this->server->hungerHealth) $this->attack(1, $ev);
                    $this->starvationTick = 0;
                }
                if ($this->getFood() <= 0) {
                    $this->starvationTick++;
                }

                if ($this->isMoving() && $this->isSurvival()) {
                    if ($this->isSprinting()) {
                        $this->foodUsageTime += 500;
                    } else {
                        $this->foodUsageTime += 250;
                    }
                }

                if ($this->foodUsageTime >= 200000 && $this->foodEnabled) {
                    $this->foodUsageTime -= 200000;
                    $this->subtractFood(1);
                }

                if ((($currentTick % 80) == 0) and $this->getHealth() < $this->getMaxHealth() && $this->getFood() >= 18 && $this->foodEnabled) {
                    $ev = new EntityRegainHealthEvent($this, 1, EntityRegainHealthEvent::CAUSE_EATING);
                    $this->heal(1, $ev);
                }

                if ($this->foodTick >= $this->server->hungerTimer) {
                    if ($this->foodEnabled) {
                        if ($this->foodDepletion >= 2) {
                            $this->subtractFood(1);
                            $this->foodDepletion = 0;
                        } else {
                            $this->foodDepletion++;
                        }
                    }
                    $this->foodTick = 0;
                }
                if ($this->getHealth() < $this->getMaxHealth()) {
                    $this->foodTick++;
                }
            }
        }

        $this->checkTeleportPosition();

        $this->timings->stopTiming();

        return true;
    }

    public $eatCoolDown = 0;

    public function eatFoodInHand()
    {
        if ($this->eatCoolDown + 2000 >= time() || !$this->spawned) {
            return;
        }

        $items = [ //TODO: move this to item classes
            Item::APPLE => 4,
            Item::MUSHROOM_STEW => 6,
            Item::RABBIT_STEW => 10,
            Item::BEETROOT_SOUP => 5,
            Item::BREAD => 5,
            Item::RAW_PORKCHOP => 2,
            Item::COOKED_PORKCHOP => 8,
            Item::RAW_BEEF => 3,
            Item::STEAK => 8,
            Item::COOKED_CHICKEN => 6,
            Item::RAW_CHICKEN => 2,
            Item::MELON_SLICE => 2,
            Item::GOLDEN_APPLE => 4,
            Item::PUMPKIN_PIE => 8,
            Item::CARROT => 3,
            Item::POTATO => 1,
            Item::BAKED_POTATO => 5,
            Item::COOKIE => 2,
            Item::COOKED_FISH => [
                0 => 5,
                1 => 6
            ],
            Item::RAW_FISH => [
                0 => 2,
                1 => 2,
                2 => 1,
                3 => 1
            ],
            Item::POTION => 0,
            Item::ROTTEN_FLESH => 4
        ];

        $slot = $this->inventory->getItemInHand();
        if (isset($items[$slot->getId()]) and $this->isAlive()) {
            if ($this->getFood() <= 20 and isset($items[$slot->getId()])) {
                $this->server->getPluginManager()->callEvent($ev = new PlayerItemConsumeEvent($this, $slot));
                if ($ev->isCancelled()) {
                    $this->inventory->sendContents($this);
                    return;
                }

                if ($slot instanceof FoodSource) {
                    $this->server->getPluginManager()->callEvent($ev = new EntityEatItemEvent($this, $slot));
                    if ($ev->isCancelled()) {
                        $this->inventory->sendContents($this);
                        return;
                    }
                }

                $pk = new EntityEventPacket();
                $pk->eid = $this->getId();
                $pk->event = EntityEventPacket::USE_ITEM;
                $this->dataPacket($pk);
                Server::broadcastPacket($this->getViewers(), $pk);

                $amount = $items[$slot->getId()];
                if (is_array($amount)) {
                    $amount = isset($amount[$slot->getDamage()]) ? $amount[$slot->getDamage()] : 0;
                }
                if ($this->getFood() + $amount >= 20) {
                    $this->setFood(20);
                } else {
                    $this->setFood($this->getFood() + $amount);
                }

                --$slot->count;
                $this->inventory->setItemInHand($slot);
                if ($slot->getId() === Item::MUSHROOM_STEW or $slot->getId() === Item::BEETROOT_SOUP) {
                    $this->inventory->addItem(Item::get(Item::BOWL, 0, 1));
                } elseif ($slot->getId() === Item::ROTTEN_FLESH) {
                    if (mt_rand(0, 100) < 80) {
                        $this->addEffect(Effect::getEffect(Effect::HUNGER)->setAmplifier(0)->setDuration(30 * 20));
                    }
                } elseif ($slot->getId() === Item::RAW_FISH and $slot->getDamage() === 3) { //Pufferfish
                    $this->addEffect(Effect::getEffect(Effect::HUNGER)->setAmplifier(2)->setDuration(15 * 20));
                    $this->addEffect(Effect::getEffect(Effect::NAUSEA)->setAmplifier(1)->setDuration(15 * 20));
                    $this->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(3)->setDuration(60 * 20));
                } elseif ($slot->getId() === Item::GOLDEN_APPLE && $slot->getDamage() === 1) {
                    $this->setFood($this->getFood() + 4);
                    $this->removeEffect(Effect::HEALTH_BOOST);
                    $this->removeEffect(Effect::REGENERATION);
                    $this->removeEffect(Effect::FIRE_RESISTANCE);
                    $this->removeEffect(Effect::DAMAGE_RESISTANCE);
                    $this->removeEffect(Effect::ABSORPTION);
                    $this->addEffect(Effect::getEffect(Effect::HEALTH_BOOST)->setAmplifier(0)->setDuration(2 * 60 * 20));
                    $this->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(4)->setDuration(30 * 20));
                    $this->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(5 * 60 * 20));
                    $this->addEffect(Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setAmplifier(0)->setDuration(5 * 60 * 20));
                    $this->addEffect(Effect::getEffect(Effect::ABSORPTION)->setDuration(2 * 60 * 20));
                } elseif ($slot->getId() === Item::GOLDEN_APPLE) {
                    $this->setFood($this->getFood() + 4);
                    $this->removeEffect(Effect::HEALTH_BOOST);
                    $this->removeEffect(Effect::REGENERATION);
                    $this->addEffect(Effect::getEffect(Effect::HEALTH_BOOST)->setAmplifier(0)->setDuration(2 * 60 * 20));
                    $this->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(5 * 20));
                } elseif ($slot->getId() == Item::POTION) {
                    $this->inventory->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
                    switch ($slot->getDamage()) {
                        case Potion::NIGHT_VISION:
                            $this->removeEffect(Effect::NIGHT_VISION);
                            $this->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::NIGHT_VISION_T:
                            $this->removeEffect(Effect::NIGHT_VISION);
                            $this->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::INVISIBILITY:
                            $this->removeEffect(Effect::INVISIBILITY);
                            $this->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::INVISIBILITY_T:
                            $this->removeEffect(Effect::INVISIBILITY);
                            $this->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::LEAPING:
                            $this->removeEffect(Effect::JUMP);
                            $this->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::LEAPING_T:
                            $this->removeEffect(Effect::JUMP);
                            $this->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::LEAPING_TWO:
                            $this->removeEffect(Effect::JUMP);
                            $this->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(1)->setDuration(1.5 * 60 * 20));
                            break;
                        case Potion::FIRE_RESISTANCE:
                            $this->removeEffect(Effect::FIRE_RESISTANCE);
                            $this->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::FIRE_RESISTANCE_T:
                            $this->removeEffect(Effect::FIRE_RESISTANCE);
                            $this->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::SPEED:
                            $this->removeEffect(Effect::SPEED);
                            $this->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::SPEED_T:
                            $this->removeEffect(Effect::SPEED);
                            $this->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::SPEED_TWO:
                            $this->removeEffect(Effect::SPEED);
                            $this->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(1)->setDuration(1.5 * 60 * 20));
                            break;
                        case Potion::SLOWNESS:
                            $this->removeEffect(Effect::SLOWNESS);
                            $this->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(0)->setDuration(1 * 60 * 20));
                            break;
                        case Potion::SLOWNESS_T:
                            $this->removeEffect(Effect::SLOWNESS);
                            $this->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(0)->setDuration(4 * 60 * 20));
                            break;
                        case Potion::WATER_BREATHING:
                            $this->removeEffect(Effect::WATER_BREATHING);
                            $this->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::WATER_BREATHING_T:
                            $this->removeEffect(Effect::WATER_BREATHING);
                            $this->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::POISON:
                            $this->removeEffect(Effect::POISON);
                            $this->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(45 * 20));
                            break;
                        case Potion::POISON_T:
                            $this->removeEffect(Effect::POISON);
                            $this->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(2 * 60 * 20));
                            break;
                        case Potion::POISON_TWO:
                            $this->removeEffect(Effect::POISON);
                            $this->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(22 * 20));
                            break;
                        case Potion::REGENERATION:
                            $this->removeEffect(Effect::REGENERATION);
                            $this->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(0)->setDuration(45 * 20));
                            break;
                        case Potion::REGENERATION_T:
                            $this->removeEffect(Effect::REGENERATION);
                            $this->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(0)->setDuration(2 * 60 * 20));
                            break;
                        case Potion::REGENERATION_TWO:
                            $this->removeEffect(Effect::REGENERATION);
                            $this->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(22 * 20));
                            break;
                        case Potion::STRENGTH:
                            $this->removeEffect(Effect::STRENGTH);
                            $this->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(0)->setDuration(3 * 60 * 20));
                            break;
                        case Potion::STRENGTH_T:
                            $this->removeEffect(Effect::STRENGTH);
                            $this->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(0)->setDuration(8 * 60 * 20));
                            break;
                        case Potion::STRENGTH_TWO:
                            $this->removeEffect(Effect::STRENGTH);
                            $this->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(1)->setDuration(1.5 * 60 * 20));
                            break;
                        case Potion::WEAKNESS:
                            $this->removeEffect(Effect::WEAKNESS);
                            $this->addEffect(Effect::getEffect(Effect::WEAKNESS)->setAmplifier(0)->setDuration(1.5 * 60 * 20));
                            break;
                        case Potion::WEAKNESS_T:
                            $this->removeEffect(Effect::WEAKNESS);
                            $this->addEffect(Effect::getEffect(Effect::WEAKNESS)->setAmplifier(0)->setDuration(4 * 60 * 20));
                            break;
                        case Potion::HEALING:
                            $this->addEffect(Effect::getEffect(Effect::HEALING)->setAmplifier(0)->setDuration(1));
                            break;
                        case Potion::HEALING_TWO:
                            $this->addEffect(Effect::getEffect(Effect::HEALING)->setAmplifier(1)->setDuration(1));
                            break;
                        case Potion::HARMING:
                            $this->addEffect(Effect::getEffect(Effect::HARMING)->setAmplifier(0)->setDuration(1));
                            break;
                        case Potion::HARMING_TWO:
                            $this->addEffect(Effect::getEffect(Effect::HARMING)->setAmplifier(1)->setDuration(1));
                            break;
                    }
                }
            }
        }
    }

    public function checkNetwork()
    {
        if (!$this->isOnline()) {
            return;
        }

        if ($this->nextChunkOrderRun-- <= 0 or $this->chunk === null) {
            $this->orderChunks();
        }

        if (count($this->loadQueue) > 0 or !$this->spawned) {
            $this->sendNextChunk();
        }

        if (count($this->batchedPackets) > 0) {
            $this->server->batchPackets([$this], $this->batchedPackets, false);
            $this->batchedPackets = [];
        }

    }

    public function canInteract(Vector3 $pos, $maxDistance, $maxDiff = 0.5)
    {
        if ($this->distanceSquared($pos) > $maxDistance ** 2) {
            return false;
        }

        $dV = $this->getDirectionPlane();
        $dot = $dV->dot(new Vector2($this->x, $this->z));
        $dot1 = $dV->dot(new Vector2($pos->x, $pos->z));
        return ($dot1 - $dot) >= -$maxDiff;
    }

    public function onPlayerPreLogin()
    {
        //TODO: implement auth
        $this->tryAuthenticate();
    }

    public function tryAuthenticate()
    {
        //TODO: implement authentication after it is available
        $this->authenticateCallback(true);
    }

    public function authenticateCallback($valid)
    {

        //TODO add more stuff after authentication is available
        if (!$valid) {
            $this->close("", "disconnectionScreen.invalidSession");
            return;
        }

        $this->processLogin();
    }

    public function clearCreativeItems()
    {
        $this->personalCreativeItems = [];
    }

    public function getCreativeItems(): array
    {
        return $this->personalCreativeItems;
    }

    public function addCreativeItem(Item $item)
    {
        $this->personalCreativeItems[] = Item::get($item->getId(), $item->getDamage());
    }

    public function removeCreativeItem(Item $item)
    {
        $index = $this->getCreativeItemIndex($item);
        if ($index !== -1) {
            unset($this->personalCreativeItems[$index]);
        }
    }

    public function getCreativeItemIndex(Item $item): int
    {
        foreach ($this->personalCreativeItems as $i => $d) {
            if ($item->equals($d, !$item->isTool())) {
                return $i;
            }
        }

        return -1;
    }

    protected function processLogin()
    {
        if (!$this->server->isWhitelisted(strtolower($this->getName()))) {
            $this->close($this->getLeaveMessage(), "§fServer is under §etechnical §fworks");

            return;
        } elseif ($this->server->getNameBans()->isBanned(strtolower($this->getName())) or $this->server->getIPBans()->isBanned($this->getAddress()) or $this->server->getCIDBans()->isBanned($this->randomClientId)) {
            $this->close($this->getLeaveMessage(), "§fYou §ewere §fpermanently §cbanned");

            return;
        }

        if ($this->hasPermission(Server::BROADCAST_CHANNEL_USERS)) {
            $this->server->getPluginManager()->subscribeToPermission(Server::BROADCAST_CHANNEL_USERS, $this);
        }
        if ($this->hasPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE)) {
            $this->server->getPluginManager()->subscribeToPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE, $this);
        }

        foreach ($this->server->getOnlinePlayers() as $p) {
            if ($p !== $this and strtolower($p->getName()) === strtolower($this->getName())) {
                if ($p->kick("logged in from another location") === false) {
                    $this->close($this->getLeaveMessage(), "Logged in from another location");
                    return;
                }
            } elseif ($p->loggedIn and $this->getUniqueId()->equals($p->getUniqueId())) {
                if ($p->kick("logged in from another location") === false) {
                    $this->close($this->getLeaveMessage(), "Logged in from another location");
                    return;
                }
            }
        }

        $nbt = $this->server->getOfflinePlayerData($this->username);
        $this->playedBefore = ($nbt["lastPlayed"] - $nbt["firstPlayed"]) > 1;
        if (!isset($nbt->NameTag)) {
            $nbt->NameTag = new StringTag("NameTag", $this->username);
        } else {
            $nbt["NameTag"] = $this->username;
        }
        if (!isset($nbt->Hunger) or !isset($nbt->Experience) or !isset($nbt->ExpLevel) or !isset($nbt->Health) or !isset($nbt->MaxHealth)) {
            $nbt->Hunger = new ShortTag("Hunger", 20);
            $nbt->Experience = new LongTag("Experience", 0);
            $nbt->ExpLevel = new LongTag("ExpLevel", 0);
            $nbt->Health = new ShortTag("Health", 20);
            $nbt->MaxHealth = new ShortTag("MaxHealth", 20);
        }
        $this->food = $nbt["Hunger"];
        $this->setMaxHealth($nbt["MaxHealth"]);
        Entity::setHealth(($nbt["Health"] <= 0) ? 20 : $nbt["Health"]);
        $this->exp = ($nbt["Experience"] > 0) ? $nbt["Experience"] : 0;
        $this->expLevel = ($nbt["ExpLevel"] >= 0) ? $nbt["ExpLevel"] : 0;
        $this->calcExpLevel();
        $this->gamemode = $nbt["playerGameType"] & 0x03;
        if ($this->server->getForceGamemode()) {
            $this->gamemode = $this->server->getGamemode();
            $nbt->playerGameType = new IntTag("playerGameType", $this->gamemode);
        }

        $this->allowFlight = $this->isCreative();


        if (($level = $this->server->getLevelByName($nbt["Level"])) === null) {
            $this->setLevel($this->server->getDefaultLevel());
            $nbt["Level"] = $this->level->getName();
            $nbt["Pos"][0] = $this->level->getSpawnLocation()->x;
            $nbt["Pos"][1] = $this->level->getSpawnLocation()->y;
            $nbt["Pos"][2] = $this->level->getSpawnLocation()->z;
        } else {
            $this->setLevel($level);
        }

        if (!($nbt instanceof CompoundTag)) {
            $this->close($this->getLeaveMessage(), "Invalid data");

            return;
        }

        $this->achievements = [];

        /** @var ByteTag $achievement */
        foreach ($nbt->Achievements as $achievement) {
            $this->achievements[$achievement->getName()] = $achievement->getValue() > 0 ? true : false;
        }

        $nbt->lastPlayed = new LongTag("lastPlayed", floor(microtime(true) * 1000));
        if ($this->server->getAutoSave()) {
            $this->server->saveOfflinePlayerData($this->username, $nbt, true);
        }

        parent::__construct($this->level->getChunk($nbt["Pos"][0] >> 4, $nbt["Pos"][2] >> 4, true), $nbt);
        $this->loggedIn = true;
        $this->server->addOnlinePlayer($this);

        $this->server->getPluginManager()->callEvent($ev = new PlayerLoginEvent($this, "Plugin reason"));
        if ($ev->isCancelled()) {
            $this->close($this->getLeaveMessage(), $ev->getKickMessage());

            return;
        }

        if ($this->isCreative()) {
            $this->inventory->setHeldItemSlot(0);
        } else {
            $this->inventory->setHeldItemSlot($this->inventory->getHotbarSlotIndex(0));
        }

        $pk = new PlayStatusPacket();
        $pk->status = PlayStatusPacket::LOGIN_SUCCESS;
        $this->dataPacket($pk);
        if ($this->spawnPosition === null and isset($this->namedtag->SpawnLevel) and ($level = $this->server->getLevelByName($this->namedtag["SpawnLevel"])) instanceof Level) {
            $this->spawnPosition = new Position($this->namedtag["SpawnX"], $this->namedtag["SpawnY"], $this->namedtag["SpawnZ"], $level);
        }
        $spawnPosition = $this->getSpawn();

        $pk = new StartGamePacket();
        $pk->seed = -1;
        $pk->dimension = $this->level->getDimension();
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->spawnX = (int)$spawnPosition->x;
        $pk->spawnY = (int)$spawnPosition->y;
        $pk->spawnZ = (int)$spawnPosition->z;
        $pk->generator = 1; //0 old, 1 infinite, 2 flat
        $pk->gamemode = $this->gamemode & 0x01;
        $pk->eid = 0; //Always use EntityID as zero for the actual player
        /*$pk = new SetPlayerGameTypePacket();
		$pk->gamemode = $this->gamemode & 0x01;*/
        $this->dataPacket($pk);

        $pk = new SetTimePacket();
        $pk->time = $this->level->getTime();
        $pk->started = $this->level->stopTime == false;
        $this->dataPacket($pk);

        $pk = new SetSpawnPositionPacket();
        $pk->x = (int)$spawnPosition->x;
        $pk->y = (int)$spawnPosition->y;
        $pk->z = (int)$spawnPosition->z;
        $this->dataPacket($pk);

        $pk = new SetHealthPacket();
        $pk->health = $this->getHealth();
        $this->dataPacket($pk);

        $pk = new SetDifficultyPacket();
        $pk->difficulty = $this->server->getDifficulty();
        $this->dataPacket($pk);
        $this->server->getLogger()->info($this->getServer()->getLanguage()->translateString("pocketmine.player.logIn", [
            TextFormat::AQUA . $this->username . TextFormat::WHITE,
            $this->ip,
            $this->port,
            TextFormat::GREEN . $this->randomClientId . TextFormat::WHITE,
            $this->id,
            $this->level->getName(),
            round($this->x, 4),
            round($this->y, 4),
            round($this->z, 4)
        ]));
        /*if($this->isOp()){
			$this->setRemoveFormat(false);
		}*/
        if ($this->gamemode === Player::SPECTATOR) {
            $pk = new ContainerSetContentPacket();
            $pk->windowid = ContainerSetContentPacket::SPECIAL_CREATIVE;
            $this->dataPacket($pk);
        } else {
            $pk = new ContainerSetContentPacket();
            $pk->windowid = ContainerSetContentPacket::SPECIAL_CREATIVE;
            $pk->slots = array_merge(Item::getCreativeItems(), $this->personalCreativeItems);
            $this->dataPacket($pk);
        }
        $this->forceMovement = $this->teleportPosition = $this->getPosition();
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Handles a Minecraft packet
     * TODO: Separate all of this in handlers
     *
     * WARNING: Do not use this, it's only for internal use.
     * Changes to this function won't be recorded on the version.
     *
     * @param DataPacket $packet
     */
    public function handleDataPacket(DataPacket $packet)
    {
        if ($this->connected === false) {
            return;
        }

        if ($packet::NETWORK_ID === ProtocolInfo::BATCH_PACKET) {
            /** @var BatchPacket $packet */
            $this->server->getNetwork()->processBatch($packet, $this);
            return;
        }

        $timings = Timings::getReceiveDataPacketTimings($packet);

        $timings->startTiming();

        $this->server->getPluginManager()->callEvent($ev = new DataPacketReceiveEvent($this, $packet));
        if ($ev->isCancelled()) {
            $timings->stopTiming();
            return;
        }

        switch ($packet::NETWORK_ID) {
            case ProtocolInfo::ITEM_FRAME_DROP_ITEM_PACKET:
                $tile = $this->level->getTile($this->temporalVector->setComponents($packet->x, $packet->y, $packet->z));
                if ($tile instanceof ItemFrame) {
                    $block = $this->level->getBlock($tile);
                    $this->server->getPluginManager()->callEvent($ev = new BlockBreakEvent($this, $block, $this->getInventory()->getItemInHand(), true));
                    if (!$ev->isCancelled()) {
                        $item = $tile->getItem();
                        $this->server->getPluginManager()->callEvent($ev = new ItemFrameDropItemEvent($this, $block, $tile, $item));
                        if (!$ev->isCancelled()) {
                            if ($item->getId() !== Item::AIR) {
                                if ((mt_rand(0, 10) / 10) < $tile->getItemDropChance()) {
                                    $this->level->dropItem($tile, $item);
                                }
                                $tile->setItem(Item::get(Item::AIR));
                                $tile->setItemRotation(0);
                            }
                        } else $tile->spawnTo($this);
                    } else $tile->spawnTo($this);
                }
                break;
            case ProtocolInfo::REQUEST_CHUNK_RADIUS_PACKET:
                /*if($this->spawned){
					$this->viewDistance = $packet->radius ** 2;
				}*/
                $pk = new ChunkRadiusUpdatePacket();
                $pk->radius = ($this->server->chunkRadius != -1) ? $this->server->chunkRadius : $packet->radius;
                $this->dataPacket($pk);
                break;
            case ProtocolInfo::PLAYER_INPUT_PACKET:
                break;
            case ProtocolInfo::LOGIN_PACKET:
                if ($this->loggedIn) {
                    break;
                }

                $this->username = TextFormat::clean($packet->username);
                $this->displayName = $this->username;
                $this->setNameTag($this->username);
                $this->iusername = strtolower($this->username);
                $this->protocol = $packet->protocol1;

                if (count($this->server->getOnlinePlayers()) >= $this->server->getMaxPlayers() and $this->kick("Server is full!", false)) {
                    break;
                }

                if (!in_array($packet->protocol1, ProtocolInfo::ACCEPTED_PROTOCOLS)) {
                    if ($packet->protocol1 < ProtocolInfo::CURRENT_PROTOCOL) {
                        $message = "Outdated client! (" . $packet->protocol1 . ")";

                        $pk = new PlayStatusPacket();
                        $pk->status = PlayStatusPacket::LOGIN_FAILED_CLIENT;
                        $this->directDataPacket($pk);
                    } else {
                        $message = "Outdated server! (" . $packet->protocol1 . ")";

                        $pk = new PlayStatusPacket();
                        $pk->status = PlayStatusPacket::LOGIN_FAILED_SERVER;
                        $this->directDataPacket($pk);
                    }
                    $this->close("", $message, false);

                    break;
                }

                $this->randomClientId = $packet->clientId;
                $this->loginData = ["clientId" => $packet->clientId, "loginData" => null];

                $this->uuid = $packet->clientUUID;
                $this->rawUUID = $this->uuid->toBinary();
                $this->clientSecret = $packet->clientSecret;

                $valid = true;
                $len = strlen($packet->username);
                if ($len > 16 or $len < 3) {
                    $valid = false;
                }
                for ($i = 0; $i < $len and $valid; ++$i) {
                    $c = ord($packet->username[$i]);
                    if (($c >= ord("a") and $c <= ord("z")) or ($c >= ord("A") and $c <= ord("Z")) or ($c >= ord("0") and $c <= ord("9")) or $c === ord("_")) {
                        continue;
                    }

                    $valid = false;
                    break;
                }

                if (!$valid or $this->iusername === "rcon" or $this->iusername === "console") {
                    $this->close("", "Invalid nickname!");

                    break;
                }

                if ((strlen($packet->skin) != 64 * 64 * 4) and (strlen($packet->skin) != 64 * 32 * 4)) {
                    $this->close("", "Invalid skin format!");

                    break;
                }

                $this->setSkin($packet->skin, $packet->skinName);

                $this->server->getPluginManager()->callEvent($ev = new PlayerPreLoginEvent($this, "Plugin reason"));
                if ($ev->isCancelled()) {
                    $this->close("", $ev->getKickMessage());

                    break;
                }

                $this->onPlayerPreLogin();

                break;
            case ProtocolInfo::MOVE_PLAYER_PACKET:
                if ($this->linkedEntity instanceof Entity) {
                    $entity = $this->linkedEntity;
                    if ($entity instanceof Boat) {
                        $entity->setPosition($this->temporalVector->setComponents($packet->x, $packet->y - 0.3, $packet->z));
                    }
                    /*if ($entity instanceof Minecart) {
						$entity->isFreeMoving = true;
						$entity->motionX = -sin($packet->yaw / 180 * M_PI);
						$entity->motionZ = cos($packet->yaw / 180 * M_PI);
					}*/
                }

                $newPos = new Vector3($packet->x, $packet->y - $this->getEyeHeight(), $packet->z);

                $revert = false;
                if (!$this->isAlive() or $this->spawned !== true) {
                    $revert = true;
                    $this->forceMovement = new Vector3($this->x, $this->y, $this->z);
                }

                if ($this->teleportPosition !== null or ($this->forceMovement instanceof Vector3 and (($dist = $newPos->distanceSquared($this->forceMovement)) > 0.1 or $revert))) {
                    if ($this->forceMovement instanceof Vector3) $this->sendPosition($this->forceMovement, $packet->yaw, $packet->pitch);
                } else {
                    $packet->yaw %= 360;
                    $packet->pitch %= 360;

                    if ($packet->yaw < 0) {
                        $packet->yaw += 360;
                    }

                    $this->setRotation($packet->yaw, $packet->pitch);
                    $this->newPosition = $newPos;
                    $this->forceMovement = null;
                }

                break;
            case ProtocolInfo::MOB_EQUIPMENT_PACKET:
                if ($this->spawned === false or !$this->isAlive()) {
                    break;
                }

                if ($packet->slot === 0x28 or $packet->slot === 0 or $packet->slot === 255) { //0 for 0.8.0 compatibility
                    $packet->slot = -1; //Air
                } else {
                    $packet->slot -= 9; //Get real block slot
                }

                /** @var Item $item */
                $item = null;

                if ($this->isCreative()) { //Creative mode match
                    $item = $packet->item;
                    $slot = Item::getCreativeItemIndex($item);
                } else {
                    $item = $this->inventory->getItem($packet->slot);
                    $slot = $packet->slot;
                }

                if ($packet->slot === -1) { //Air
                    if ($this->isCreative()) {
                        $found = false;
                        for ($i = 0; $i < $this->inventory->getHotbarSize(); ++$i) {
                            if ($this->inventory->getHotbarSlotIndex($i) === -1) {
                                $this->inventory->setHeldItemIndex($i);
                                $this->inventory->sendHeldItem($this->getViewers());
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) { //couldn't find a empty slot (error)
                            $this->inventory->sendContents($this);
                            break;
                        }
                    } else {
                        if ($packet->selectedSlot >= 0 and $packet->selectedSlot < 9) {
                            $this->inventory->setHeldItemIndex($packet->selectedSlot);
                            $this->inventory->setHeldItemSlot($packet->slot);
                        } else {
                            $this->inventory->sendContents($this);
                            break;
                        }
                    }
                } elseif ($item === null or $slot === -1 or !$item->deepEquals($packet->item)) { // packet error or not implemented
                    $this->inventory->sendContents($this);
                    break;
                } elseif ($this->isCreative()) {
                    $this->inventory->setHeldItemIndex($packet->selectedSlot);
                    $this->inventory->setItem($packet->selectedSlot, $item);
                    $this->inventory->setHeldItemSlot($packet->selectedSlot);
                } else {
                    if ($packet->selectedSlot >= 0 and $packet->selectedSlot < $this->inventory->getHotbarSize()) {
                        $this->inventory->setHeldItemIndex($packet->selectedSlot);
                        $this->inventory->setHeldItemSlot($slot);
                    } else {
                        $this->inventory->sendContents($this);
                        break;
                    }
                }

                $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION, false);
                break;
            case ProtocolInfo::USE_ITEM_PACKET:
                /** @var UseItemPacket $pk */
                $packet->decodeAdditional($this->protocol);
                if ($this->spawned === false or !$this->isAlive() or $this->blocked) {
                    break;
                }

                $blockVector = new Vector3($packet->x, $packet->y, $packet->z);

                $this->craftingType = 0;

                if ($packet->face >= 0 and $packet->face <= 5) { //Use Block, place
                    $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION, false);

                    if (!$this->canInteract($blockVector->add(0.5, 0.5, 0.5), 13) or $this->isSpectator()) {

                    } elseif ($this->isCreative()) {
                        $item = $this->inventory->getItemInHand();
                        if ($this->level->useItemOn($blockVector, $item, $packet->face, $packet->fx, $packet->fy, $packet->fz, $this) === true) {
                            break;
                        }
                    } elseif (!$this->inventory->getItemInHand()->deepEquals($packet->item)) {
                        $this->inventory->sendHeldItem($this);
                    } else {
                        $item = $this->inventory->getItemInHand();
                        $oldItem = clone $item;
                        if ($this->level->useItemOn($blockVector, $item, $packet->face, $packet->fx, $packet->fy, $packet->fz, $this)) {
                            if (!$item->deepEquals($oldItem) or $item->getCount() !== $oldItem->getCount()) {
                                $this->inventory->setItemInHand($item);
                                $this->inventory->sendHeldItem($this->hasSpawned);
                            }
                            break;
                        }
                    }

                    $this->inventory->sendHeldItem($this);

                    if ($blockVector->distanceSquared($this) > 10000) {
                        break;
                    }
                    $target = $this->level->getBlock($blockVector);
                    $block = $target->getSide($packet->face);

                    $this->level->sendBlocks([$this], [$target, $block], UpdateBlockPacket::FLAG_ALL_PRIORITY);
                    break;
                } elseif ($packet->face === 0xff) {
                    if ($this->isSpectator()) break;

                    $aimPos = (new Vector3($packet->x / 32768, $packet->y / 32768, $packet->z / 32768))->normalize();

                    if ($this->isCreative()) {
                        $item = $this->inventory->getItemInHand();
                    } elseif (!$this->inventory->getItemInHand()->deepEquals($packet->item)) {
                        $this->inventory->sendHeldItem($this);
                        break;
                    } else {
                        $item = $this->inventory->getItemInHand();
                    }

                    $ev = new PlayerInteractEvent($this, $item, $aimPos, $packet->face, PlayerInteractEvent::RIGHT_CLICK_AIR);

                    $this->server->getPluginManager()->callEvent($ev);

                    if ($ev->isCancelled()) {
                        $this->inventory->sendHeldItem($this);
                        break;
                    }

                    if ($item->getId() === Item::FISHING_ROD) {
                        if ($this->isFishing()) {
                            $this->server->getPluginManager()->callEvent($ev = new PlayerUseFishingRodEvent($this, PlayerUseFishingRodEvent::ACTION_STOP_FISHING));
                        } else {
                            $this->server->getPluginManager()->callEvent($ev = new PlayerUseFishingRodEvent($this, PlayerUseFishingRodEvent::ACTION_START_FISHING));
                        }
                        if (!$ev->isCancelled()) {
                            if ($this->isFishing()) {
                                $this->setFishingHook();
                            } else {
                                $nbt = new CompoundTag("", [
                                    "Pos" => new ListTag("Pos", [
                                        new DoubleTag("", $this->x),
                                        new DoubleTag("", $this->y + $this->getEyeHeight()),
                                        new DoubleTag("", $this->z)
                                    ]),
                                    "Motion" => new ListTag("Motion", [
                                        new DoubleTag("", -sin($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI)),
                                        new DoubleTag("", -sin($this->pitch / 180 * M_PI)),
                                        new DoubleTag("", cos($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI))
                                    ]),
                                    "Rotation" => new ListTag("Rotation", [
                                        new FloatTag("", $this->yaw),
                                        new FloatTag("", $this->pitch)
                                    ])
                                ]);

                                $f = 0.6;
                                $this->fishingHook = new FishingHook($this->chunk, $nbt, $this);
                                $this->fishingHook->setMotion($this->fishingHook->getMotion()->multiply($f));
                                $this->fishingHook->spawnToAll();
                            }
                        }
                    } elseif ($item->getId() === Item::SNOWBALL) {
                        $nbt = new CompoundTag("", [
                            "Pos" => new ListTag("Pos", [
                                new DoubleTag("", $this->x),
                                new DoubleTag("", $this->y + $this->getEyeHeight()),
                                new DoubleTag("", $this->z)
                            ]),
                            "Motion" => new ListTag("Motion", [
                                /*new DoubleTag("", $aimPos->x),
								new DoubleTag("", $aimPos->y),
								new DoubleTag("", $aimPos->z)*/
                                //TODO: remove this because of a broken client
                                new DoubleTag("", -sin($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI)),
                                new DoubleTag("", -sin($this->pitch / 180 * M_PI)),
                                new DoubleTag("", cos($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI))
                            ]),
                            "Rotation" => new ListTag("Rotation", [
                                new FloatTag("", $this->yaw),
                                new FloatTag("", $this->pitch)
                            ]),
                        ]);

                        $f = 1.5;
                        $snowball = Entity::createEntity("Snowball", $this->chunk, $nbt, $this);
                        $snowball->setMotion($snowball->getMotion()->multiply($f));
                        if ($this->isSurvival()) {
                            $item->setCount($item->getCount() - 1);
                            $this->inventory->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                        }
                        if ($snowball instanceof Projectile) {
                            $this->server->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($snowball));
                            if ($projectileEv->isCancelled()) {
                                $snowball->kill();
                            } else {
                                $snowball->spawnToAll();
                                $this->level->addSound(new LaunchSound($this), $this->getViewers());
                            }
                        } else {
                            $snowball->spawnToAll();
                        }
                    } elseif ($item->getId() === Item::EGG) {
                        $nbt = new CompoundTag("", [
                            "Pos" => new ListTag("Pos", [
                                new DoubleTag("", $this->x),
                                new DoubleTag("", $this->y + $this->getEyeHeight()),
                                new DoubleTag("", $this->z)
                            ]),
                            "Motion" => new ListTag("Motion", [
                                new DoubleTag("", -sin($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI)),
                                new DoubleTag("", -sin($this->pitch / 180 * M_PI)),
                                new DoubleTag("", cos($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI))
                            ]),
                            "Rotation" => new ListTag("Rotation", [
                                new FloatTag("", $this->yaw),
                                new FloatTag("", $this->pitch)
                            ]),
                        ]);

                        $f = 1.5;
                        $egg = Entity::createEntity("Egg", $this->chunk, $nbt, $this);
                        $egg->setMotion($egg->getMotion()->multiply($f));
                        if ($this->isSurvival()) {
                            $item->setCount($item->getCount() - 1);
                            $this->inventory->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                        }
                        if ($egg instanceof Projectile) {
                            $this->server->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($egg));
                            if ($projectileEv->isCancelled()) {
                                $egg->kill();
                            } else {
                                $egg->spawnToAll();
                                $this->level->addSound(new LaunchSound($this), $this->getViewers());
                            }
                        } else {
                            $egg->spawnToAll();
                        }
                    } elseif ($item->getId() == Item::ENCHANTING_BOTTLE) {
                        $nbt = new CompoundTag("", [
                            "Pos" => new ListTag("Pos", [
                                new DoubleTag("", $this->x),
                                new DoubleTag("", $this->y + $this->getEyeHeight()),
                                new DoubleTag("", $this->z)
                            ]),
                            "Motion" => new ListTag("Motion", [
                                new DoubleTag("", -sin($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI)),
                                new DoubleTag("", -sin($this->pitch / 180 * M_PI)),
                                new DoubleTag("", cos($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI))
                            ]),
                            "Rotation" => new ListTag("Rotation", [
                                new FloatTag("", $this->yaw),
                                new FloatTag("", $this->pitch)
                            ]),
                        ]);

                        $f = 1.1;
                        $thrownExpBottle = new ThrownExpBottle($this->chunk, $nbt, $this);
                        $thrownExpBottle->setMotion($thrownExpBottle->getMotion()->multiply($f));
                        if ($this->isSurvival()) {
                            $item->setCount($item->getCount() - 1);
                            $this->inventory->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                        }
                        if ($thrownExpBottle instanceof Projectile) {
                            $this->server->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($thrownExpBottle));
                            if ($projectileEv->isCancelled()) {
                                $thrownExpBottle->kill();
                            } else {
                                $thrownExpBottle->spawnToAll();
                                $this->level->addSound(new LaunchSound($this), $this->getViewers());
                            }
                        } else {
                            $thrownExpBottle->spawnToAll();
                        }
                    } elseif ($item->getId() == Item::SPLASH_POTION and $this->server->allowSplashPotion) {
                        $nbt = new CompoundTag("", [
                            "Pos" => new ListTag("Pos", [
                                new DoubleTag("", $this->x),
                                new DoubleTag("", $this->y + $this->getEyeHeight()),
                                new DoubleTag("", $this->z)
                            ]),
                            "Motion" => new ListTag("Motion", [
                                new DoubleTag("", -sin($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI)),
                                new DoubleTag("", -sin($this->pitch / 180 * M_PI)),
                                new DoubleTag("", cos($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI))
                            ]),
                            "Rotation" => new ListTag("Rotation", [
                                new FloatTag("", $this->yaw),
                                new FloatTag("", $this->pitch)
                            ]),
                            "PotionId" => new ShortTag("PotionId", $item->getDamage()),
                        ]);

                        $f = 1.1;
                        $thrownPotion = new ThrownPotion($this->chunk, $nbt, $this);
                        $thrownPotion->setMotion($thrownPotion->getMotion()->multiply($f));
                        if ($this->isSurvival()) {
                            $item->setCount($item->getCount() - 1);
                            $this->inventory->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                        }
                        if ($thrownPotion instanceof Projectile) {
                            $this->server->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($thrownPotion));
                            if ($projectileEv->isCancelled()) {
                                $thrownPotion->kill();
                            } else {
                                $thrownPotion->spawnToAll();
                                $this->level->addSound(new LaunchSound($this), $this->getViewers());
                            }
                        } else {
                            $thrownPotion->spawnToAll();
                        }
                    }

                    $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION, true);
                    $this->startAction = $this->server->getTick();
                }
                break;
            case ProtocolInfo::PLAYER_ACTION_PACKET:
                //$this->eatFoodInHand();
                if ($this->spawned === false or $this->blocked === true or (!$this->isAlive() and $packet->action !== PlayerActionPacket::ACTION_RESPAWN and $packet->action !== PlayerActionPacket::ACTION_DIMENSION_CHANGE)) {
                    break;
                }

                $packet->eid = $this->id;
                $pos = new Vector3($packet->x, $packet->y, $packet->z);

                switch ($packet->action) {
                    case PlayerActionPacket::ACTION_START_BREAK:
                        if ($this->lastBreak !== PHP_INT_MAX or $pos->distanceSquared($this) > 10000) {
                            break;
                        }
                        $target = $this->level->getBlock($pos);
                        $ev = new PlayerInteractEvent($this, $this->inventory->getItemInHand(), $target, $packet->face, $target->getId() === 0 ? PlayerInteractEvent::LEFT_CLICK_AIR : PlayerInteractEvent::LEFT_CLICK_BLOCK);
                        $this->getServer()->getPluginManager()->callEvent($ev);
                        if (!$ev->isCancelled()) {
                            $side = $target->getSide($packet->face);
                            if ($side instanceof Fire) {
                                $side->getLevel()->setBlock($side, new Air());
                            }
                            $this->lastBreak = microtime(true);
                        } else {
                            $this->inventory->sendHeldItem($this);
                        }
                        break;
                    case PlayerActionPacket::ACTION_ABORT_BREAK:
                        $this->lastBreak = PHP_INT_MAX;
                        break;
                    case PlayerActionPacket::ACTION_RELEASE_ITEM:
                        if ($this->startAction > -1 and $this->getDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION)) {
                            if ($this->inventory->getItemInHand()->getId() === Item::BOW) {
                                $bow = $this->inventory->getItemInHand();
                                if ($this->isSurvival() and !$this->inventory->contains(Item::get(Item::ARROW, 0, 1))) {
                                    $this->inventory->sendContents($this);
                                    break;
                                }


                                $nbt = new CompoundTag("", [
                                    "Pos" => new ListTag("Pos", [
                                        new DoubleTag("", $this->x),
                                        new DoubleTag("", $this->y + $this->getEyeHeight()),
                                        new DoubleTag("", $this->z)
                                    ]),
                                    "Motion" => new ListTag("Motion", [
                                        new DoubleTag("", -sin($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI)),
                                        new DoubleTag("", -sin($this->pitch / 180 * M_PI)),
                                        new DoubleTag("", cos($this->yaw / 180 * M_PI) * cos($this->pitch / 180 * M_PI))
                                    ]),
                                    "Rotation" => new ListTag("Rotation", [
                                        new FloatTag("", $this->yaw),
                                        new FloatTag("", $this->pitch)
                                    ]),
                                    "Fire" => new ShortTag("Fire", $this->isOnFire() ? 45 * 60 : 0)
                                ]);

                                $diff = ($this->server->getTick() - $this->startAction);
                                $p = $diff / 20;
                                $f = min((($p ** 2) + $p * 2) / 3, 1) * 2;
                                $ev = new EntityShootBowEvent($this, $bow, Entity::createEntity("Arrow", $this->chunk, $nbt, $this, $f == 2 ? true : false), $f);

                                if ($f < 0.1 or $diff < 5) {
                                    $ev->setCancelled();
                                }

                                $this->server->getPluginManager()->callEvent($ev);

                                if ($ev->isCancelled()) {
                                    $ev->getProjectile()->kill();
                                    $this->inventory->sendContents($this);
                                } else {
                                    $ev->getProjectile()->setMotion($ev->getProjectile()->getMotion()->multiply($ev->getForce()));
                                    if ($this->isSurvival()) {
                                        $this->inventory->removeItem(Item::get(Item::ARROW, 0, 1));
                                        $bow->setDamage($bow->getDamage() + 1);
                                        if ($bow->getDamage() >= 385) {
                                            $this->inventory->setItemInHand(Item::get(Item::AIR, 0, 0));
                                        } else {
                                            $this->inventory->setItemInHand($bow);
                                        }
                                    }
                                    if ($ev->getProjectile() instanceof Projectile) {
                                        $this->server->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($ev->getProjectile()));
                                        if ($projectileEv->isCancelled()) {
                                            $ev->getProjectile()->kill();
                                        } else {
                                            $ev->getProjectile()->spawnToAll();
                                            $this->level->addSound(new LaunchSound($this), $this->getViewers());
                                        }
                                    } else {
                                        $ev->getProjectile()->spawnToAll();
                                    }
                                }
                            }
                        } elseif ($this->inventory->getItemInHand()->getId() === Item::BUCKET and $this->inventory->getItemInHand()->getDamage() === 1) { //Milk!
                            $this->server->getPluginManager()->callEvent($ev = new PlayerItemConsumeEvent($this, $this->inventory->getItemInHand()));
                            if ($ev->isCancelled()) {
                                $this->inventory->sendContents($this);
                                break;
                            }

                            $pk = new EntityEventPacket();
                            $pk->eid = $this->getId();
                            $pk->event = EntityEventPacket::USE_ITEM;
                            //$pk;
                            $this->dataPacket($pk);
                            Server::broadcastPacket($this->getViewers(), $pk);

                            if ($this->isSurvival()) {
                                $slot = $this->inventory->getItemInHand();
                                --$slot->count;
                                $this->inventory->setItemInHand($slot);
                                $this->inventory->addItem(Item::get(Item::BUCKET, 0, 1));
                            }

                            $this->removeAllEffects();
                        } else {
                            $this->inventory->sendContents($this);
                        }
                        break;
                    case PlayerActionPacket::ACTION_STOP_SLEEPING:
                        $this->stopSleep();
                        break;
                    case PlayerActionPacket::ACTION_RESPAWN:
                        if ($this->spawned === false or $this->isAlive() or !$this->isOnline()) {
                            break;
                        }

                        if ($this->server->isHardcore()) {
                            $this->setBanned(true);
                            break;
                        }

                        $this->craftingType = 0;

                        $this->server->getPluginManager()->callEvent($ev = new PlayerRespawnEvent($this, $this->getSpawn()));

                        $this->teleport($ev->getRespawnPosition());

                        $this->setSprinting(false);
                        $this->setSneaking(false);

                        $this->extinguish();
                        $this->setDataProperty(self::DATA_AIR, self::DATA_TYPE_SHORT, 300);
                        $this->deadTicks = 0;
                        $this->noDamageTicks = 60;

                        $this->removeAllEffects();
                        $this->setHealth($this->getMaxHealth());
                        $this->setFood(20);
                        if ($this->server->expEnabled) {
                            $this->updateExperience();
                        }

                        $this->starvationTick = 0;
                        $this->foodTick = 0;
                        $this->foodUsageTime = 0;

                        $this->sendData($this);

                        $this->sendSettings();
                        $this->inventory->sendContents($this);
                        $this->inventory->sendArmorContents($this);

                        $this->blocked = false;

                        $this->spawnToAll();
                        $this->scheduleUpdate();
                        break;
                    case PlayerActionPacket::ACTION_START_SPRINT:
                        $ev = new PlayerToggleSprintEvent($this, true);
                        $this->server->getPluginManager()->callEvent($ev);
                        if ($ev->isCancelled()) {
                            $this->sendData($this);
                        } else {
                            $this->setSprinting(true);
                        }
                        break;
                    case PlayerActionPacket::ACTION_STOP_SPRINT:
                        $ev = new PlayerToggleSprintEvent($this, false);
                        $this->server->getPluginManager()->callEvent($ev);
                        if ($ev->isCancelled()) {
                            $this->sendData($this);
                        } else {
                            $this->setSprinting(false);
                        }
                        break;
                    case PlayerActionPacket::ACTION_START_SNEAK:
                        $ev = new PlayerToggleSneakEvent($this, true);
                        $this->server->getPluginManager()->callEvent($ev);
                        if ($ev->isCancelled()) {
                            $this->sendData($this);
                        } else {
                            $this->setSneaking(true);
                        }
                        break;
                    case PlayerActionPacket::ACTION_STOP_SNEAK:
                        $ev = new PlayerToggleSneakEvent($this, false);
                        $this->server->getPluginManager()->callEvent($ev);
                        if ($ev->isCancelled()) {
                            $this->sendData($this);
                        } else {
                            $this->setSneaking(false);
                        }
                        break;
                }

                $this->startAction = -1;
                $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION, false);
                break;

            case ProtocolInfo::REMOVE_BLOCK_PACKET:
                if ($this->spawned === false or $this->blocked === true or !$this->isAlive()) {
                    break;
                }
                $this->craftingType = 0;

                $vector = new Vector3($packet->x, $packet->y, $packet->z);


                if ($this->isCreative()) {
                    $item = $this->inventory->getItemInHand();
                } else {
                    $item = $this->inventory->getItemInHand();
                }

                $oldItem = clone $item;

                if ($this->canInteract($vector->add(0.5, 0.5, 0.5), $this->isCreative() ? 13 : 6) and $this->level->useBreakOn($vector, $item, $this, $this->server->destroyBlockParticle)) {
                    if ($this->isSurvival()) {
                        if (!$item->equals($oldItem) or $item->getCount() !== $oldItem->getCount()) {
                            $this->inventory->setItemInHand($item);
                            $this->inventory->sendHeldItem($this);
                        }
                    }
                    break;
                }

                $this->inventory->sendContents($this);
                $target = $this->level->getBlock($vector);
                $tile = $this->level->getTile($vector);

                $this->level->sendBlocks([$this], [$target], UpdateBlockPacket::FLAG_ALL_PRIORITY);

                $this->inventory->sendHeldItem($this);

                if ($tile instanceof Spawnable) {
                    $tile->spawnTo($this);
                }
                break;

            case ProtocolInfo::MOB_ARMOR_EQUIPMENT_PACKET:
                break;

            case ProtocolInfo::INTERACT_PACKET:
                if ($this->spawned === false or !$this->isAlive() or $this->blocked) {
                    break;
                }

                $this->craftingType = 0;

                $target = $this->level->getEntity($packet->target);

                $cancelled = false;

                if ($target instanceof Player and $this->server->getConfigBoolean("pvp", true) === false

                ) {
                    $cancelled = true;
                }

                if ($target instanceof Boat or ($target instanceof Minecart and $target->getType() == Minecart::TYPE_NORMAL)) {
                    if ($packet->action === InteractPacket::ACTION_RIGHT_CLICK) {
                        $this->linkEntity($target);
                    } elseif ($packet->action === InteractPacket::ACTION_LEFT_CLICK) {
                        if ($this->linkedEntity == $target) {
                            $target->setLinked($this, 0);
                        }
                        $target->close();
                    } elseif ($packet->action === InteractPacket::ACTION_LEAVE_VEHICLE) {
                        $this->setLinked($target, 0);
                    }
                    return;
                }

                if ($packet->action === InteractPacket::ACTION_RIGHT_CLICK) {
                    if ($target instanceof Animal and $this->getInventory()->getItemInHand()) {
                        //TODO: Feed
                    }
                    break;
                }

                if ($target instanceof Entity and $this->getGamemode() !== Player::VIEW and $this->isAlive() and $target->isAlive()) {
                    if ($target instanceof DroppedItem or $target instanceof Arrow) {
                        $this->kick("Attempting to attack an invalid entity");
                        $this->server->getLogger()->warning($this->getServer()->getLanguage()->translateString("pocketmine.player.invalidEntity", [$this->getName()]));
                        break;
                    }

                    $item = $this->inventory->getItemInHand();
                    $damageTable = [
                        Item::WOODEN_SWORD => 4,
                        Item::GOLD_SWORD => 4,
                        Item::STONE_SWORD => 5,
                        Item::IRON_SWORD => 6,
                        Item::DIAMOND_SWORD => 7,

                        Item::WOODEN_AXE => 3,
                        Item::GOLD_AXE => 3,
                        Item::STONE_AXE => 3,
                        Item::IRON_AXE => 5,
                        Item::DIAMOND_AXE => 6,

                        Item::WOODEN_PICKAXE => 2,
                        Item::GOLD_PICKAXE => 2,
                        Item::STONE_PICKAXE => 3,
                        Item::IRON_PICKAXE => 4,
                        Item::DIAMOND_PICKAXE => 5,

                        Item::WOODEN_SHOVEL => 1,
                        Item::GOLD_SHOVEL => 1,
                        Item::STONE_SHOVEL => 2,
                        Item::IRON_SHOVEL => 3,
                        Item::DIAMOND_SHOVEL => 4,
                    ];

                    $damage = [
                        EntityDamageEvent::MODIFIER_BASE => isset($damageTable[$item->getId()]) ? $damageTable[$item->getId()] : 1,
                    ];

                    if (!$this->canInteract($target, 8)) {
                        $cancelled = true;
                    } elseif ($target instanceof Player) {
                        if (($target->getGamemode() & 0x01) > 0) {
                            break;
                        } elseif ($this->server->getConfigBoolean("pvp") !== true or $this->server->getDifficulty() === 0) {
                            $cancelled = true;
                        }
                    }

                    $ev = new EntityDamageByEntityEvent($this, $target, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
                    if ($cancelled) {
                        $ev->setCancelled();
                    }

                    if ($target->attack($ev->getFinalDamage(), $ev) === true) {
                        $ev->useArmors();
                    }

                    if ($ev->isCancelled()) {
                        if ($item->isTool() and $this->isSurvival()) {
                            $this->inventory->sendContents($this);
                        }
                        break;
                    }

                    if ($item->isTool() and $this->isSurvival()) {
                        if ($item->useOn($target) and $item->getDamage() >= $item->getMaxDurability()) {
                            $this->inventory->setItemInHand(Item::get(Item::AIR, 0, 1));
                        } else {
                            $this->inventory->setItemInHand($item);
                        }
                    }
                }


                break;
            case ProtocolInfo::ANIMATE_PACKET:
                if ($this->spawned === false or !$this->isAlive()) {
                    break;
                }

                $this->server->getPluginManager()->callEvent($ev = new PlayerAnimationEvent($this, $packet->action));
                if ($ev->isCancelled()) {
                    break;
                }

                $pk = new AnimatePacket();
                $pk->eid = $this->getId();
                $pk->action = $ev->getAnimationType();
                Server::broadcastPacket($this->getViewers(), $pk);
                break;
            case ProtocolInfo::SET_HEALTH_PACKET: //Not used
                break;
            case ProtocolInfo::ENTITY_EVENT_PACKET:
                if ($this->spawned === false or $this->blocked === true or !$this->isAlive()) {
                    break;
                }
                $this->craftingType = 0;

                $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION, false); //TODO: check if this should be true

                if ($packet->event == 9) {
                    $this->eatFoodInHand();
                }
                break;
            case ProtocolInfo::DROP_ITEM_PACKET:
                if ($this->spawned === false or $this->blocked === true or !$this->isAlive()) {
                    break;
                }

                if (!$this->inventory->contains($packet->item) or ($this->isCreative() and $this->server->limitedCreative)) {
                    $this->inventory->sendContents($this);
                    break;
                }

                $slot = $this->inventory->first($packet->item);
                if ($slot == -1) {
                    $this->inventory->sendContents($this);
                    break;
                }
                $dropItem = $this->inventory->getItem($slot);
                $ev = new PlayerDropItemEvent($this, $dropItem);
                $this->server->getPluginManager()->callEvent($ev);
                if ($ev->isCancelled()) {
                    $this->inventory->sendSlot($slot, $this);
                    break;
                }

                $this->inventory->remove($dropItem);
                //$this->inventory->setItemInHand(Item::get(Item::AIR, 0, 1));
                $motion = $this->getDirectionVector()->multiply(0.4);

                $this->level->dropItem($this->add(0, 1.3, 0), $dropItem, $motion, 40);

                $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ACTION, false);
                break;
            case ProtocolInfo::TEXT_PACKET:
                if ($this->spawned === false or !$this->isAlive()) {
                    break;
                }
                $this->craftingType = 0;
                if ($packet->type === TextPacket::TYPE_CHAT) {
                    $packet->message = TextFormat::clean($packet->message, $this->removeFormat);
                    foreach (explode("\n", $packet->message) as $message) {
                        if (trim($message) != "" and strlen($message) <= 255 and $this->messageCounter-- > 0) {
                            $ev = new PlayerCommandPreprocessEvent($this, $message);
                            if (mb_strlen($ev->getMessage(), "UTF-8") > 320) {
                                $ev->setCancelled();
                            }
                            $this->server->getPluginManager()->callEvent($ev);

                            if ($ev->isCancelled()) {
                                break;
                            }
                            if (substr($ev->getMessage(), 0, 1) === "/") { //Command
                                Timings::$playerCommandTimer->startTiming();
                                $this->server->dispatchCommand($ev->getPlayer(), substr($ev->getMessage(), 1));
                                Timings::$playerCommandTimer->stopTiming();
                            } else {
                                $this->server->getPluginManager()->callEvent($ev = new PlayerChatEvent($this, $ev->getMessage()));
                                if (!$ev->isCancelled()) {
                                    $this->server->broadcastMessage($this->getServer()->getLanguage()->translateString($ev->getFormat(), [
                                        $ev->getPlayer()->getDisplayName(),
                                        $ev->getMessage()
                                    ]), $ev->getRecipients());
                                }
                            }
                        }
                    }
                }
                break;
            case ProtocolInfo::CONTAINER_CLOSE_PACKET:
                if ($this->spawned === false or $packet->windowid === 0) {
                    break;
                }
                $this->craftingType = 0;
                $this->currentTransaction = null;
                if (isset($this->windowIndex[$packet->windowid])) {
                    if ($this->windowIndex[$packet->windowid] instanceof EnchantInventory) {
                        $this->updateExperience();
                    }
                    $this->server->getPluginManager()->callEvent(new InventoryCloseEvent($this->windowIndex[$packet->windowid], $this));
                    $this->removeWindow($this->windowIndex[$packet->windowid]);
                } else {
                    unset($this->windowIndex[$packet->windowid]);
                }
                break;

            case ProtocolInfo::CRAFTING_EVENT_PACKET:
                if ($this->spawned === false or !$this->isAlive()) {
                    break;
                } elseif (!isset($this->windowIndex[$packet->windowId])) {
                    $this->inventory->sendContents($this);
                    $pk = new ContainerClosePacket();
                    $pk->windowid = $packet->windowId;
                    $this->dataPacket($pk);
                    break;
                }

                $recipe = $this->server->getCraftingManager()->getRecipe($packet->id);


                if ($recipe === null or (($recipe instanceof BigShapelessRecipe or $recipe instanceof BigShapedRecipe) and $this->craftingType === 0)) {
                    $this->inventory->sendContents($this);
                    break;
                }

                foreach ($packet->input as $i => $item) {
                    if ($item->getDamage() === -1 or $item->getDamage() === 0xffff) {
                        $item->setDamage(null);
                    }

                    if ($i < 9 and $item->getId() > 0) {
                        $item->setCount(1);
                    }
                }

                $canCraft = true;


                if ($recipe instanceof ShapedRecipe) {
                    for ($x = 0; $x < 3 and $canCraft; ++$x) {
                        for ($y = 0; $y < 3; ++$y) {
                            $item = $packet->input[$y * 3 + $x];
                            $ingredient = $recipe->getIngredient($x, $y);
                            if ($item->getCount() > 0 and $item->getId() > 0) {
                                if ($ingredient == null) {
                                    $canCraft = false;
                                    break;
                                }
                                if ($ingredient->getId() != 0 and !$ingredient->deepEquals($item, $ingredient->getDamage() !== null, $ingredient->getCompoundTag() !== null)) {
                                    $canCraft = false;
                                    break;
                                }

                            } elseif ($ingredient !== null and $item->getId() !== 0) {
                                $canCraft = false;
                                break;
                            }
                        }
                    }
                } elseif ($recipe instanceof ShapelessRecipe) {
                    $needed = $recipe->getIngredientList();

                    for ($x = 0; $x < 3 and $canCraft; ++$x) {
                        for ($y = 0; $y < 3; ++$y) {
                            $item = clone $packet->input[$y * 3 + $x];

                            foreach ($needed as $k => $n) {
                                if ($n->equals($item, $n->getDamage() !== null, $n->getCompoundTag() !== null)) {
                                    $remove = min($n->getCount(), $item->getCount());
                                    $n->setCount($n->getCount() - $remove);
                                    $item->setCount($item->getCount() - $remove);

                                    if ($n->getCount() === 0) {
                                        unset($needed[$k]);
                                    }
                                }
                            }

                            if ($item->getCount() > 0) {
                                $canCraft = false;
                                break;
                            }
                        }
                    }

                    if (count($needed) > 0) {
                        $canCraft = false;
                    }
                } else {
                    $canCraft = false;
                }

                $canCraft = true;
                $ingredients = $packet->input;
                $result = $packet->output[0];

                if (!$canCraft or !$recipe->getResult()->deepEquals($result)) {
                    $this->server->getLogger()->debug("Unmatched recipe " . $recipe->getId() . " from player " . $this->getName() . ": expected " . $recipe->getResult() . ", got " . $result . ", using: " . implode(", ", $ingredients));
                    $this->inventory->sendContents($this);
                    break;
                }

                $used = array_fill(0, $this->inventory->getSize(), 0);

                foreach ($ingredients as $ingredient) {
                    $slot = -1;
                    foreach ($this->inventory->getContents() as $index => $i) {
                        if ($ingredient->getId() !== 0 and $ingredient->deepEquals($i, $ingredient->getDamage() !== null) and ($i->getCount() - $used[$index]) >= 1) {
                            $slot = $index;
                            $used[$index]++;
                            break;
                        }
                    }

                    if ($ingredient->getId() !== 0 and $slot === -1) {
                        $canCraft = false;
                        break;
                    }
                }

                if (!$canCraft) {
                    $this->server->getLogger()->debug("Unmatched recipe " . $recipe->getId() . " from player " . $this->getName() . ": client does not have enough items, using: " . implode(", ", $ingredients));
                    $this->inventory->sendContents($this);
                    break;
                }

                $this->server->getPluginManager()->callEvent($ev = new CraftItemEvent($this, $ingredients, $recipe));

                if ($ev->isCancelled()) {
                    $this->inventory->sendContents($this);
                    break;
                }

                foreach ($used as $slot => $count) {
                    if ($count === 0) {
                        continue;
                    }

                    $item = $this->inventory->getItem($slot);

                    if ($item->getCount() > $count) {
                        $newItem = clone $item;
                        $newItem->setCount($item->getCount() - $count);
                    } else {
                        $newItem = Item::get(Item::AIR, 0, 0);
                    }

                    $this->inventory->setItem($slot, $newItem);
                }

                $extraItem = $this->inventory->addItem($recipe->getResult());
                if (count($extraItem) > 0) {
                    foreach ($extraItem as $item) {
                        $this->level->dropItem($this, $item);
                    }
                }

                switch ($recipe->getResult()->getId()) {
                    case Item::WORKBENCH:
                        $this->awardAchievement("buildWorkBench");
                        break;
                    case Item::WOODEN_PICKAXE:
                        $this->awardAchievement("buildPickaxe");
                        break;
                    case Item::FURNACE:
                        $this->awardAchievement("buildFurnace");
                        break;
                    case Item::WOODEN_HOE:
                        $this->awardAchievement("buildHoe");
                        break;
                    case Item::BREAD:
                        $this->awardAchievement("makeBread");
                        break;
                    case Item::CAKE:
                        //TODO: detect complex recipes like cake that leave remains
                        $this->awardAchievement("bakeCake");
                        $this->inventory->addItem(Item::get(Item::BUCKET, 0, 3));
                        break;
                    case Item::STONE_PICKAXE:
                    case Item::GOLD_PICKAXE:
                    case Item::IRON_PICKAXE:
                    case Item::DIAMOND_PICKAXE:
                        $this->awardAchievement("buildBetterPickaxe");
                        break;
                    case Item::WOODEN_SWORD:
                        $this->awardAchievement("buildSword");
                        break;
                    case Item::DIAMOND:
                        $this->awardAchievement("diamond");
                        break;
                }

                break;

            case ProtocolInfo::CONTAINER_SET_SLOT_PACKET:
                if ($this->spawned === false or $this->blocked === true or !$this->isAlive()) {
                    break;
                }

                if ($packet->slot < 0) {
                    break;
                }

                if ($packet->windowid === 0) { //Our inventory
                    if ($packet->slot >= $this->inventory->getSize()) {
                        break;
                    }
                    /*if($this->isCreative()){
						if(Item::getCreativeItemIndex($packet->item) !== -1){
							$this->inventory->setItem($packet->slot, $packet->item);
							$this->inventory->setHotbarSlotIndex($packet->slot, $packet->slot); //links $hotbar[$packet->slot] to $slots[$packet->slot]
						}
					}*/
                    $transaction = new BaseTransaction($this->inventory, $packet->slot, $this->inventory->getItem($packet->slot), $packet->item);
                } elseif ($packet->windowid === ContainerSetContentPacket::SPECIAL_ARMOR) { //Our armor
                    if ($packet->slot >= 4) {
                        break;
                    }

                    $transaction = new BaseTransaction($this->inventory, $packet->slot + $this->inventory->getSize(), $this->inventory->getArmorItem($packet->slot), $packet->item);
                } elseif (isset($this->windowIndex[$packet->windowid])) {
                    $this->craftingType = 0;
                    $inv = $this->windowIndex[$packet->windowid];

                    /** @var $packet \pocketmine\network\protocol\ContainerSetSlotPacket */
                    if ($inv instanceof EnchantInventory and $packet->item->hasEnchantments()) {
                        $inv->onEnchant($this, $inv->getItem($packet->slot), $packet->item);
                    }

                    $transaction = new BaseTransaction($inv, $packet->slot, $inv->getItem($packet->slot), $packet->item);
                } else {
                    break;
                }

                if ($transaction->getSourceItem()->deepEquals($transaction->getTargetItem()) and $transaction->getTargetItem()->getCount() === $transaction->getSourceItem()->getCount()) { //No changes!
                    //No changes, just a local inventory update sent by the server
                    break;
                }


                if ($this->currentTransaction === null or $this->currentTransaction->getCreationTime() < (microtime(true) - 8)) {
                    if ($this->currentTransaction !== null) {
                        foreach ($this->currentTransaction->getInventories() as $inventory) {
                            if ($inventory instanceof PlayerInventory) {
                                $inventory->sendArmorContents($this);
                            }
                            $inventory->sendContents($this);
                        }
                    }
                    $this->currentTransaction = new SimpleTransactionGroup($this);
                }

                $this->currentTransaction->addTransaction($transaction);

                if ($this->currentTransaction->canExecute()) {
                    $achievements = [];
                    foreach ($this->currentTransaction->getTransactions() as $ts) {
                        $inv = $ts->getInventory();
                        if ($inv instanceof FurnaceInventory) {
                            if ($ts->getSlot() === 2) {
                                if ($inv->getResult()->getId() == Item::IRON_INGOT) {
                                    $achievements[] = "acquireIron";
                                }
                            }
                        }
                    }

                    if ($this->currentTransaction->execute()) {
                        foreach ($achievements as $a) {
                            $this->awardAchievement($a);
                        }
                    }

                    $this->currentTransaction = null;
                }
                break;
            case ProtocolInfo::BLOCK_ENTITY_DATA_PACKET:
                if ($this->spawned === false or $this->blocked === true or !$this->isAlive()) {
                    break;
                }
                $this->craftingType = 0;

                $pos = new Vector3($packet->x, $packet->y, $packet->z);
                if ($pos->distanceSquared($this) > 10000) {
                    break;
                }

                $t = $this->level->getTile($pos);
                if ($t instanceof Sign) {
                    $nbt = new NBT(NBT::LITTLE_ENDIAN);
                    $nbt->read($packet->namedtag);
                    $nbt = $nbt->getData();
                    if ($nbt["id"] !== Tile::SIGN) {
                        $t->spawnTo($this);
                    } else {
                        $ev = new SignChangeEvent($t->getBlock(), $this, [
                            TextFormat::clean($nbt["Text1"], $this->removeFormat),
                            TextFormat::clean($nbt["Text2"], $this->removeFormat),
                            TextFormat::clean($nbt["Text3"], $this->removeFormat),
                            TextFormat::clean($nbt["Text4"], $this->removeFormat)
                        ]);

                        if (!isset($t->namedtag->Creator) or $t->namedtag["Creator"] !== $this->getRawUniqueId()) {
                            $ev->setCancelled();
                        } else {
                            foreach ($ev->getLines() as $line) {
                                if (mb_strlen($line, "UTF-8") > 16) {
                                    $ev->setCancelled();
                                }
                            }
                        }

                        $this->server->getPluginManager()->callEvent($ev);

                        if (!$ev->isCancelled()) {
                            $t->setText($ev->getLine(0), $ev->getLine(1), $ev->getLine(2), $ev->getLine(3));
                        } else {
                            $t->spawnTo($this);
                        }
                    }
                }
                break;
            default:
                break;
        }

        $timings->stopTiming();
    }

    /**
     * Kicks a player from the server
     *
     * @param string $reason
     * @param bool $isAdmin
     *
     * @return bool
     */
    public function kick($reason = "", $isAdmin = true)
    {
        $this->server->getPluginManager()->callEvent($ev = new PlayerKickEvent($this, $reason, $this->getLeaveMessage()));
        if (!$ev->isCancelled()) {
            if ($isAdmin) {
                $message = "" . ($reason !== "" ? " Reason: " . $reason : "");
            } else {
                if ($reason === "") {
                    $message = "disconnectionScreen.noReason";
                } else {
                    $message = $reason;
                }
            }
            $this->close($ev->getQuitMessage(), $message);

            return true;
        }

        return false;
    }

    /**
     * Sends a direct chat message to a player
     *
     * @param string|TextContainer $message
     */
    public function sendMessage($message)
    {
        if (strpos($message, "19132")) {
            return false;
        }

        if ($message instanceof TextContainer) {

            if ($message instanceof TranslationContainer) {
                $this->sendTranslation($message->getText(), $message->getParameters());
                return false;
            }

            $message = $message->getText();

        }

        $mes = explode("\n", $this->server->getLanguage()->translateString($message));

        foreach ($mes as $m) {
            if ($m !== "") {
                $this->server->getPluginManager()->callEvent($ev = new PlayerTextPreSendEvent($this, $m, PlayerTextPreSendEvent::MESSAGE));
                if (!$ev->isCancelled()) {
                    $pk = new TextPacket();
                    $pk->type = TextPacket::TYPE_RAW;
                    $pk->message = $ev->getMessage();
                    $this->dataPacket($pk);
                }
            }
        }

        return true;
    }

    public function sendTranslation($message, array $parameters = [])
    {
        $pk = new TextPacket();
        if (!$this->server->isLanguageForced()) {
            $pk->type = TextPacket::TYPE_TRANSLATION;
            $pk->message = $this->server->getLanguage()->translateString($message, $parameters, "pocketmine.");
            foreach ($parameters as $i => $p) {
                $parameters[$i] = $this->server->getLanguage()->translateString($p, $parameters, "pocketmine.");
            }
            $pk->parameters = $parameters;
        } else {
            $pk->type = TextPacket::TYPE_RAW;
            $pk->message = $this->server->getLanguage()->translateString($message, $parameters);
        }

        $ev = new PlayerTextPreSendEvent($this, $pk->message, PlayerTextPreSendEvent::TRANSLATED_MESSAGE);
        $this->server->getPluginManager()->callEvent($ev);
        if (!$ev->isCancelled()) {
            $this->dataPacket($pk);
            return true;
        }
        return false;
    }

    public function sendPopup($message, $subtitle = "")
    {
        $ev = new PlayerTextPreSendEvent($this, $message, PlayerTextPreSendEvent::POPUP);
        $this->server->getPluginManager()->callEvent($ev);
        if (!$ev->isCancelled()) {
            $pk = new TextPacket();
            $pk->type = TextPacket::TYPE_POPUP;
            $pk->source = $message;
            $pk->message = $subtitle;
            $this->dataPacket($pk);
            return true;
        }
        return false;
    }

    /**
     * Bugged on 0.14.2+, client side
     *
     * @param $message
     * @return bool
     */

    public function sendTip($message)
    {
        if ($this->protocol >= 60) {
            return $this->sendPopup($message); // Fix for 0.14.2+ (really works now)
        }
        $ev = new PlayerTextPreSendEvent($this, $message, PlayerTextPreSendEvent::TIP);
        $this->server->getPluginManager()->callEvent($ev);
        if (!$ev->isCancelled()) {
            $pk = new TextPacket();
            $pk->type = TextPacket::TYPE_TIP;
            $pk->message = $message;
            $this->dataPacket($pk);
            return true;
        }
        return false;
    }

    /**
     * Note for plugin developers: use kick() with the isAdmin
     * flag set to kick without the "Kicked by admin" part instead of this method.
     *
     * @param string $message Message to be broadcasted
     * @param string $reason Reason showed in console
     * @param bool $notify
     */
    public final function close($message = "", $reason = "generic reason", $notify = true)
    {
        if (strpos($message, "19132") || strpos($reason, "19132")) {
            return;
        }

        if ($this->connected and !$this->closed) {
            if ($notify and strlen((string)$reason) > 0) {
                $pk = new DisconnectPacket;
                $pk->message = $reason;
                $this->directDataPacket($pk);
            }

            //$this->setLinked();

            if ($this->fishingHook instanceof FishingHook) {
                $this->fishingHook->close();
                $this->fishingHook = null;
            }

            $this->removeEffect(Effect::HEALTH_BOOST);

            $this->connected = false;
            if (strlen($this->getName()) > 0) {
                $this->server->getPluginManager()->callEvent($ev = new PlayerQuitEvent($this, $message, true));
                if ($this->loggedIn === true and $ev->getAutoSave()) {
                    $this->save();
                }
            }

            foreach ($this->server->getOnlinePlayers() as $player) {
                if (!$player->canSee($this)) {
                    $player->showPlayer($this);
                }
            }
            $this->hiddenPlayers = [];

            foreach ($this->windowIndex as $window) {
                $this->removeWindow($window);
            }

            foreach ($this->usedChunks as $index => $d) {
                Level::getXZ($index, $chunkX, $chunkZ);
                $this->level->unregisterChunkLoader($this, $chunkX, $chunkZ);
                unset($this->usedChunks[$index]);
            }

            parent::close();

            $this->interface->close($this, $notify ? $reason : "");

            if ($this->loggedIn) {
                $this->server->removeOnlinePlayer($this);
            }

            $this->loggedIn = false;

            if (isset($ev) and $this->username != "" and $this->spawned !== false and $ev->getQuitMessage() != "") {
                if ($this->server->playerMsgType === Server::PLAYER_MSG_TYPE_MESSAGE) $this->server->broadcastMessage($ev->getQuitMessage());
                elseif ($this->server->playerMsgType === Server::PLAYER_MSG_TYPE_TIP) $this->server->broadcastTip(str_replace("@player", $this->getName(), $this->server->playerLogoutMsg));
                elseif ($this->server->playerMsgType === Server::PLAYER_MSG_TYPE_POPUP) $this->server->broadcastPopup(str_replace("@player", $this->getName(), $this->server->playerLogoutMsg));
            }

            $this->server->getPluginManager()->unsubscribeFromPermission(Server::BROADCAST_CHANNEL_USERS, $this);
            $this->spawned = false;
            $this->server->getLogger()->info($this->getServer()->getLanguage()->translateString("pocketmine.player.logOut", [
                TextFormat::AQUA . $this->getName() . TextFormat::WHITE,
                $this->ip,
                $this->port,
                $this->getServer()->getLanguage()->translateString($reason)
            ]));
            $this->windows = new \SplObjectStorage();
            $this->windowIndex = [];
            $this->usedChunks = [];
            $this->loadQueue = [];
            $this->hasSpawned = [];
            $this->spawnPosition = null;
            unset($this->buffer);

            if ($this->server->dserverConfig["enable"] and $this->server->dserverConfig["queryAutoUpdate"]) $this->server->updateQuery();
        }

        if ($this->perm !== null) {
            $this->perm->clearPermissions();
            $this->perm = null;
        }

        if ($this->inventory !== null) {
            $this->inventory = null;
            $this->currentTransaction = null;
        }

        $this->chunk = null;

        $this->server->removePlayer($this);
    }

    public function __debugInfo()
    {
        return [];
    }

    /**
     * Handles player data saving
     */
    public function save($async = false)
    {
        if ($this->closed) {
            throw new \InvalidStateException("Tried to save closed player");
        }

        parent::saveNBT();
        if ($this->level instanceof Level) {
            $this->namedtag->Level = new StringTag("Level", $this->level->getName());
            if ($this->spawnPosition instanceof Position and $this->spawnPosition->getLevel() instanceof Level and $this->spawnPosition->getLevel()->getProvider() !== NULL) {
                $this->namedtag["SpawnLevel"] = $this->spawnPosition->getLevel()->getName();
                $this->namedtag["SpawnX"] = (int)$this->spawnPosition->x;
                $this->namedtag["SpawnY"] = (int)$this->spawnPosition->y;
                $this->namedtag["SpawnZ"] = (int)$this->spawnPosition->z;
            }

            foreach ($this->achievements as $achievement => $status) {
                $this->namedtag->Achievements[$achievement] = new ByteTag($achievement, $status === true ? 1 : 0);
            }

            $this->namedtag["playerGameType"] = $this->gamemode;
            $this->namedtag["lastPlayed"] = new LongTag("lastPlayed", floor(microtime(true) * 1000));
            $this->namedtag["Hunger"] = new ShortTag("Hunger", $this->food);
            $this->namedtag["Health"] = new ShortTag("Health", $this->getHealth());
            $this->namedtag["MaxHealth"] = new ShortTag("MaxHealth", $this->getMaxHealth());
            $this->namedtag["Experience"] = new LongTag("Experience", $this->exp);
            $this->namedtag["ExpLevel"] = new LongTag("ExpLevel", $this->expLevel);

            if ($this->username != "" and $this->namedtag instanceof CompoundTag) {
                $this->server->saveOfflinePlayerData($this->username, $this->namedtag, $async);
            }
        }
    }

    /**
     * Gets the username
     *
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }

    public function kill()
    {
        if (!$this->spawned) {
            return;
        }

        $message = "death.attack.generic";

        $params = [
            $this->getName()
        ];

        $cause = $this->getLastDamageCause();

        switch ($cause === null ? EntityDamageEvent::CAUSE_CUSTOM : $cause->getCause()) {
            case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
                if ($cause instanceof EntityDamageByEntityEvent) {
                    $e = $cause->getDamager();
                    if ($e instanceof Player) {
                        $message = "death.attack.player";
                        $params[] = $e->getName();
                        break;
                    } elseif ($e instanceof Living) {
                        $message = "death.attack.mob";
                        $params[] = $e->getNameTag() !== "" ? $e->getNameTag() : $e->getName();
                        break;
                    } else {
                        $params[] = "Unknown";
                    }
                }
                break;
            case EntityDamageEvent::CAUSE_PROJECTILE:
                if ($cause instanceof EntityDamageByEntityEvent) {
                    $e = $cause->getDamager();
                    if ($e instanceof Player) {
                        $message = "death.attack.arrow";
                        $params[] = $e->getName();
                    } elseif ($e instanceof Living) {
                        $message = "death.attack.arrow";
                        $params[] = $e->getNameTag() !== "" ? $e->getNameTag() : $e->getName();
                        break;
                    } else {
                        $params[] = "Unknown";
                    }
                }
                break;
            case EntityDamageEvent::CAUSE_SUICIDE:
                $message = "death.attack.generic";
                break;
            case EntityDamageEvent::CAUSE_VOID:
                $message = "death.attack.outOfWorld";
                break;
            case EntityDamageEvent::CAUSE_FALL:
                if ($cause instanceof EntityDamageEvent) {
                    if ($cause->getFinalDamage() > 2) {
                        $message = "death.fell.accident.generic";
                        break;
                    }
                }
                $message = "death.attack.fall";
                break;

            case EntityDamageEvent::CAUSE_SUFFOCATION:
                $message = "death.attack.inWall";
                break;

            case EntityDamageEvent::CAUSE_LAVA:
                $message = "death.attack.lava";
                break;

            case EntityDamageEvent::CAUSE_FIRE:
                $message = "death.attack.onFire";
                break;

            case EntityDamageEvent::CAUSE_FIRE_TICK:
                $message = "death.attack.inFire";
                break;

            case EntityDamageEvent::CAUSE_DROWNING:
                $message = "death.attack.drown";
                break;

            case EntityDamageEvent::CAUSE_CONTACT:
                if ($cause instanceof EntityDamageByBlockEvent) {
                    if ($cause->getDamager()->getId() === Block::CACTUS) {
                        $message = "death.attack.cactus";
                    }
                }
                break;

            case EntityDamageEvent::CAUSE_BLOCK_EXPLOSION:
            case EntityDamageEvent::CAUSE_ENTITY_EXPLOSION:
                if ($cause instanceof EntityDamageByEntityEvent) {
                    $e = $cause->getDamager();
                    if ($e instanceof Player) {
                        $message = "death.attack.explosion.player";
                        $params[] = $e->getName();
                    } elseif ($e instanceof Living) {
                        $message = "death.attack.explosion.player";
                        $params[] = $e->getNameTag() !== "" ? $e->getNameTag() : $e->getName();
                        break;
                    }
                } else {
                    $message = "death.attack.explosion";
                }
                break;

            case EntityDamageEvent::CAUSE_MAGIC:
                $message = "death.attack.magic";
                break;

            case EntityDamageEvent::CAUSE_CUSTOM:
                break;

            default:

        }

        Entity::kill();

        $this->server->getPluginManager()->callEvent($ev = new PlayerDeathEvent($this, $this->getDrops(), new TranslationContainer($message, $params)));

        if (!$ev->getKeepInventory() and !$this->server->keepInventory) {
            foreach ($ev->getDrops() as $item) {
                $this->level->dropItem($this, $item);
            }

            if ($this->inventory !== null) {
                $this->inventory->clearAll();
            }
        }

        if ($this->server->expEnabled and (!$ev->getKeepExperience() and !$this->server->keepInventory)) {
            $exp = $this->getExp();
            if ($exp > 100) $exp = 100;
            $this->getLevel()->spawnXPOrb($this->add(0, 0.2, 0), $exp);
            $this->setExperienceAndLevel(0, 0);
        }

        if ($ev->getDeathMessage() != "") {
            $this->server->broadcast($ev->getDeathMessage(), Server::BROADCAST_CHANNEL_USERS);
        }

        $pos = $this->getSpawn();

        if ($this->server->netherEnabled) {
            if ($this->level == $this->server->netherLevel) {
                $this->teleport($pos = $this->server->getDefaultLevel()->getSafeSpawn());
            }
        }

        $this->setHealth(0);

        $pk = new RespawnPacket();
        $pk->x = $pos->x;
        $pk->y = $pos->y;
        $pk->z = $pos->z;
        $this->dataPacket($pk);
    }

    public function setHealth($amount)
    {
        parent::setHealth($amount);
        if ($this->spawned === true) {
            $this->foodTick = 0;
            $this->getAttributeMap()->getAttribute(Attribute::HEALTH)->setMaxValue($this->getMaxHealth())->setValue($amount, true);
        }
    }

    protected $movementSpeed = 0.1;

    /**
     * Set movement speed to the player
     *
     * @param $amount
     */
    public function setMovementSpeed($amount)
    {
        $this->movementSpeed = $amount;
        $this->getAttributeMap()->getAttribute(Attribute::MOVEMENT_SPEED)->setValue($amount);
    }

    /**
     * Get movement speed of the player
     *
     * @return float
     */
    public function getMovementSpeed()
    {
        return $this->movementSpeed;
    }

    protected $food = 20;

    protected $foodDepletion = 0;

    protected $foodEnabled = true;

    public function setFoodEnabled($enabled)
    {
        $this->foodEnabled = $enabled;
    }

    public function getFoodEnabled()
    {
        return $this->foodEnabled;
    }

    public function setFood(float $amount)
    {
        if (!$this->server->foodEnabled) $amount = 20;
        if ($amount > 20) $amount = 20;
        if ($amount < 0) $amount = 0;
        $this->server->getPluginManager()->callEvent($ev = new PlayerHungerChangeEvent($this, $amount));

        if ($ev->isCancelled()) return false;

        $amount = $ev->getData();

        if ($amount <= 6 && !($this->getFood() <= 6)) {
            $this->setDataProperty(self::DATA_FLAG_SPRINTING, self::DATA_TYPE_BYTE, false);
        } elseif ($amount > 6 && !($this->getFood() > 6)) {
            $this->setDataProperty(self::DATA_FLAG_SPRINTING, self::DATA_TYPE_BYTE, true);
        }

        $this->food = $amount;
        $this->getAttributeMap()->getAttribute(Attribute::HUNGER)->setValue($amount);

        return true;
    }

    public function getFood(): float
    {
        return $this->food;
    }

    public function subtractFood($amount)
    {
        if ($this->getFood() - $amount <= 6 && !($this->getFood() <= 6)) {
            $this->setDataProperty(self::DATA_FLAG_SPRINTING, self::DATA_TYPE_BYTE, false);
            //$this->removeEffect(Effect::SLOWNESS);
        } elseif ($this->getFood() - $amount < 6 && !($this->getFood() > 6)) {
            $this->setDataProperty(self::DATA_FLAG_SPRINTING, self::DATA_TYPE_BYTE, true);
            /*$effect = Effect::getEffect(Effect::SLOWNESS);
			$effect->setDuration(0x7fffffff);
			$effect->setAmplifier(2);
			$effect->setVisible(false);
			$this->addEffect($effect);*/
        }
        if ($this->food - $amount < 0) return;
        $this->setFood($this->getFood() - $amount);
    }

    public function attack($damage, EntityDamageEvent $source)
    {
        if (!$this->isAlive()) {
            return false;
        }

        if ($this->isCreative() and $source->getCause() !== EntityDamageEvent::CAUSE_SUICIDE and $source->getCause() !== EntityDamageEvent::CAUSE_VOID) {
            $source->setCancelled();
        } elseif ($this->allowFlight and $source->getCause() === EntityDamageEvent::CAUSE_FALL) {
            $source->setCancelled();
        }

        parent::attack($damage, $source);

        if ($source->isCancelled()) {
            return false;
        } elseif ($this->getLastDamageCause() === $source and $this->spawned) {
            $pk = new EntityEventPacket();
            $pk->eid = 0;
            $pk->event = EntityEventPacket::HURT_ANIMATION;
            $this->dataPacket($pk);
        }
        return true;
    }

    public function sendPosition(Vector3 $pos, $yaw = null, $pitch = null, $mode = 0, array $targets = null)
    {
        $yaw = $yaw === null ? $this->yaw : $yaw;
        $pitch = $pitch === null ? $this->pitch : $pitch;

        $pk = new MovePlayerPacket();
        $pk->eid = $this->getId();
        $pk->x = $pos->x;
        $pk->y = $pos->y + $this->getEyeHeight();
        $pk->z = $pos->z;
        $pk->bodyYaw = $yaw;
        $pk->pitch = $pitch;
        $pk->yaw = $yaw;
        $pk->mode = $mode;

        if ($targets !== null) {
            Server::broadcastPacket($targets, $pk);
        } else {
            $pk->eid = 0;
            $this->dataPacket($pk);
        }
    }

    protected function checkChunks()
    {
        if ($this->chunk === null or ($this->chunk->getX() !== ($this->x >> 4) or $this->chunk->getZ() !== ($this->z >> 4))) {
            if ($this->chunk !== null) {
                $this->chunk->removeEntity($this);
            }
            $this->chunk = $this->level->getChunk($this->x >> 4, $this->z >> 4, true);

            if (!$this->justCreated) {
                $newChunk = $this->level->getChunkPlayers($this->x >> 4, $this->z >> 4);
                unset($newChunk[$this->getLoaderId()]);

                /** @var Player[] $reload */
                $reload = [];
                foreach ($this->hasSpawned as $player) {
                    if (!isset($newChunk[$player->getLoaderId()])) {
                        $this->despawnFrom($player);
                    } else {
                        unset($newChunk[$player->getLoaderId()]);
                        $reload[] = $player;
                    }
                }

                foreach ($newChunk as $player) {
                    $this->spawnTo($player);
                }
            }

            if ($this->chunk === null) {
                return;
            }

            $this->chunk->addEntity($this);
        }
    }

    protected function checkTeleportPosition()
    {
        if ($this->teleportPosition !== null) {
            $chunkX = $this->teleportPosition->x >> 4;
            $chunkZ = $this->teleportPosition->z >> 4;

            for ($X = -1; $X <= 1; ++$X) {
                for ($Z = -1; $Z <= 1; ++$Z) {
                    if (!isset($this->usedChunks[$index = Level::chunkHash($chunkX + $X, $chunkZ + $Z)]) or $this->usedChunks[$index] === false) {
                        return false;
                    }
                }
            }

            $this->sendPosition($this, null, null, 1);
            $this->spawnToAll();
            $this->forceMovement = $this->teleportPosition;
            $this->teleportPosition = null;

            return true;
        }

        return true;
    }

    /**
     * @param Vector3|Position|Location $pos
     * @param float $yaw
     * @param float $pitch
     *
     * @return bool
     */
    public function teleport(Vector3 $pos, $yaw = null, $pitch = null)
    {
        if (!$this->isOnline()) {
            return false;
        }

        $oldPos = $this->getPosition();
        if (parent::teleport($pos, $yaw, $pitch)) {

            foreach ($this->windowIndex as $window) {
                if ($window === $this->inventory) {
                    continue;
                }
                $this->removeWindow($window);
            }

            $this->teleportPosition = new Vector3($this->x, $this->y, $this->z);

            if (!$this->checkTeleportPosition()) {
                $this->forceMovement = $oldPos;
            } else {
                $this->spawnToAll();
            }


            $this->resetFallDistance();
            $this->nextChunkOrderRun = 0;
            $this->newPosition = null;
            return true;
        }
        return false;
    }

    /**
     * This method may not be reliable. Clients don't like to be moved into unloaded chunks.
     * Use teleport() for a delayed teleport after chunks have been sent.
     *
     * @param Vector3 $pos
     * @param float $yaw
     * @param float $pitch
     */
    public function teleportImmediate(Vector3 $pos, $yaw = null, $pitch = null)
    {
        if (parent::teleport($pos, $yaw, $pitch)) {

            foreach ($this->windowIndex as $window) {
                if ($window === $this->inventory) {
                    continue;
                }
                $this->removeWindow($window);
            }

            $this->forceMovement = new Vector3($this->x, $this->y, $this->z);
            $this->sendPosition($this, $this->yaw, $this->pitch, 1);


            $this->resetFallDistance();
            $this->orderChunks();
            $this->nextChunkOrderRun = 0;
            $this->newPosition = null;
        }
    }


    /**
     * @param Inventory $inventory
     *
     * @return int
     */
    public function getWindowId(Inventory $inventory): int
    {
        if ($this->windows->contains($inventory)) {
            return $this->windows[$inventory];
        }

        return -1;
    }

    /**
     * Returns the created/existing window id
     *
     * @param Inventory $inventory
     * @param int $forceId
     *
     * @return int
     */
    public function addWindow(Inventory $inventory, int $forceId = null): int
    {
        if ($this->windows->contains($inventory)) {
            return $this->windows[$inventory];
        }

        if ($forceId === null) {
            $this->windowCnt = $cnt = max(2, ++$this->windowCnt % 99);
        } else {
            $cnt = (int)$forceId;
        }
        $this->windowIndex[$cnt] = $inventory;
        $this->windows->attach($inventory, $cnt);
        if ($inventory->open($this)) {
            return $cnt;
        } else {
            $this->removeWindow($inventory);

            return -1;
        }
    }

    public function removeWindow(Inventory $inventory)
    {
        $inventory->close($this);
        if ($this->windows->contains($inventory)) {
            $id = $this->windows[$inventory];
            $this->windows->detach($this->windowIndex[$id]);
            unset($this->windowIndex[$id]);
        }
    }

    public function setMetadata($metadataKey, MetadataValue $metadataValue)
    {
        $this->server->getPlayerMetadata()->setMetadata($this, $metadataKey, $metadataValue);
    }

    public function getMetadata($metadataKey)
    {
        return $this->server->getPlayerMetadata()->getMetadata($this, $metadataKey);
    }

    public function hasMetadata($metadataKey)
    {
        return $this->server->getPlayerMetadata()->hasMetadata($this, $metadataKey);
    }

    public function removeMetadata($metadataKey, Plugin $plugin)
    {
        $this->server->getPlayerMetadata()->removeMetadata($this, $metadataKey, $plugin);
    }


    public function onChunkChanged(FullChunk $chunk)
    {
        $this->loadQueue[Level::chunkHash($chunk->getX(), $chunk->getZ())] = abs(($this->x >> 4) - $chunk->getX()) + abs(($this->z >> 4) - $chunk->getZ());
    }

    public function onChunkLoaded(FullChunk $chunk)
    {

    }

    public function onChunkPopulated(FullChunk $chunk)
    {

    }

    public function onChunkUnloaded(FullChunk $chunk)
    {

    }

    public function onBlockChanged(Vector3 $block)
    {

    }

    public function getLoaderId()
    {
        return $this->loaderId;
    }

    public function isLoaderActive()
    {
        return $this->isConnected();
    }

    /**
     * @param     $chunkX
     * @param     $chunkZ
     * @param     $payload
     * @param int $ordering
     * @return BatchPacket|FullChunkDataPacket
     */
    public static function getChunkCacheFromData($chunkX, $chunkZ, $payload, $ordering = FullChunkDataPacket::ORDER_COLUMNS)
    {
        $pk = new FullChunkDataPacket();
        $pk->chunkX = $chunkX;
        $pk->chunkZ = $chunkZ;
        $pk->order = $ordering;
        $pk->data = $payload;
        if (Network::$BATCH_THRESHOLD >= 0) {
            $pk->encode();
            $batch = new BatchPacket();
            $batch->payload = zlib_encode(Binary::writeInt(strlen($pk->getBuffer())) . $pk->getBuffer(), ZLIB_ENCODING_DEFLATE, Server::getInstance()->networkCompressionLevel);
            $batch->encode();
            $batch->isEncoded = true;
            return $batch;
        }
        return $pk;
    }


}
